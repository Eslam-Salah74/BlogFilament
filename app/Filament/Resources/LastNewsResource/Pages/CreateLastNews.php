<?php

namespace App\Filament\Resources\LastNewsResource\Pages;

use App\Filament\Resources\LastNewsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLastNews extends CreateRecord
{
    protected static string $resource = LastNewsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
