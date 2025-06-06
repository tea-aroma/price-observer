<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class ItemStatus extends Model
{
    /**
     * @var string
     */
    protected $table = 'item_statuses';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'code',
            'description',
            'sort_order',
            'is_active',
        ];
}
