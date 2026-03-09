<?php

namespace App\Filament\Admin\Resources\CarteBancaires\Pages;

use App\Filament\Admin\Resources\CarteBancaires\CarteBancaireResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCarteBancaire extends ViewRecord
{
    protected static string $resource = CarteBancaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
