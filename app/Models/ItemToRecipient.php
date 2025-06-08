<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @inheritDoc
 */
class ItemToRecipient extends Model
{
    /**
     * @var string
     */
    protected $table = 'items_to_recipients';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'item_id',
            'recipient_id',
        ];

    /**
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * @return BelongsTo
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }
}
