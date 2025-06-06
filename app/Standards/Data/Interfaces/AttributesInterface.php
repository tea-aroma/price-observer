<?php

namespace App\Standards\Data\Interfaces;


/**
 * Interface for the Data classes which contains attribute properties.
 */
interface AttributesInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function toSha512(): string;
}
