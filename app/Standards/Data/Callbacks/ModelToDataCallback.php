<?php

namespace App\Standards\Data\Callbacks;


use App\Standards\Data\Abstracts\Data;
use Illuminate\Database\Eloquent\Model;


/**
 * Converts the specified Model to the specified Data.
 */
class ModelToDataCallback
{
    /**
     * @var class-string<Data>
     */
    public string $namespace;

    /**
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @param Model $model
     *
     * @return Data
     */
    public function __invoke(Model $model): Data
    {
        return $this->namespace::fromArray($model->toArray());
    }
}
