<?php

namespace App\Filament\Admin\Resources\CarteBancaires\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CarteBancairesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_carte')->label('Numéro de carte')->searchable()->sortable(),
                TextColumn::make('type_carte')->label('Type')->searchable()->sortable()->badge(),
                TextColumn::make('compte.rib')->label('Compte')->searchable()->sortable(),
                TextColumn::make('date_expiration')->label('Date d\'expiration')->date()->sortable(),
                TextColumn::make('cvv')->searchable()->badge(),
                IconColumn::make('is_actif')->label('Actif')->boolean(),
                TextColumn::make('created_at')->label('Créé le')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Mis à jour le')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Ajouter filtres si besoin
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Confirmer la suppression en masse')
                        ->modalSubheading('Voulez-vous vraiment supprimer ces cartes ?')
                        ->modalButton('Oui, supprimer'),
                ]),
            ]);
    }
}
