<?php

namespace App\Standards\Parsers\Abstracts;


use App\Data\Sites\SiteDataAttributes;
use App\Repositories\SiteRepository;
use App\Standards\Enums\SettingKey;
use App\Standards\Parsers\Enums\ValueMethod;
use App\Standards\Parsers\Interfaces\ParserInterface;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Language;


/**
 * Provides the abstract logic for information Parsers.
 */
abstract class Parser implements ParserInterface
{
    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $html;

    /**
     * @var DOMDocument
     */
    protected DOMDocument $dom;

    /**
     * @var DOMXPath
     */
    protected DOMXPath $xpath;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;

        $this->dom = new DOMDocument();
    }

    /**
     * @return string
     */
    protected function fetch(): string
    {
        $html = '';

        try
        {
            $html = Http::withUserAgent(SettingKey::REQUEST_USER_AGENT->data()->value)
                ->withHeaders($this->headers())
                ->timeout(SettingKey::REQUEST_TIMEOUT->data()->value)
                ->get($this->url);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
        }

        return $html;
    }

    /**
     * Gets the headers.
     *
     * @return array
     */
    protected function headers(): array
    {
        return [
            'Accept' => '/',
            'Accept-Language' => 'en-US,en;q=0.9',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Referer' => 'https://www.olx.ua/',
        ];
    }

    /**
     * Performs the xpath query.
     *
     * @param string $expression
     *
     * @return DOMNodeList|false
     */
    protected function xpathQuery(#[Language('XPath')] string $expression): DOMNodeList | false
    {
        return $this->xpath->query($expression);
    }

    /**
     * @return void
     */
    public function initialization(): void
    {
        $this->html = Cache::remember($this->url, 3600, function ()
        {
            return $this->fetch();
        });


        libxml_use_internal_errors(true);

        $this->dom->loadHTML($this->html);

        $this->xpath = new DOMXPath($this->dom);
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function sellerId(): int
    {
        $nodes = $this->xpathQuery('//*[@id="olx-init-config"]/text()');

        $regex = '/\\\"user\\\":{\\\"id\\\":([0-9]+),\\\"name\\\":\\\"[^\"\']*\\\",/';

        preg_match($regex, $nodes->item(0)->nodeValue, $matches);

        return $matches[ 1 ];
    }

    /**
     * @return int
     */
    public function platformId(): int
    {
        $nodes = $this->xpathQuery('//*[@id="mainContent"]/div/div[2]/div[3]/div[1]/div[2]/div[6]/div/span');

        return preg_replace('/[^0-9]+/', '', $nodes->item(0)->nodeValue);
    }

    /**
     * @return int
     */
    public function siteId(): int
    {
        $url = parse_url($this->url);

        $basePath = $url['scheme'] . '://' . $url['host'];

        $siteAttributes = SiteDataAttributes::fromArray([ 'url' => $basePath ]);

        $siteValues = clone $siteAttributes;

        $siteValues->code = Str::slug($basePath);

        $siteValues->name = Str::random(20);

        $site = SiteRepository::query()->writeOrUpdate($siteAttributes, $siteValues);

        return $site->id;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $cases = ValueMethod::cases();

        $values = [];

        foreach ($cases as $case)
        {
            $values[ Str::snake($case->value) ] = $this->{ $case->value }();
        }

        return $values;
    }
}
