<?php

namespace App\Data\Items;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ItemData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $site_id;

    /**
     * @var int
     */
    public int $platform_id;

    /**
     * @var int
     */
    public int $seller_id;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var int
     */
    public int $sort_order;

    /**
     * @var bool
     */
    public bool $is_active;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
