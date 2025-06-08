<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @inheritDoc
 */
class Recipient extends Model
{
    /**
     * @var string
     */
    protected $table = 'recipients';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'email',
            'token',
            'confirmed_at',
            'is_active',
        ];

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, ItemToRecipient::class);
    }
}
