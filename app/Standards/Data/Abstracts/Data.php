<?php

namespace App\Standards\Data\Abstracts;


use App\Standards\Data\Callbacks\ModelToDataCallback;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Provides help working for data properties.
 */
abstract class Data
{
    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->fill($values);
    }

    /**
     * Gets the all properties by the specified filters.
     *
     * @param int|null $filter
     *
     * @return \ReflectionProperty[]
     */
    protected function getProperties(?int $filter = \ReflectionProperty::IS_PUBLIC): array
    {
        return (new \ReflectionClass($this))->getProperties($filter);
    }

    /**
     * Creates a new instance by the specified array.
     *
     * @param array $values
     *
     * @return static
     */
    public static function fromArray(array $values): static
    {
        return new static($values);
    }

    /**
     * Maps each model of the specified collection to current type.
     *
     * @param Collection $collection
     *
     * @return \Illuminate\Support\Collection
     */
    public static function map(Collection $collection): \Illuminate\Support\Collection
    {
        return $collection->map(new ModelToDataCallback(static::class));
    }

    /**
     * Converts this instance to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach ((new \ReflectionClass($this))->getProperties() as $property)
        {
            if (!$property->isInitialized($this))
            {
                continue;
            }

            $array[ $property->getName() ] = $property->getValue($this);
        }

        return $array;
    }

    /**
     * Converts this instance to the Model.
     *
     * @param class-string<Model> $model
     *
     * @return Model
     */
    public function toModel(string $model): Model
    {
        return new $model($this->toArray());
    }

    /**
     * Fills this instance by the specified values.
     *
     * @param array $values
     *
     * @return $this
     */
    public function fill(array $values): static
    {
        foreach ($this->getProperties() as $property)
        {
            if (!isset($values[ $property->getName() ]))
            {
                continue;
            }

            $property->setValue($this, $values[ $property->getName() ]);
        }

        return $this;
    }

    /**
     * Converts the instance to sha512.
     *
     * @return string
     */
    public function toSha512(): string
    {
        return hash('sha512', json_encode($this->toArray()));
    }
}
