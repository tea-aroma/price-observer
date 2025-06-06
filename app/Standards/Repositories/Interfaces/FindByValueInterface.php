<?php

namespace App\Standards\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;


/**
 * Interface for finding a record by the specified value.
 */
interface FindByValueInterface
{
    /**
     * Finds a record by the specified code.
     *
     * @param string $value
     * @param string $column
     *
     * @return Model|null
     */
    public function findByValue(string $value, string $column = 'code'): ?Model;
}
