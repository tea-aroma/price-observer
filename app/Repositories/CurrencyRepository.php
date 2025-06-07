<?php

namespace App\Repositories;


use App\Data\Currencies\CurrencyDataAttributes;
use App\Data\Currencies\CurrencyDataOptions;
use App\Models\Currency;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\WriteOrUpdateInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class CurrencyRepository extends Repository implements ReadInterface, FindInterface, WriteOrUpdateInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = Currency::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::CURRENCIES;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Currency>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, CurrencyDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, CurrencyDataOptions::class));
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
     * @return Currency|null
     */
    public function find(int $id): ?Currency
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
     * @return Currency
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): Currency
    {
        if (!is_a($attributes, CurrencyDataAttributes::class) || !is_a($values, CurrencyDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($attributes::class, CurrencyDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->newQuery()->updateOrCreate($attributes->toArray(), $values->toArray());
    }
}
