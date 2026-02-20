<?php

namespace App\Models;

use App\Models\Contracts\BelongsToOrganizationContract;
use App\Models\Contracts\TracksCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model implements TracksCreator, BelongsToOrganizationContract
{
    use SoftDeletes;
    use \App\Models\Concerns\BelongsToOrganization;
    use \App\Models\Concerns\HasCreator;
    use \Spatie\Tags\HasTags;

    protected $fillable = [
        'subtitle',
        'cover',
        'notes',
        'runtime',
        'language',
        'year',
        'item_id',
        'publisher_id',
    ];

    protected $guarded = ['organization_id', 'created_by'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
