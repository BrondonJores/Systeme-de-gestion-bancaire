<?php

namespace App\Filament\Admin\Resources\CarteBancaires\Pages;

use App\Filament\Admin\Resources\CarteBancaires\CarteBancaireResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCarteBancaire extends EditRecord
{
    protected static string $resource = CarteBancaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
