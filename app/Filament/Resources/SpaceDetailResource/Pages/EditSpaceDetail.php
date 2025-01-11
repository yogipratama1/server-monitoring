<?php

namespace App\Filament\Resources\SpaceDetailResource\Pages;

use App\Filament\Resources\SpaceDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpaceDetail extends EditRecord
{
    protected static string $resource = SpaceDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
