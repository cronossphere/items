<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\BelongsToOrganization;
use App\Models\Contracts\BelongsToOrganizationContract;

class PublisherScope extends Model implements BelongsToOrganizationContract
{
    use SoftDeletes;
    use BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'publisher_id',
        'scope',
    ];

    public function publisher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
}
