<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class Site extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'sites';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'url',
            'name',
            'code',
            'description',
            'sort_order',
            'is_active',
        ];
}
