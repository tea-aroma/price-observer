<?php

namespace App\Repositories;


use App\Data\ItemDelays\ItemDelayDataAttributes;
use App\Data\ItemDelays\ItemDelayDataOptions;
use App\Models\ItemDelay;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindByValueInterface;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\WriteOrUpdateInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class ItemDelayRepository extends Repository implements ReadInterface, FindInterface, WriteOrUpdateInterface, FindByValueInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = ItemDelay::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::ITEM_DELAYS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<ItemDelay>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ItemDelayDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ItemDelayDataOptions::class));
        }

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            return $this->newQuery()->get();
        });
    }

    /**
     * @inheritDoc
     *
     * @param int $id
     *
     * @return ItemDelay|null
     */
    public function find(int $id): ?ItemDelay
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->newQuery()->where('id', $id)->first();
        });
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $attributes
     * @param AttributesInterface $values
     *
     * @return ItemDelay
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): ItemDelay
    {
        if (!is_a($attributes, ItemDelayDataAttributes::class) || !is_a($values, ItemDelayDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($attributes::class, ItemDelayDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->newQuery()->updateOrCreate($attributes->toArray(), $values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param string $value
     * @param string $column
     *
     * @return ItemDelay|null
     */
    public function findByValue(string $value, string $column = 'code'): ?ItemDelay
    {
        return $this->cacheRepository->remember($value . $column, function () use ($value, $column)
        {
            return $this->newQuery()->where($column, '=',  $value)->first();
        });
    }
}
