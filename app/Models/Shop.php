<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\HasCreator;
use App\Models\Contracts\BelongsToOrganizationContract;
use App\Models\Contracts\TracksCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model implements TracksCreator, BelongsToOrganizationContract
{
    use SoftDeletes;
    use BelongsToOrganization;
    use HasCreator;

    protected $fillable = [
        'name',
        'url',
        'notes',
        'organization_id',
        'created_by',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
