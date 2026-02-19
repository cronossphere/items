<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\HasCreator;
use App\Models\Contracts\TracksCreator;

class Organization extends Model implements TracksCreator
{
    use SoftDeletes;
    use HasCreator;

    protected $fillable = ['name', 'slug'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['role']);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function publishers(): HasMany
    {
        return $this->hasMany(Publisher::class);
    }
}
