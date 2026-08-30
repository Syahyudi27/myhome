<?php

namespace App\Filament\Resources\MortgageRequests;

use App\Filament\Resources\MortgageRequests\Pages\CreateMortgageRequest;
use App\Filament\Resources\MortgageRequests\Pages\EditMortgageRequest;
use App\Filament\Resources\MortgageRequests\Pages\ListMortgageRequests;
use App\Filament\Resources\MortgageRequests\Schemas\MortgageRequestForm;
use App\Filament\Resources\MortgageRequests\Tables\MortgageRequestsTable;
use App\Models\Interest;
use App\Models\MortgageRequest;
use BackedEnum;
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

                                ])
                        ])
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
            //
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
