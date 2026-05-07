<?php

namespace App\Filament\Admin\Resources\UserChessResource\Pages;

use App\Filament\Admin\Resources\UserChessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserChess extends EditRecord
{
    protected static string $resource = UserChessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
