<?php

namespace App\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Concerns\HasCreator;
use App\Models\Contracts\BelongsToOrganizationContract;
use App\Models\Contracts\TracksCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model implements TracksCreator, BelongsToOrganizationContract
{
    use SoftDeletes;
    use BelongsToOrganization;
    use HasCreator;

    protected $fillable = [
        'purchase_date',
        'warrenty_note',
        'warrenty_date',
        'serial_number',
        'price_cent',
        'count',
        'was_gifted',
        'gifted_note',
        'receipt',
        'shop_id',
        'organization_id',
        'created_by',
    ];

    public function shop() : BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function createdBy() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected function casts()
    {
        return [
            'purchase_date' => 'date',
            'warrenty_date' => 'date',
            'was_gifted' => 'boolean',
        ];
    }
}
