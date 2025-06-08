<?php

namespace App\Repositories;


use App\Data\Items\ItemDataAttributes;
use App\Data\Items\ItemDataOptions;
use App\Models\Item;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindByValueInterface;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\UpdateInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use App\Standards\Repositories\Interfaces\WriteOrUpdateInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class ItemRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, UpdateInterface, WriteOrUpdateInterface, FindByValueInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = Item::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::ITEMS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Item>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ItemDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ItemDataOptions::class));
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
     * @return Item|null
     */
    public function find(int $id): ?Item
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->newQuery()->where('id', $id)->first();
        });
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return Item
     */
    public function write(AttributesInterface $values): Item
    {
        if (!is_a($values, ItemDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, ItemDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->newQuery()->create($values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return int
     */
    public function update(AttributesInterface $values): int
    {
        if (!is_a($values, ItemDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, ItemDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->newQuery()->where('id', $values->id)->update($values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $attributes
     * @param AttributesInterface $values
     *
     * @return Item
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): Item
    {
        if (!is_a($attributes, ItemDataAttributes::class) || !is_a($values, ItemDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($attributes::class, ItemDataAttributes::class));
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
     * @return Item|null
     */
    public function findByValue(string $value, string $column = 'platform_id'): ?Item
    {
        return $this->cacheRepository->remember($value . $column, function () use ($value, $column)
        {
            return $this->newQuery()->where($column, '=', $value)->first();
        });
    }
}
