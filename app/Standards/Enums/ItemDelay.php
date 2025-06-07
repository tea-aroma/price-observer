<?php

namespace App\Standards\Enums;


use App\Data\ItemDelays\ItemDelayData;
use App\Repositories\ItemDelayRepository;


/**
 * Represents an item delay for Items.
 */
enum ItemDelay: string
{
    case NORMAL = 'normal';

    case TIMEOUT = 'timeout';

    case ERROR = 'error';

    /**
     * Gets the data.
     *
     * @return ItemDelayData|null
     */
    public function data(): ?ItemDelayData
    {
        $record = ItemDelayRepository::query()->findByValue($this->value);

        return $record ? ItemDelayData::fromArray($record->toArray()) : null;
    }
}
