<?php

namespace App\Filament\Admin\Resources\Virements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VirementsTable
{
    public static function configure(Table $table): Table
    {
        $table = $table
            ->columns([
                TextColumn::make('compteEmetteur.rib')->label('Émetteur')->searchable(),
                TextColumn::make('compteDestinataire.rib')->label('Destinataire')->searchable(),
                TextColumn::make('montant')->money('MAD', true)->sortable(),
                TextColumn::make('type')->searchable()->badge(),
                TextColumn::make('statut')->searchable()->badge(),
                TextColumn::make('reference')->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

        return $table;
    }
}
