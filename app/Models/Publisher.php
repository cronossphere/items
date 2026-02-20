<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Contracts\BelongsToOrganizationContract;
use App\Models\Contracts\TracksCreator;
use App\Models\Concerns\HasCreator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

class Publisher extends Model implements TracksCreator, BelongsToOrganizationContract
{
    use SoftDeletes;
    use BelongsToOrganization;
    use HasCreator;

    protected $fillable = [
        'name',
        'website',
        'country',
        'notes',
    ];

    protected $guarded = ['organization_id', 'created_by'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function scopes(): HasMany
    {
        return $this->hasMany(PublisherScope::class);
    }


    public function scopeFor(Builder $q, string $scope): Builder
    {
        return $q->whereHas('scopes', fn ($s) => $s->where('scope', $scope)->whereNull('deleted_at'));
    }
}
