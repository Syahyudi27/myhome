<?php

namespace App\Filament\Resources\Facilities;

use App\Filament\Resources\Facilities\Pages\CreateFacility;
use App\Filament\Resources\Facilities\Pages\EditFacility;
use App\Filament\Resources\Facilities\Pages\ListFacilities;
use App\Filament\Resources\Facilities\Schemas\FacilityForm;
use App\Filament\Resources\Facilities\Tables\FacilitiesTable;
use App\Models\Facility;
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

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

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
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('photo')
                            ->required()
                            ->image()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',

                            ])
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return FacilitiesTable::configure($table);
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
            'index' => ListFacilities::route('/'),
            'create' => CreateFacility::route('/create'),
            'edit' => EditFacility::route('/{record}/edit'),
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
