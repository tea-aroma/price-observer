<?php

namespace App\Standards\Recipients\Classes;


use App\Data\Recipients\RecipientData;
use App\Data\Recipients\RecipientDataAttributes;
use App\Mail\RecipientEmailConfirmMail;
use App\Repositories\RecipientRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


/**
 * Provides the base logic for Recipient.
 */
class Recipient
{
    /**
     * Registers the specified recipient.
     *
     * @param string $email
     *
     * @return RecipientData
     */
    public function register(string $email): RecipientData
    {
        $recipientAttributes  = RecipientDataAttributes::fromArray([ 'email' => $email, 'name' => Str::random(20) ]);

        $recipientAttributes->token = $this->generateToken();

        $record = RecipientRepository::query()->write($recipientAttributes);

        return RecipientData::fromArray($record->toArray());
    }

    /**
     * Sends the confirmation message.
     *
     * @param RecipientData $recipient
     *
     * @return mixed
     */
    public function sendConfirmation(RecipientData $recipient): mixed
    {
        return Mail::to($recipient->email)->queue(new RecipientEmailConfirmMail($recipient));
    }

    /**
     * @param string $token
     *
     * @return int
     */
    public function confirm(string $token): int
    {
        $record = RecipientRepository::query()->findByValue($token);

        if (!$record)
        {
            abort(404);
        }

        $attributes = RecipientDataAttributes::fromArray([ 'id' => $record->id, 'token' => $this->generateToken(), 'confirmed_at' => date('Y-m-d H:i:s'), 'is_active' => true,]);

        return RecipientRepository::query()->update($attributes);
    }

    /**
     * Generates a new token.
     *
     * @return string
     */
    protected function generateToken(): string
    {
        return hash('sha512', Str::random(40));
    }
}
