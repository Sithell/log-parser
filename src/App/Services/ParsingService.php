<?php

namespace Console\App\Services;

use Console\App\Exceptions\ParsingException;
use Console\App\Helpers\StringHelper;
use Console\App\Models\LogEntry;
use Console\App\Traits\SingletonTrait;

class ParsingService
{
    use SingletonTrait;

    /**
     * Parse string containing apache access_log log entry
     * Get path, status code, request size in bytes and user-agent
     * @param string $line
     * @return LogEntry
     * @throws ParsingException
     */
    public static function parseLine(string $line): LogEntry
    {
        $matches = StringHelper::match(
            '/^\S+ \S+ \S+ \[[^:]+:\d+:\d+:\d+ [^]]+] \"\S+ (.*?) \S+\" (\S+) (\S+) \".*?\" (\".*?\")$/',
            $line
        );
        if (count($matches) <= 4) {
            throw new ParsingException("Bad line: $line");
        }
        return (new LogEntry())
            ->setPath($matches[1])
            ->setStatusCode($matches[2])
            ->setBytes($matches[3])
            ->setAgent($matches[4]);
    }
}