<?php

namespace App\Filament\Admin\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class TopClientsTableWidget extends TableWidget
{
    protected static ?string $heading = 'Top Clients';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => User::withCount('comptebancaire')
                    ->withSum('comptebancaire', 'solde')
                    ->orderByDesc('comptebancaire_sum_solde')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('name')->label('Nom'),
                TextColumn::make('prenom')->label('Prénom'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('comptebancaire_count')->label('Nombre de comptes')->sortable(),
                TextColumn::make('comptebancaire_sum_solde')->label('Solde total')->money('MAD', true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
