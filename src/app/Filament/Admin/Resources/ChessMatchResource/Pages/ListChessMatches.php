<?php

namespace App\Filament\Admin\Resources\ChessMatchResource\Pages;

use App\Filament\Admin\Resources\ChessMatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChessMatches extends ListRecords
{
    protected static string $resource = ChessMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
