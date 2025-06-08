<?php

namespace App\Standards\Enums;


use App\Data\Settings\SettingData;
use App\Repositories\SettingRepository;


/**
 * Represent a setting key for this app.
 */
enum SettingKey: string
{
    case RECIPIENT_CONFIRMATION_TIME = 'recipient_confirmation_time';

    case REQUEST_USER_AGENT = 'request_user_agent';

    case REQUEST_TIMEOUT = 'request_timeout';

    case ITEMS_CHECK_DELAY = 'items_check_delay';

    /**
     * Gets the classifier data.
     *
     * @return SettingData
     */
    public function data(): SettingData
    {
        $record = SettingRepository::query()->findByValue($this->value);

        return SettingData::fromArray($record->toArray());
    }
}
