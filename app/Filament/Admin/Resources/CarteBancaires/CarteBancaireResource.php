<?php

namespace App\Filament\Admin\Resources\CarteBancaires;

use App\Filament\Admin\Resources\CarteBancaires\Pages\CreateCarteBancaire;
use App\Filament\Admin\Resources\CarteBancaires\Pages\EditCarteBancaire;
use App\Filament\Admin\Resources\CarteBancaires\Pages\ListCarteBancaires;
use App\Filament\Admin\Resources\CarteBancaires\Pages\ViewCarteBancaire;
use App\Filament\Admin\Resources\CarteBancaires\Schemas\CarteBancaireForm;
use App\Filament\Admin\Resources\CarteBancaires\Schemas\CarteBancaireInfolist;
use App\Filament\Admin\Resources\CarteBancaires\Tables\CarteBancairesTable;
use App\Models\CarteBancaire;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CarteBancaireResource extends Resource
{
    protected static ?string $model = CarteBancaire::class;

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $recordTitleAttribute = 'numero_carte';

    public static function form(Schema $schema): Schema
    {
        return CarteBancaireForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CarteBancaireInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CarteBancairesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers éventuels
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCarteBancaires::route('/'),
            'create' => CreateCarteBancaire::route('/create'),
            'view' => ViewCarteBancaire::route('/{record}'),
            'edit' => EditCarteBancaire::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Si client → ne voir que les cartes dont le compte lui appartient
        if ($user->role === 'client') {
            $query->whereHas('compte', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return $query;
    }

}
