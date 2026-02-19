<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Contracts\BelongsToOrganizationContract;
use App\Models\Contracts\TracksCreator;
use App\Models\Concerns\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphedByMany;

class Publisher extends Model implements TracksCreator, BelongsToOrganizationContract
{
    use SoftDeletes;
    use BelongsToOrganization;
    use HasCreator;

    protected $fillable = [
        'organization_id',
        'created_by',
        'name',
        'website',
        'country',
        'notes',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function books(): MorphedByMany
    {
        return $this->morphedByMany(Book::class, 'publishable', 'publishables')
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }

    public function movies(): MorphedByMany
    {
        return $this->morphedByMany(Movie::class, 'publishable', 'publishables')
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }
}
