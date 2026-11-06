<?php

namespace App\Filament\Resources\ListingTypes;

use App\Filament\Resources\ListingTypes\Pages\CreateListingType;
use App\Filament\Resources\ListingTypes\Pages\EditListingType;
use App\Filament\Resources\ListingTypes\Pages\ListListingTypes;
use App\Filament\Resources\ListingTypes\Schemas\ListingTypeForm;
use App\Filament\Resources\ListingTypes\Tables\ListingTypesTable;
use App\Models\ListingType;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Str;
use UnitEnum;

class ListingTypeResource extends Resource
{
    protected static ?string $model = ListingType::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = 'Management';

    protected static ?string $recordTitleAttribute = 'yes';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Informasi Kategori')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255)
                            ->required()
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                             ->columnSpanFull()
                            ->unique(ignoreRecord: true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return ListingTypesTable::configure($table);
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
            'index' => ListListingTypes::route('/'),
            'create' => CreateListingType::route('/create'),
            'edit' => EditListingType::route('/{record}/edit'),
        ];
    }
}
