<?php

namespace App\Models\Concerns;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Contracts\BelongsToOrganizationContract;

trait BelongsToOrganization
{
    protected static function bootBelongsToOrganization(): void
    {
        // 🔒 GLOBAL SCOPE (MANDANTEN-TRENNUNG)
        static::addGlobalScope('organization', function (Builder $query) {
            $model = $query->getModel();

            if (! $model instanceof BelongsToOrganizationContract) {
                return;
            }

            $tenant = Filament::getTenant();

            if ($tenant) {
                $query->where(
                    $model->getTable() . '.organization_id',
                    $tenant->getKey()
                );
            }
        });

        // 🏗 AUTOMATISCHES SETZEN BEIM CREATE
        static::creating(function ($model) {
            if (! $model instanceof BelongsToOrganizationContract) {
                return;
            }

            if (! $model->organization_id) {
                $tenant = Filament::getTenant();

                if ($tenant) {
                    $model->organization_id = $tenant->getKey();
                }
            }
        });
    }

    // 🔓 Optional: Scope zum bewussten Deaktivieren
    public function scopeWithoutOrganizationScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('organization');
    }
}
