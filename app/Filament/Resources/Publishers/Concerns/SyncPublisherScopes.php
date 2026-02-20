<?php

namespace App\Filament\Resources\Publishers\Concerns;

use App\Models\PublisherScope;
use Filament\Facades\Filament;

trait SyncPublisherScopes
{
    protected function syncPublisherScopesFromForm(): void
    {
        /** @var \App\Models\Publisher $publisher */
        $publisher = $this->record;

        $tenant = Filament::getTenant();
        if (! $tenant) {
            return;
        }

        $state = $this->form->getState();
        $scopes = $state['scopes_list'] ?? [];

        // --- Sync mit SoftDeletes-restore (clean & historienfreundlich) ---
        // 1) Alle aktuellen "active" soft-deleten, die nicht mehr drin sind
        $publisher->scopes()
            ->whereNull('deleted_at')
            ->whereNotIn('scope', $scopes)
            ->delete();

        // 2) Fehlende aktivieren (neu oder restore)
        foreach ($scopes as $scope) {
            $existing = $publisher->scopes()
                ->withTrashed()
                ->where('scope', $scope)
                ->first();

            if ($existing) {
                if ($existing->trashed()) {
                    $existing->restore();
                }
                continue;
            }

            PublisherScope::create([
                'organization_id' => $tenant->getKey(),
                'publisher_id' => $publisher->getKey(),
                'scope' => $scope,
            ]);
        }
    }
}
