<?php

namespace App\Filament\Admin\Resources\UserChessResource\Pages;

use App\Filament\Admin\Resources\UserChessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserChesses extends ListRecords
{
    protected static string $resource = UserChessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
