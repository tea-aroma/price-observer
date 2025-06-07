<?php

use App\Standards\Recipients\Services\RecipientService;


if (! function_exists('recipient'))
{
    /**
     * Gets the 'RecipientService' instance.
     *
     * @return RecipientService
     */
    function recipient(): RecipientService
    {
        return app(RecipientService::class);
    }
}

