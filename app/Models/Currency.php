<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class Currency extends Model
{
    /**
     * @var string
     */
    protected $table = 'currencies';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'code',
            'symbol',
            'description',
            'sort_order',
            'is_active',
        ];
}
