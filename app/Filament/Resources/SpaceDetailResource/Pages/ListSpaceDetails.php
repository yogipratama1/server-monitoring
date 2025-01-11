<?php

namespace App\Filament\Resources\SpaceDetailResource\Pages;

use App\Filament\Resources\SpaceDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpaceDetails extends ListRecords
{
    protected static string $resource = SpaceDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
