<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class Site extends Model
{
    /**
     * @var string
     */
    protected $table = 'sites';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'url',
            'description',
            'sort_order',
            'is_active',
        ];
}
