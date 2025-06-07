<?php

namespace App\Repositories;


use App\Data\Currencies\CurrencyDataAttributes;
use App\Data\Currencies\CurrencyDataOptions;
use App\Models\Currency;
use App\Models\Setting;
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
class SettingRepository extends Repository implements FindByValueInterface
{
    /**
     * @var string|null
     */
    protected ?string $modelNamespace = Setting::class;

    /**
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::CLASSIFIERS;

    /**
     * @inheritDoc
     *
     * @param string $value
     * @param string $column
     *
     * @return Model|null
     */
    public function findByValue(string $value, string $column = 'key'): ?Model
    {
        return $this->cacheRepository->remember($value . $column, function () use ($value, $column)
        {
            return $this->newQuery()->where($column, '=', $value)->first();
        });
    }
}
