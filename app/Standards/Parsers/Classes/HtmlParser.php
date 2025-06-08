<?php

namespace App\Standards\Parsers\Classes;


use App\Standards\Parsers\Abstracts\Parser;
use App\Standards\Parsers\Interfaces\ParserInterface;


/**
 * Provides logic for parse only by HTML structure.
 */
class HtmlParser extends Parser implements ParserInterface
{
    /**
     * @return float
     */
    public function price(): float
    {
        $string = $this->textPrice();

        $string = str_replace(' ', '', $string);

        return preg_replace('/\D.*$/', '', $string);
    }

    /**
     * @return string|null
     */
    public function currency(): ?string
    {
        $string = $this->textPrice();

        $string = str_replace(' ', '', $string);

        preg_match('/^\d+\s*([^\d\/\.]+)/i', $string, $matches);

        return $matches[ 1 ] ?? null;
    }

    /**
     * @return string
     */
    public function textPrice(): string
    {
        $nodes = $this->xpathQuery('//*[@id="mainContent"]/div/div[2]/div[3]/div[2]/div[1]/div/div[3]/div/div/h3');

        return $nodes->item(0)->nodeValue;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        $nodes = $this->xpathQuery('//*[@id="mainContent"]/div/div[2]/div[3]/div[2]/div[1]/div/div[2]/h4');

        return $nodes->item(0)->nodeValue;
    }

    /**
     * @return string
     */
    public function image(): string
    {
        $nodes = $this->xpathQuery('//*[@id="mainContent"]/div/div[2]/div[3]/div[1]/div[1]/div/div[1]/div[1]/div/img');

        return $nodes->item(0)->attributes->getNamedItem('src')->nodeValue;
    }

    /**
     * @return string
     */
    public function note(): string
    {
        $nodes = $this->xpathQuery('//*[@id="mainContent"]/div/div[2]/div[3]/div[1]/div[2]/div[5]/div');

        return $nodes->item(0)->nodeValue;
    }

    /**
     * @return array
     */
    public function parameters(): array
    {
        $nodes = $this->xpathQuery('//*[@id="mainContent"]/div/div[2]/div[3]/div[1]/div[2]/div[3]/*');

        $parameters = [];

        foreach ($nodes->getIterator() as $node)
        {
            if (!in_array($node->nodeName, [ 'p', 'div' ]) || empty($node->nodeValue))
            {
                continue;
            }

            foreach ($node->childNodes as $childNode)
            {
                if (!in_array($childNode->nodeName, [ 'span', '#text' ]))
                {
                    continue;
                }

                $parameters[] = $childNode->textContent;
            }
        }

        return $parameters;
    }

    /**
     * @return string
     */
    public function publicateAt(): string
    {
        $nodes = $this->xpathQuery('//*[@id="mainContent"]/div/div[2]/div[3]/div[2]/div[1]/div/div[1]/span/span');

        return $nodes->item(0)->nodeValue;
    }
}
