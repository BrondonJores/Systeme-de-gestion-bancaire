<?php

namespace App\Filament\Admin\Resources\Virements\Schemas;

use App\Models\CompteBancaire;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VirementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_compte_emetteur')
                    ->label('Compte émetteur')
                    ->options(function () {
                        $user = auth()->user();
                        if ($user->isClient()) {
                            return $user->comptebancaire->pluck('rib', 'id');
                        }
                        return CompteBancaire::pluck('rib', 'id');
                    })
                    ->reactive()
                    ->required(),

                Select::make('id_compte_destinataire')
                    ->label('Compte destinataire')
                    ->options(function (callable $get) {
                        $emetteurId = $get('id_compte_emetteur');
                        $query = CompteBancaire::query();
                        if ($emetteurId) {
                            $query->where('id', '<>', $emetteurId);
                        }
                        return $query->pluck('rib', 'id');
                    })
                    ->required(),

                TextInput::make('montant')->numeric()->required()
                    ->readonly(fn (string $context) => $context === 'edit'),

                Select::make('type')
                    ->options([
                        'transfert' => 'Transfert',
                    ])
                    ->required(),

                Select::make('statut')
                    ->options([
                        'en cours' => 'En cours',
                        'effectue' => 'Effectué',
                        'echoue' => 'Échoué',
                    ])
                    ->default('encours')
                    ->hiddenOn(['create', 'edit'])
                    ->required(),

                TextInput::make('reference')->required()
                    ->readonly()
                    ->default(fn () => strtoupper(fake()->unique()->bothify('BTR########???'))),

                Textarea::make('description'),
            ]);
    }
}
