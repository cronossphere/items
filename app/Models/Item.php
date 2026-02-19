<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\HasCreator;
use App\Models\Contracts\BelongsToOrganizationContract;
use App\Models\Contracts\TracksCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model implements TracksCreator, BelongsToOrganizationContract
{
    use SoftDeletes;
    use BelongsToOrganization;
    use HasCreator;

    protected $fillable = [
        'organization_id',
        'created_by',
        'type',
        'name',
        'price_cents',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
