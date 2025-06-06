<?php

namespace App\Data\ItemsToRecipients;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ItemToRecipientData extends Data
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
    public int $recipient_id;
}
