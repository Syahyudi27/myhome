<?php

namespace App\Filament\Resources\ListingTypes\Pages;

use App\Filament\Resources\ListingTypes\ListingTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListListingTypes extends ListRecords
{
    protected static string $resource = ListingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
