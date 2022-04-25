<?php

namespace Console\App\Models;

use Console\App\Helpers\ArrayHelper;


class Metrics
{
    private int $views;
    private int $traffic;

    /** @var array<int,int> */
    private array $statusCodes;

    /** @var array<string,int> */
    private array $crawlers;

    /** @var string[] */
    private array $distinctUrlHashes;
    private int $badLines;


    public function __construct(int $views = 0, int $traffic = 0, array $statusCodes = [], array $crawlers = [], array $distinctUrlHashes = [], int $badLines = 0)
    {
        $this->views = $views;
        $this->traffic = $traffic;
        $this->statusCodes = $statusCodes;
        $this->crawlers = $crawlers;
        $this->distinctUrlHashes = $distinctUrlHashes;
        $this->badLines = $badLines;
    }

    /**
     * Adds data from another Metrics object
     * @param Metrics $other
     * @return $this
     */
    public function add(Metrics $other): Metrics
    {
        $this->views += $other->views();
        $this->traffic += $other->traffic();
        $this->distinctUrlHashes = array_merge($this->distinctUrlHashes(), $other->distinctUrlHashes());
        $this->statusCodes = ArrayHelper::merge($this->statusCodes(), $other->statusCodes());
        $this->crawlers = ArrayHelper::merge($this->crawlers(), $other->crawlers());
        $this->badLines += $other->badLines();
        return $this;
    }

    /**
     * @return array{views: int, urls: int, statusCodes: array<int,int>, crawlers: array<int,int>}
     */
    public function toArray(): array
    {
        return [
            'views' => $this->views(),
            'urls' => $this->distinctUrlsCount(),
            'traffic' => $this->traffic(),
            'statusCodes' => $this->statusCodes(),
            'crawlers' => $this->crawlers(),
        ];
    }

    /**
     * @return int
     */
    public function views(): int
    {
        return $this->views;
    }

    /**
     * @return int
     */
    public function traffic(): int
    {
        return $this->traffic;
    }

    /**
     * @return array
     */
    public function statusCodes(): array
    {
        return $this->statusCodes;
    }

    /**
     * @return array
     */
    public function crawlers(): array
    {
        return $this->crawlers;
    }

    /**
     * @return int
     */
    public function distinctUrlsCount(): int
    {
        return count($this->distinctUrlHashes);
    }

    /**
     * @return string[]
     */
    public function distinctUrlHashes(): array
    {
        return $this->distinctUrlHashes;
    }

    /**
     * @return int
     */
    public function badLines(): int
    {
        return $this->badLines;
    }
}