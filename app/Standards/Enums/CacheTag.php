<?php

namespace App\Standards\Enums;


/**
 * Represents a cache tag for this app.
 */
enum CacheTag
{
    case CLASSIFIERS;

    case SITES;

    case CURRENCIES;

    case RECIPIENTS;

    case ITEM_STATUSES;

    case ITEM_DELAYS;

    case ITEMS;

    case ITEMS_HISTORY;
}
