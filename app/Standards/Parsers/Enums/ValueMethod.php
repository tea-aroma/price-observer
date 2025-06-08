<?php

namespace App\Standards\Parsers\Enums;


/**
 * Represents a method name which gets a value for Parser.
 */
enum ValueMethod: string
{
    case PLATFORM_ID = 'platformId';

    case SELLER_ID = 'sellerId';

    case NAME = 'name';

    case IMAGE = 'image';

    case URL = 'url';

    case NOTE = 'note';

    case CURRENCY = 'currency';

    case PARAMETERS = 'parameters';

    case PUBLICATE_AT = 'publicateAt';

    case SITE_ID = 'siteId';
}
