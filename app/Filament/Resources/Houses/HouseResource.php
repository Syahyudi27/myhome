<?php

namespace App\Filament\Resources\Houses;

use App\Filament\Resources\Houses\Pages\CreateHouse;
use App\Filament\Resources\Houses\Pages\EditHouse;
use App\Filament\Resources\Houses\Pages\ListHouses;
use App\Filament\Resources\Houses\Tables\HousesTable;
use App\Models\House;
use BackedEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\Summarizers\Sum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;
// Import Component untuk Filament v4 / v5
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class HouseResource extends Resource
{
    protected static ?string $model = House::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home-modern';

    protected static string|UnitEnum|null $navigationGroup = 'Products';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('HouseDetails')
                    ->tabs([
                        // TAB 1: INFORMASI UTAMA
                        Tab::make('Informasi Utama')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Hidden::make('user_id'),

                                FileUpload::make('thumbnail')
                                            ->label('thumbnail')
                                            ->image()
                                            ->helperText('Contoh: Gunakan foto tampak depan rumah (facade) dengan pencahayaan terang/pagi hari. Hindari foto blur atau foto ruangan dalam.')    
                                            ->directory('houses/thumbnail')
                                            ->required()
                                            ->columnSpanFull(),


                                Select::make('category_id')
                                    ->label('Kategori Properti')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('listing_type')
                                    ->label('Tipe Iklan')
                                    ->options([
                                        'sale' => 'Dijual',
                                        'rent' => 'Disewakan',
                                    ])
                                    ->required(),

                                TextInput::make('name')
                                    ->label('Nama Properti')
                                    ->placeholder('Contoh: Rumah Minimalis Modern Cluster A')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->readOnly()
                                    ->extraAttributes(['class' => 'bg-gray-100 text-gray-500 cursor-not-allowed'])
                                    ->unique(ignoreRecord: true),

                                TextInput::make('price')
                                    ->label('Harga Properti')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ])->columns(2),

                        // TAB 2: SPESIFIKASI & LEGALITAS
                        Tab::make('Spesifikasi & Legalitas')
                            ->icon('heroicon-o-home')
                            ->schema([
                                TextInput::make('bedroom')
                                    ->label('Kamar Tidur')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('bathroom')
                                    ->label('Kamar Mandi')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('garage')
                                    ->label('Kapasitas Garasi')
                                    ->numeric()
                                    ->default(0),

                                TextInput::make('floors')
                                    ->label('Jumlah Lantai')
                                    ->numeric()
                                    ->default(1),

                                TextInput::make('land_area')
                                    ->label('Luas Tanah')
                                    ->numeric()
                                    ->suffix('m²')
                                    ->required(),

                                TextInput::make('building_area')
                                    ->label('Luas Bangunan')
                                    ->numeric()
                                    ->suffix('m²')
                                    ->required(),

                                TextInput::make('electric')
                                    ->label('Daya Listrik')
                                    ->numeric()
                                    ->suffix('Watt')
                                    ->required(),

                                TextInput::make('certificate')
                                    ->label('Sertifikat')
                                    ->placeholder('SHM / HGB / DLL')
                                    ->required(),

                                Select::make('furnishing')
                                    ->label('Kondisi Perabotan')
                                    ->options([
                                        'unfurnished' => 'Unfurnished (Kosongan)',
                                        'semi_furnished' => 'Semi Furnished',
                                        'fully_furnished' => 'Fully Furnished',
                                    ])
                                    ->default('unfurnished')
                                    ->required(),
                            ])->columns(3),

                        // TAB 3: LOKASI PROPERTI
                        Tab::make('Lokasi')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Select::make('city_id')
                                    ->label('Kota / Kabupaten')
                                    ->relationship('city', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                TextInput::make('latitude')
                                    ->numeric()
                                    ->placeholder('Contoh: -6.20000000'),

                                TextInput::make('longitude')
                                    ->numeric()
                                    ->placeholder('Contoh: 106.81666670'),
                            ])->columns(2),

                        // TAB 4: MEDIA, DESKRIPSI & STATUS
                        Tab::make('Media & Deskripsi')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Repeater::make('photos')
                                    ->label('Galeri Foto Properti (Bisa Banyak Foto)')
                                    ->relationship('photos') // Nama fungsi relasi hasMany di Model House
                                    ->schema([
                                        FileUpload::make('photo')
                                            ->label('Foto Galeri')
                                            ->image()
                                            ->directory('houses/photos')
                                            ->required(),
                                    ])
                                    ->grid(2) // Menampilkan input foto berjejer 2 kolom
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Foto Lainnya')
                                    ->columnSpanFull(),

                                Textarea::make('about')
                                    ->label('Deskripsi Properti')
                                    ->rows(5)
                                    ->columnSpanFull(),

                                Select::make('status')
                                    ->label('Status Ketersediaan')
                                    ->options([
                                        'available' => 'Available (Tersedia)',
                                        'booked' => 'Booked (Dipesan)',
                                        'sold' => 'Sold (Terjual)',
                                    ])
                                    ->default('available')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
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