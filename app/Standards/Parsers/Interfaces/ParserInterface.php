<?php

namespace App\Standards\Parsers\Interfaces;


/**
 * Interface for information Parsers.
 */
interface ParserInterface
{
    /**
     * @return int
     */
    public function sellerId(): int;

    /**
     * @return int
     */
    public function platformId(): int;

    /**
     * @return float
     */
    public function price(): float;

    /**
     * @return string|null
     */
    public function currency(): ?string;

    /**
     * @return string
     */
    public function textPrice(): string;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function image(): string;

    /**
     * @return string
     */
    public function note(): string;

    /**
     * @return array
     */
    public function parameters(): array;

    /**
     * @return string
     */
    public function publicatedAt(): string;
}
