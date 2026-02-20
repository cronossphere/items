<?php

namespace App\Filament\Resources\Publishers\Pages;

use App\Filament\Resources\Publishers\Concerns\SyncPublisherScopes;
use App\Filament\Resources\Publishers\PublisherResource;
use App\Models\PublisherScope;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreatePublisher extends CreateRecord
{
    use SyncPublisherScopes;

    protected static string $resource = PublisherResource::class;

    protected function afterCreate(): void
    {
        $this->syncPublisherScopesFromForm();
    }
}
