<?php

namespace App\Standards\Recipients\Services;


use App\Data\Recipients\RecipientData;
use App\Repositories\RecipientRepository;
use App\Standards\Items\Item;
use App\Standards\Parsers\Classes\HtmlParser;
use App\Standards\Recipients\Classes\Recipient;


/**
 * Provides the service for Recipient logic.
 */
class RecipientService
{
    /**
     * @param string $email
     * @param string $url
     *
     * @return RecipientData
     */
    public static function subscribe(string $email, string $url): RecipientData
    {
        $instance = new Recipient();

        $recipient = RecipientRepository::query()->findByValue($email, 'email');

        if (!$recipient)
        {
            $recipient = $instance->register($email);

            $instance->sendConfirmation($recipient);

            $recipient = RecipientRepository::query()->findByValue($email, 'email');
        }

        $item = (new Item())->create(new HtmlParser($url));

        $recipient->items()->attach($item->id);

        return RecipientData::fromArray($recipient->toArray());
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
