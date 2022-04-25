<?php

namespace Console\App\Services;

use Console\App\Exceptions\ParsingException;
use Console\App\Traits\SingletonTrait;
use Console\App\Helpers\StringHelper;
use Console\App\Models;

class MetricsService
{
    use SingletonTrait;

    /**
     * Counts metrics for a given set of lines
     * @param string[] $lines
     * @return Models\Metrics
     */
    public function collectMetrics(array $lines): Models\Metrics
    {
        $statusCodes = [];
        $distinctUrlHashes = [];
        $traffic = 0;
        $crawlers = [
            'Google' => 0,
            'Bing' => 0,
            'Baidu' => 0,
            'Yandex' => 0
        ];
        $badLines = 0;
        foreach ($lines as $line) {
            try {
                $logEntry = $this->parseLine($line);
            }
            catch (ParsingException) {
                $badLines++;
                continue;
            }

            foreach (array_keys($crawlers) as $crawler) {
                if (StringHelper::contains($logEntry->agent(), $crawler)) {
                    $crawlers[$crawler]++;
                }
            }
            $statusCodes[$logEntry->statusCode()] = ($statusCodes[$logEntry->statusCode()] ?? 0) + 1;

            $pathHash = StringHelper::hash($logEntry->path());
            if (!in_array($pathHash, $distinctUrlHashes)) {
                $distinctUrlHashes[] = $pathHash;
            }
            $traffic += $logEntry->bytes();
        }

        return new Models\Metrics(count($lines), $traffic, $statusCodes, $crawlers, $distinctUrlHashes, $badLines);
    }

    /**
     * Parse string containing apache access_log log entry
     * Get path, status code, request size in bytes and user-agent
     * @param string $line
     * @return Models\LogEntry
     * @throws ParsingException
     */
    private static function parseLine(string $line): Models\LogEntry
    {
        $matches = StringHelper::match(
            '/^\S+ \S+ \S+ \[[^:]+:\d+:\d+:\d+ [^]]+] \"\S+ (.*?) \S+\" (\S+) (\S+) \".*?\" (\".*?\")$/',
            $line
        );
        if (count($matches) <= 4) {
            throw new ParsingException("Bad line: $line");
        }
        return (new Models\LogEntry())
            ->setPath($matches[1])
            ->setStatusCode($matches[2])
            ->setBytes($matches[3])
            ->setAgent($matches[4]);
    }
}