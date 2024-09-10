<?php

namespace App\Filament\Resources\LastNewsResource\Pages;

use App\Filament\Resources\LastNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLastNews extends EditRecord
{
    protected static string $resource = LastNewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
