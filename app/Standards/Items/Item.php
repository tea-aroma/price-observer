<?php

namespace App\Standards\Items;


use App\Data\Items\ItemData;
use App\Data\Items\ItemDataAttributes;
use App\Data\ItemsHistory\ItemHistoryData;
use App\Data\ItemsHistory\ItemHistoryDataAttributes;
use App\Data\ItemsInformation\ItemInformationDataAttributes;
use App\Repositories\ItemHistoryRepository;
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
     * Creates an item by the specified parser.
     *
     * @param ParserInterface $parser
     *
     * @return ItemData
     */
    public function create(ParserInterface $parser): ItemData
    {
        $parser->initialization();

        $item = ItemRepository::query()->findByValue($parser->platformId());

        if ($item)
        {
            return ItemData::fromArray($item->toArray());
        }

        return $this->createOrUpdate($parser);
    }

    /**
     * Updates an item by the specified parser.
     *
     * @param ParserInterface $parser
     *
     * @return ItemData
     */
    public function update(ParserInterface $parser): ItemData
    {
        $parser->initialization();

        return $this->createOrUpdate($parser);
    }

    /**
     * @param ParserInterface $parser
     *
     * @return ItemData
     */
    protected function createOrUpdate(ParserInterface $parser): ItemData
    {
        DB::beginTransaction();

        $attributes = ItemDataAttributes::fromArray([ 'site_id' => $parser->siteId(), 'platform_id' => $parser->platformId(), 'seller_id' => $parser->sellerId() ]);

        $values = ItemDataAttributes::fromArray($parser->toArray());

        $item = ItemRepository::query()->writeOrUpdate($attributes, $values);

        $informationAttributes = ItemInformationDataAttributes::fromArray([ 'item_id' => $item->id ]);

        $informationValues = ItemInformationDataAttributes::fromArray($parser->toArray());

        $itemInformation = ItemInformationRepository::query()->writeOrUpdate($informationAttributes, $informationValues);

        $itemData = ItemData::fromArray($item->toArray());

        $this->createHistory($itemData, $parser);

        DB::commit();

        return $itemData;
    }

    /**
     * @param ItemData        $item
     * @param ParserInterface $parser
     *
     * @return ItemHistoryData
     */
    public function createHistory(ItemData $item, ParserInterface $parser): ItemHistoryData
    {
        $oldHistory = ItemHistoryRepository::query()->latestByItemId($item->id);

        $historyAttributes = new ItemHistoryDataAttributes([]);

        $historyAttributes->item_id = $item->id;

        $historyAttributes->new_price = $parser->price();

        $historyAttributes->new_price_text = $parser->textPrice();

        if ($oldHistory)
        {
            $oldHistoryData = ItemHistoryData::fromArray($oldHistory->toArray());

            $historyAttributes->old_price = $oldHistoryData->new_price;

            $historyAttributes->old_price_text = $oldHistoryData->new_price_text;
        }

        $record = ItemHistoryRepository::query()->write($historyAttributes);

        return ItemHistoryData::fromArray($record->toArray());
    }

    /**
     * @param ParserInterface $parser
     *
     * @return bool
     */
    public function compare(ParserInterface $parser): bool
    {
        $parser->initialization();

        $item = ItemRepository::query()->findByValue($parser->platformId());

        if (!$item)
        {
            return false;
        }

        return true;
    }
}
