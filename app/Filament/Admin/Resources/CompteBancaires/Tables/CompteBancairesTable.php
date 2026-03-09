<?php

namespace App\Filament\Admin\Resources\CompteBancaires\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
class CompteBancairesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rib')->searchable(),
                TextColumn::make('type')->searchable(),
                TextColumn::make('solde')->money('MAD', true)->sortable(),
                TextColumn::make('statut')->searchable(),
                TextColumn::make('proprietaire.name')->label('Client')->searchable(),
                IconColumn::make('has_interest')->boolean(),
                IconColumn::make('has_fees')->boolean(),
                TextColumn::make('taux_interet')->numeric(),
                TextColumn::make('frais')->numeric(),
                TextColumn::make('plafond')->numeric(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable(),
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
    }
}
