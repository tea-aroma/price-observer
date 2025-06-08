<?php

namespace App\Repositories;


use App\Data\ItemsHistory\ItemHistoryDataAttributes;
use App\Data\ItemsHistory\ItemHistoryDataOptions;
use App\Models\ItemHistory;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\UpdateInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use App\Standards\Repositories\Interfaces\WriteOrUpdateInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class ItemHistoryRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, UpdateInterface, WriteOrUpdateInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = ItemHistory::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::ITEMS_HISTORY;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<ItemHistory>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ItemHistoryDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ItemHistoryDataOptions::class));
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
     * @return ItemHistory|null
     */
    public function find(int $id): ?ItemHistory
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
     * @return ItemHistory
     */
    public function write(AttributesInterface $values): ItemHistory
    {
        if (!is_a($values, ItemHistoryDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, ItemHistoryDataAttributes::class));
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
        if (!is_a($values, ItemHistoryDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, ItemHistoryDataAttributes::class));
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
     * @return ItemHistory
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): ItemHistory
    {
        if (!is_a($attributes, ItemHistoryDataAttributes::class) || !is_a($values, ItemHistoryDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($attributes::class, ItemHistoryDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->newQuery()->updateOrCreate($attributes->toArray(), $values->toArray());
    }

    /**
     * Gets all latest records.
     *
     * @return Collection<ItemHistory>|ItemHistory
     */
    public function latest(): Collection | ItemHistory
    {
        return $this->newQuery()
            ->fromRaw('(select *, row_number() over (partition by item_id order by id desc) as rn from items_history) as ih')
            ->where('rn', '=', 1)
            ->get();
    }

    /**
     * Gets the latest record by the specified item id.
     *
     * @param int $itemId
     *
     * @return ItemHistory|null
     */
    public function latestByItemId(int $itemId): ?ItemHistory
    {
        return $this->newQuery()
            ->fromRaw('(select *, row_number() over (partition by item_id order by id desc) as rn from items_history) as ih')
            ->where('rn', '=', 1)
            ->where('item_id', '=', $itemId)
            ->first();
    }
}
