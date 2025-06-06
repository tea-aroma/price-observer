<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @inheritDoc
 */
class Item extends Model
{
    /**
     * @var string
     */
    protected $table = 'items';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'site_id',
            'platform_id',
            'seller_id',
            'description',
            'sort_order',
            'is_active',
        ];

    /**
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
