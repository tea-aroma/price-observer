<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @inheritDoc
 */
class Item extends Model
{
    use HasFactory;

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

    /**
     * @return BelongsToMany
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class, ItemToRecipient::class);
    }

    /**
     * @return BelongsTo
     */
    public function information(): BelongsTo
    {
        return $this->belongsTo(ItemInformation::class, 'id', 'item_id');
    }
}
