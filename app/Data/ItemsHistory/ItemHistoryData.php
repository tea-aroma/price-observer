<?php

namespace App\Data\ItemsHistory;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ItemHistoryData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $item_id;

    /**
     * @var int
     */
    public int $old_price;

    /**
     * @var int
     */
    public int $new_price;

    /**
     * @var string
     */
    public string $old_price_text;

    /**
     * @var string
     */
    public string $new_price_text;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
