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
use Spatie\Tags\HasTags;

class Item extends Model implements TracksCreator, BelongsToOrganizationContract
{
    use SoftDeletes;
    use BelongsToOrganization;
    use HasCreator;
    use HasTags;

    protected $fillable = [
        'organization_id',
        'created_by',
        'type_id',
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

    public function purchase(): HasOne
    {
        return $this->hasOne(Purchase::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(ItemType::class, 'id', 'type_id');
    }

    public static function getTagClassName(): string
    {
        return \App\Models\Tag::class;
    }

    public function tagType(): string
    {
        // ItemType scoping (book/movie/...)
        return 'item:' . $this->type;
    }
}
