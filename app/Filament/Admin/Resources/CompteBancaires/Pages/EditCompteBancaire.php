<?php

namespace App\Filament\Admin\Resources\CompteBancaires\Pages;

use App\Filament\Admin\Resources\CompteBancaires\CompteBancaireResource;
use App\Http\Controllers\CompteBancaireController;
use Filament\Actions\Action as PageAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCompteBancaire extends EditRecord
{
    protected static string $resource = CompteBancaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Voir le compte
            ViewAction::make(),

            // Supprimer le compte
            DeleteAction::make(),

            // Activer le compte (visible seulement si inactif)
            PageAction::make('activer')
                ->label('Activer')
                ->color('success')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->visible(fn () => $this->record && $this->record->statut === 'inactif')
                ->action(function () {
                    try {
                        app(CompteBancaireController::class)->activer($this->record);
                        $this->record->refresh();

                        Notification::make()
                            ->title('Compte activé')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Erreur')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            // Suspendre le compte (visible seulement si actif)
            PageAction::make('suspendre')
                ->label('Suspendre')
                ->color('warning')
                ->icon('heroicon-o-pause')
                ->requiresConfirmation()
                ->visible(fn () => $this->record && $this->record->statut === 'actif')
                ->action(function () {
                    try {
                        app(CompteBancaireController::class)->suspendre($this->record);
                        $this->record->refresh();

                        Notification::make()
                            ->title('Compte suspendu')
                            ->warning()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Erreur')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            // Fermer le compte (visible si pas déjà fermé)
            PageAction::make('fermer')
                ->label('Fermer')
                ->color('danger')
                ->icon('heroicon-o-x-mark')
                ->requiresConfirmation()
                ->visible(fn () => $this->record && $this->record->statut !== 'ferme')
                ->action(function () {
                    try {
                        app(CompteBancaireController::class)->fermer($this->record);
                        $this->record->refresh();

                        Notification::make()
                            ->title('Compte fermé')
                            ->danger()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Erreur')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
