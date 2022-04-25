<?php

namespace Console\App\Services;

use Console\App\Exceptions\ParsingException;
use Console\App\Helpers\HttpStatusCodeHelper;
use Console\App\Traits\SingletonTrait;
use Console\App\Helpers\StringHelper;
use Console\App\Models\Metrics;

class MetricsService
{
    use SingletonTrait;

    /**
     * Counts metrics for a given set of lines
     * @param string[] $lines
     * @return Metrics
     */
    public function collectMetrics(array $lines): Metrics
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
                $logEntry = ParsingService::instance()->parseLine($line);
            }
            catch (ParsingException) {
                $badLines++;
                continue;
            }

            // @todo Use https://github.com/JayBizzle/Crawler-Detect to detect crawlers
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

            // According to https://gist.github.com/flrnull/7304afeb9e8a1f4faec3 redirects are not counted as traffic
            if (!HttpStatusCodeHelper::isRedirect($logEntry->statusCode())) {
                $traffic += $logEntry->bytes();
            }
        }

        return new Metrics(count($lines) - $badLines, $traffic, $statusCodes, $crawlers, $distinctUrlHashes, $badLines);
    }
}