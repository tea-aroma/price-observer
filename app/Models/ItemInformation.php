<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @inheritDoc
 */
class ItemInformation extends Model
{
    /**
     * @var string
     */
    protected $table = 'items_information';

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
            'name',
            'url',
            'image',
            'notice',
            'parameters',
            'publicate_at',
        ];

    /**
     * @var string[]
     */
    protected $casts =
        [
            'parameters' => 'array',
        ];

    /**
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
