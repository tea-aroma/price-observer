<?php

namespace App\Standards\Enums;


use App\Data\Classifiers\ClassifierData;
use App\Repositories\ClassifierRepository;


/**
 * Represents an item status for Items.
 */
enum ItemStatus: string
{
    case UNKNOWN = 'unknown';

    case DELETED = 'deleted';

    case INACTIVE = 'inactive';

    /**
     * Gets the data.
     *
     * @return ClassifierData|null
     */
    public function data(): ?ClassifierData
    {
        $record = ClassifierRepository::forModel(ClassifierModel::ITEM_STATUSES)->findByValue($this->value);

        return $record ? ClassifierData::fromArray($record->toArray()) : null;
    }
}
