<?php

namespace App\Filament\Resources\MortgageRequests;

use App\Filament\Resources\MortgageRequests\Pages\CreateMortgageRequest;
use App\Filament\Resources\MortgageRequests\Pages\EditMortgageRequest;
use App\Filament\Resources\MortgageRequests\Pages\ListMortgageRequests;
use App\Filament\Resources\MortgageRequests\RelationManagers\InstallmentsRelationManager;
use App\Filament\Resources\MortgageRequests\Schemas\MortgageRequestForm;
use App\Filament\Resources\MortgageRequests\Tables\MortgageRequestsTable;
use App\Models\Interest;
use App\Models\MortgageRequest;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;

class MortgageRequestResource extends Resource
{
    protected static ?string $model = MortgageRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Product And Price')
                        ->schema([
                            Grid::make(3)
                                ->schema([ // Perbaikan 1: Grid membungkus isinya dengan schema([])
                                    Select::make('house_id')
                                        ->label('House') // Perbaikan 2: >label menjadi ->label
                                        ->options(\App\Models\House::query()->pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $house = \App\Models\House::find($state);
                                            if ($house) {
                                                $set('house_price', $house->price ?? 0);
                                            }
                                        }),

                                    Select::make('interest_id')
                                        ->label('Interest in %')
                                        ->validationMessages([
                                            'required' => "Durasi Harus Diisi"
                                        ])
                                        ->options(function (callable $get) {
                                            $houseId = $get('house_id');
                                            if ($houseId) {
                                                return Interest::where('house_id', $houseId)
                                                    ->get()
                                                    ->pluck('interest', 'id');
                                            }
                                            return [];
                                        })
                                        ->preload()
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $interest = \App\Models\Interest::find($state);
                                            if ($interest) {
                                                $set('bank_name', $interest->bank->name ?? '');
                                                $set('interest', $interest->interest);
                                                $set('duration', $interest->duration);
                                            }
                                        }),

                                    // Bank Name Field (Read-Only)
                                    TextInput::make('bank_name')
                                        ->label('Bank Name')
                                        ->required()
                                        ->readOnly(),

                                    // Duration Field (Read-Only)
                                    TextInput::make('duration')
                                        ->label('Duration in Years')
                                        ->required()
                                        ->readOnly()
                                        ->numeric()
                                        ->suffix('Years'),

                                    // Interest Field (Read-Only)
                                    TextInput::make('interest')
                                        ->label('Interest Rate')
                                        ->required()
                                        ->readOnly()
                                        ->numeric()
                                        ->suffix('%'),

                                    TextInput::make('house_price')
                                        ->label('House Price')
                                        ->required()
                                        ->readOnly()
                                        ->numeric()
                                        ->prefix('IDR'),

                                    Select::make('dp_percentage')
                                        ->label('Down Payment ( % )')
                                        ->options([
                                            5 => '5%',
                                            10 => '10%',
                                            15 => '15%',
                                            20 => '20%',
                                            40 => '40%',
                                            50 => '50%',
                                            60 => '60%',
                                            80 => '80%',
                                        ])
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                            $housePrice = $get('house_price') ?? 0;
                                            $dpAmount = ($state / 100) * $housePrice; // Calculate down payment amount
                                            $loanAmount = max($housePrice - $dpAmount, 0); // Calculate loan amount

                                            $set('dp_total_amount', round($dpAmount));
                                            $set('loan_total_amount', round($loanAmount));

                                            //calculate mounthly payment
                                            $durationYears = $get('duration') ?? 0;
                                            $interestRate = $get('interest') ?? 0;

                                            if ($durationYears > 0 && $loanAmount > 0 && $interestRate > 0) {
                                                $totalPayments = $durationYears * 12; // Total number of payments
                                                $monthlyInterestRate = $interestRate / 100 / 12; // Monthly interest rate

                                                // Amortization formula
                                                $numerator = $loanAmount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $totalPayments);
                                                $denominator = pow(1 + $monthlyInterestRate, $totalPayments) - 1;
                                                $monthlyPayment = $denominator > 0 ? $numerator / $denominator : 0;

                                                $set('monthly_amount', round($monthlyPayment));

                                                /** @var int|float $loanInterestTotalAmount */
                                                $loanInterestTotalAmount = $monthlyPayment * $totalPayments;
                                                $set('loan_interest_total_amount', round($loanInterestTotalAmount));
                                            } else {
                                                $set('monthly_amount', 0);
                                                $set('loan_interest_total_amount', 0);
                                            }
                                        }),

                                    TextInput::make('dp_total_amount')
                                        ->label('Down Payment Amount')
                                        ->readOnly()
                                        ->numeric()
                                        ->prefix('IDR'),

                                    TextInput::make('loan_total_amount')
                                        ->label('Loan Amount')
                                        ->readOnly()
                                        ->required()
                                        ->numeric()
                                        ->prefix('IDR'),

                                    TextInput::make('monthly_amount')
                                        ->label('Mouthly Payemnt')
                                        ->readOnly()
                                        ->required()
                                        ->numeric()
                                        ->prefix('IDR'),

                                    TextInput::make('loan_interest_total_amount')
                                        ->label('Total Payment Amount')
                                        ->readOnly()
                                        ->numeric()
                                        ->prefix('IDR')


                                ])
                        ]),

                    Step::make('Customer Information')
                        ->schema([
                            Select::make("user_id")
                                ->relationship('customer', 'email')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $user = User::find($state);
                                    $name = $user->name;
                                    $email = $user->email;
                                    $set('name', $name);
                                    $set('email', $email);
                                })
                                ->afterStateHydrated(function ($state, callable $set) {
                                    $userId = $state;
                                    if ($userId) {
                                        $user = User::find($userId);
                                        $name = $user->name;
                                        $email = $user->email;
                                        $set('name', $name);
                                        $set('email', $email);
                                    }
                                }),
                            TextInput::make('name')
                                ->required()
                                ->readOnly()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->required()
                                ->readOnly()
                                ->maxLength(255),
                        ]),

                    Step::make('BANK APPROVEL')
                        ->schema([
                            FileUpload::make('documents')
                                ->acceptedFileTypes(['application/pdf']),
                            Select::make('status')
                                ->label('Approval Status')
                                ->options([
                                    'wating for bank' => 'Waiting for Bank',
                                    'approved' => 'Approved',
                                    'reject' => 'Reject'
                                ])
                                ->required(),
                            
                        ]),
                ])
                    ->columnSpan('full')
                    ->columns(1)
                    ->skippable()
            ]);
    }
    public static function table(Table $table): Table
    {
        return MortgageRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InstallmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMortgageRequests::route('/'),
            'create' => CreateMortgageRequest::route('/create'),
            'edit' => EditMortgageRequest::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
