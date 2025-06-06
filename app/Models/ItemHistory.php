<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @inheritDoc
 */
class ItemHistory extends Model
{
    /**
     * @var string
     */
    protected $table = 'items_history';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'item_id',
            'old_price',
            'new_price',
            'old_price_text',
            'new_price_text',
        ];

    /**
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
