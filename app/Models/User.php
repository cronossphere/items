<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\HasDefaultTenant;


class User extends Authenticatable implements HasTenants, HasDefaultTenant
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function getDefaultTenant(Panel $panel): ?Model
    {
        // 1) zuletzt verwendete Org, falls noch berechtigt
        if ($this->latestOrganization && $this->canAccessTenant($this->latestOrganization)) {
            return $this->latestOrganization;
        }

        // 2) fallback: erste Organization
        return $this->organizations()->first();
    }

    public function latestOrganization()
    {
        return $this->belongsTo(Organization::class, 'latest_organization_id');
    }

    public function roleInOrganization(Organization $org): ?string
    {
        return $this->organizations()
            ->whereKey($org)
            ->first()?->pivot?->role;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
            ->withTimestamps()
            ->withPivot(['role']);
    }

    public function getTenants(Panel $panel): array|\Illuminate\Support\Collection
    {
        return $this->organizations()->get(); // oder: ->orderBy('name')->get();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->organizations()->whereKey($tenant->getKey())->exists();
    }
}
