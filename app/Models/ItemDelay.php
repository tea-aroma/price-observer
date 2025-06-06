<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class ItemDelay extends Model
{
    /**
     * @var string
     */
    protected $table = 'item_delays';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'code',
            'delay',
            'description',
            'sort_order',
            'is_active',
        ];
}
