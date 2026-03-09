<?php

namespace App\Filament\Admin\Resources\CompteBancaires\Pages;

use App\Filament\Admin\Resources\CompteBancaires\CompteBancaireResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompteBancaires extends ListRecords
{
    protected static string $resource = CompteBancaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
