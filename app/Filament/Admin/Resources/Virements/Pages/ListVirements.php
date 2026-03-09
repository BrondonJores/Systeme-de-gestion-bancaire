<?php

namespace App\Filament\Admin\Resources\Virements\Pages;

use App\Filament\Admin\Resources\Virements\VirementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVirements extends ListRecords
{
    protected static string $resource = VirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
