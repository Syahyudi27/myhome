<?php

namespace App\Filament\Resources\ListingTypes\Pages;

use App\Filament\Resources\ListingTypes\ListingTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditListingType extends EditRecord
{
    protected static string $resource = ListingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
