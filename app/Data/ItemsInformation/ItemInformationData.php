<?php

namespace App\Data\ItemsInformation;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ItemInformationData extends Data
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
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $url;

    /**
     * @var string
     */
    public string $image;

    /**
     * @var string
     */
    public string $note;

    /**
     * @var string
     */
    public string $currency;

    /**
     * @var array
     */
    public array $parameters;

    /**
     * @var string
     */
    public string $publicate_at;
}
