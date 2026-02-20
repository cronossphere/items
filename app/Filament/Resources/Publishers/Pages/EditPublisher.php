<?php

namespace App\Filament\Resources\Publishers\Pages;

use App\Filament\Resources\Publishers\Concerns\SyncPublisherScopes;
use App\Filament\Resources\Publishers\PublisherResource;
use App\Models\PublisherScope;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;

class EditPublisher extends EditRecord
{
    use SyncPublisherScopes;

    protected static string $resource = PublisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->syncPublisherScopesFromForm();
    }
}
