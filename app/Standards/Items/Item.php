<?php

namespace App\Standards\Items;


use App\Data\Items\ItemData;
use App\Data\Items\ItemDataAttributes;
use App\Data\ItemsInformation\ItemInformationDataAttributes;
use App\Repositories\ItemInformationRepository;
use App\Repositories\ItemRepository;
use App\Standards\Parsers\Interfaces\ParserInterface;
use Illuminate\Support\Facades\DB;


/**
 * Provides the managing logic for Items.
 */
class Item
{
    /**
     * Creates an item by the specified url.
     *
     * @param ParserInterface $parser
     *
     * @return ItemData
     */
    public function create(ParserInterface $parser): ItemData
    {
        $parser->initialization();

        DB::beginTransaction();

        $item = ItemRepository::query()->findByValue($parser->platformId());

        if ($item)
        {
            return ItemData::fromArray($item->toArray());
        }

        $attributes = ItemDataAttributes::fromArray($parser->toArray());

        $informationAttributes = ItemInformationDataAttributes::fromArray($parser->toArray());

        $item = ItemRepository::query()->write($attributes);

        $informationAttributes->item_id = $item->id;

        $itemInformation = ItemInformationRepository::query()->write($informationAttributes);

        DB::commit();

        return ItemData::fromArray($item->toArray());
    }
}
