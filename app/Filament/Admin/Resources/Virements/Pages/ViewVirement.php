<?php

namespace App\Filament\Admin\Resources\Virements\Pages;

use App\Filament\Admin\Resources\Virements\VirementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVirement extends ViewRecord
{
    protected static string $resource = VirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
