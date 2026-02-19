<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\HasCreator;
use App\Models\Contracts\BelongsToOrganizationContract;
use App\Models\Contracts\TracksCreator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends \Spatie\Tags\Tag implements BelongsToOrganizationContract, TracksCreator
{
    use SoftDeletes;
    use BelongsToOrganization;
    use HasCreator;

    // Spatie Tag arbeitet oft mit guarded = []
    public $guarded = [];

    protected $fillable = [
        'organization_id',
        'created_by',
        'name',
        'slug',
        'type',
        'order_column'
    ];
}
