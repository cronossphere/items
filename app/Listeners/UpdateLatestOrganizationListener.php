<?php
namespace App\Listeners;

use Filament\Events\TenantSet;

class UpdateLatestOrganizationListener
{
    public function handle(TenantSet $event): void
    {
        $user = $event->getUser();
        $tenant = $event->getTenant();

        $tenantId = $tenant->getKey();

        if ($user->latest_organization_id === $tenantId) {
            return;
        }

        $user->forceFill([
            'latest_organization_id' => $tenantId,
        ])->saveQuietly();
    }
}
