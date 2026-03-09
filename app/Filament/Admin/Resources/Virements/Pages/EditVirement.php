<?php

namespace App\Filament\Admin\Resources\Virements\Pages;

use App\Filament\Admin\Resources\Virements\VirementResource;
use App\Http\Controllers\VirementController;
use Filament\Actions\Action as PageAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditVirement extends EditRecord
{
    protected static string $resource = VirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            PageAction::make('valider')
                ->label('Valider le virement')
                ->color('success')
                ->icon('heroicon-o-check')
                ->requiresConfirmation()
                ->visible(fn () => $this->record && $this->record->statut === 'en cours')
                ->action(function () {
                    try {
                        app(\App\Http\Controllers\VirementController::class)->valider($this->record);
                        $this->record->refresh();

                        Notification::make()
                            ->title('Virement validé')
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
        ];
    }
}
