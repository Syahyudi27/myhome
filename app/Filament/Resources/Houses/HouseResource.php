<?php

namespace App\Filament\Resources\Houses;

use App\Filament\Resources\Houses\Pages\CreateHouse;
use App\Filament\Resources\Houses\Pages\EditHouse;
use App\Filament\Resources\Houses\Pages\ListHouses;
use App\Filament\Resources\Houses\Schemas\HouseForm;
use App\Filament\Resources\Houses\Tables\HousesTable;
use App\Models\House;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\Select;

class HouseResource extends Resource
{
    protected static ?string $model = House::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Informasi Kategori')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255)
                            ->required(),

                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),

                        Select::make('certificate')
                            ->options([
                                'SHM' => 'SHM',
                                'SHGB' => 'SHGB',
                            ]),

                        FileUpload::make('thumnail')
                            ->required()
                            ->image()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',

                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return HousesTable::configure($table);
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
            'index' => ListHouses::route('/'),
            'create' => CreateHouse::route('/create'),
            'edit' => EditHouse::route('/{record}/edit'),
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
