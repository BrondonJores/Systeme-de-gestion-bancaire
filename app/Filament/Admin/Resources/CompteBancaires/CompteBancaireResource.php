<?php

namespace App\Filament\Admin\Resources\CompteBancaires;

use App\Filament\Admin\Resources\CompteBancaires\Pages\CreateCompteBancaire;
use App\Filament\Admin\Resources\CompteBancaires\Pages\EditCompteBancaire;
use App\Filament\Admin\Resources\CompteBancaires\Pages\ListCompteBancaires;
use App\Filament\Admin\Resources\CompteBancaires\Pages\ViewCompteBancaire;
use App\Filament\Admin\Resources\CompteBancaires\Schemas\CompteBancaireForm;
use App\Filament\Admin\Resources\CompteBancaires\Schemas\CompteBancaireInfolist;
use App\Filament\Admin\Resources\CompteBancaires\Tables\CompteBancairesTable;
use App\Models\CompteBancaire;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CompteBancaireResource extends Resource
{
    protected static ?string $model = CompteBancaire::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $recordTitleAttribute = 'rib';

    public static function form(Schema $schema): Schema
    {
        return CompteBancaireForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CompteBancaireInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompteBancairesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompteBancaires::route('/'),
            'create' => CreateCompteBancaire::route('/create'),
            'view' => ViewCompteBancaire::route('/{record}'),
            'edit' => EditCompteBancaire::route('/{record}/edit'),
        ];
    }

    // Filtrer les clients
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->isClient()) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }
}
