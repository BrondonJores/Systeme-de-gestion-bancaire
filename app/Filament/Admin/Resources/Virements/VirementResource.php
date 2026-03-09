<?php

namespace App\Filament\Admin\Resources\Virements;

use App\Filament\Admin\Resources\Virements\Pages\CreateVirement;
use App\Filament\Admin\Resources\Virements\Pages\EditVirement;
use App\Filament\Admin\Resources\Virements\Pages\ListVirements;
use App\Filament\Admin\Resources\Virements\Pages\ViewVirement;
use App\Filament\Admin\Resources\Virements\Schemas\VirementForm;
use App\Filament\Admin\Resources\Virements\Schemas\VirementInfolist;
use App\Filament\Admin\Resources\Virements\Tables\VirementsTable;
use App\Models\Virement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VirementResource extends Resource
{
    protected static ?string $model = Virement::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Schema $schema): Schema
    {
        return VirementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VirementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VirementsTable::configure($table);
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
            'index' => ListVirements::route('/'),
            'create' => CreateVirement::route('/create'),
            'view' => ViewVirement::route('/{record}'),
            'edit' => EditVirement::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Si c'est un client alors montrer uniquement les virements liés à ses comptes
        if ($user->role === 'client') {
            $query->where(function ($q) use ($user) {
                $q->whereHas('compteEmetteur', fn ($q2) => $q2->where('user_id', $user->id))
                    ->orWhereHas('compteDestinataire', fn ($q3) => $q3->where('user_id', $user->id));
            });
        }

        return $query;
    }
}
