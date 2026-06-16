<?php

namespace App\Filament\Admin\Resources\ChessMatchResource\Pages;

use App\Filament\Admin\Resources\ChessMatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChessMatch extends EditRecord
{
    protected static string $resource = ChessMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
