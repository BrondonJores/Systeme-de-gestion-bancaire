<?php

namespace App\Filament\Admin\Resources\CarteBancaires\Pages;

use App\Filament\Admin\Resources\CarteBancaires\CarteBancaireResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCarteBancaires extends ListRecords
{
    protected static string $resource = CarteBancaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
