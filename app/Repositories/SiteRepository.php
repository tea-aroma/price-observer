<?php

namespace App\Repositories;


use App\Data\Sites\SiteDataAttributes;
use App\Data\Sites\SiteDataOptions;
use App\Models\Site;
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
class SiteRepository extends Repository implements ReadInterface, FindInterface, WriteOrUpdateInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = Site::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::SITES;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Site>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, SiteDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, SiteDataOptions::class));
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
     * @return Site|null
     */
    public function find(int $id): ?Site
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
     * @return Site
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): Site
    {
        if (!is_a($attributes, SiteDataAttributes::class) || !is_a($values, SiteDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($attributes::class, SiteDataOptions::class));
        }

        $this->cacheRepository->flush();

        return $this->newQuery()->updateOrCreate($attributes->toArray(), $values->toArray());
    }
}
