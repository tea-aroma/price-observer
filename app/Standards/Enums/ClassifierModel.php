<?php

namespace App\Standards\Enums;


use App\Models\ItemStatus;
use App\Models\Setting;


/**
 * Represents a classifier name for this app.
 */
enum ClassifierModel: string
{
    case ITEM_STATUSES = ItemStatus::class;

    case SETTINGS = Setting::class;

    /**
     * Gets the key for access database columns.
     *
     * @param string $key
     *
     * @return string
     */
    public function getKey(string $key = 'id'): string
    {
        return strtolower($this->name) . '_' . $key;
    }

    /**
     * Gets a case by the specified name.
     *
     * @param string $name
     *
     * @return ClassifierModel|null
     */
    public static function fromName(string $name): ?ClassifierModel
    {
        foreach (self::cases() as $case)
        {
            if ($case->name === $name)
            {
                return $case;
            }
        }

        return null;
    }
}
