<?php

namespace App\Standards\Recipients\Services;


use App\Data\Recipients\RecipientData;
use App\Standards\Recipients\Classes\Recipient;


/**
 * Provides the service for Recipient logic.
 */
class RecipientService
{
    /**
     * @param string $email
     *
     * @return RecipientData
     */
    public static function subscribe(string $email): RecipientData
    {
        $instance = new Recipient();

        $record = $instance->register($email);

        $instance->sendConfirmation($record);

        return RecipientData::fromArray($record->toArray());
    }

    /**
     * @param string $token
     *
     * @return int
     */
    public function confirm(string $token): int
    {
        return (new Recipient())->confirm($token);
    }
}
