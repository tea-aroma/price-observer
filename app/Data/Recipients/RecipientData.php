<?php

namespace App\Data\Recipients;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class RecipientData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $token;

    /**
     * @var string
     */
    public string $confirmed_at;

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
