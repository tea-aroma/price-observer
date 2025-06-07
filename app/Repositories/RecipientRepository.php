<?php

namespace App\Repositories;


use App\Data\Recipients\RecipientDataAttributes;
use App\Data\Recipients\RecipientDataOptions;
use App\Models\Recipient;
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
class RecipientRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, UpdateInterface, WriteOrUpdateInterface, FindByValueInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = Recipient::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::RECIPIENTS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Recipient>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, RecipientDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, RecipientDataOptions::class));
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
     * @return Recipient|null
     */
    public function find(int $id): ?Recipient
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
     * @return Recipient
     */
    public function write(AttributesInterface $values): Recipient
    {
        if (!is_a($values, RecipientDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, RecipientDataAttributes::class));
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
        if (!is_a($values, RecipientDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($values::class, RecipientDataAttributes::class));
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
     * @return Recipient
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): Recipient
    {
        if (!is_a($attributes, RecipientDataAttributes::class) || !is_a($values, RecipientDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($attributes::class, RecipientDataAttributes::class));
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
     * @return Recipient|null
     */
    public function findByValue(string $value, string $column = 'token'): ?Recipient
    {
        return $this->cacheRepository->remember($value . $column, function () use ($value, $column)
        {
            return $this->newQuery()->where($column, '=', $value)->first();
        });
    }
}
