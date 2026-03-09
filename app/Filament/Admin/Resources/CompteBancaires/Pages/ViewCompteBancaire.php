<?php

namespace App\Filament\Admin\Resources\CompteBancaires\Pages;

use App\Filament\Admin\Resources\CompteBancaires\CompteBancaireResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCompteBancaire extends ViewRecord
{
    protected static string $resource = CompteBancaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
