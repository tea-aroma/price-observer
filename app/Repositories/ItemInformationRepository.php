<?php

namespace App\Repositories;


use App\Data\ItemsInformation\ItemInformationDataAttributes;
use App\Data\ItemsInformation\ItemInformationDataOptions;
use App\Models\ItemInformation;
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
class ItemInformationRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, UpdateInterface, WriteOrUpdateInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = ItemInformation::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::ITEMS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<ItemInformation>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ItemInformationDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ItemInformationDataOptions::class));
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
     * @return ItemInformation|null
     */
    public function find(int $id): ?ItemInformation
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
     * @return ItemInformation
     */
    public function write(AttributesInterface $values): ItemInformation
    {
        if (!is_a($values, ItemInformationDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, ItemInformationDataAttributes::class));
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
        if (!is_a($values, ItemInformationDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, ItemInformationDataAttributes::class));
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
     * @return ItemInformation
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): ItemInformation
    {
        if (!is_a($attributes, ItemInformationDataAttributes::class) || !is_a($values, ItemInformationDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($attributes::class, ItemInformationDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->newQuery()->updateOrCreate($attributes->toArray(), $values->toArray());
    }
}
