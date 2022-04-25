<?php

namespace App\Services;

use Console\App\Exceptions\ParsingException;
use Console\App\Services\ParsingService;
use PHPUnit\Framework\TestCase;

class ParsingServiceTest extends TestCase
{
    public function testParseValidLine()
    {
        $line = '77.21.132.156 - - [24/May/2013:23:38:23 +0200] "POST /app/modules/randomgallery.php HTTP/1.1" 200 46542 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"';
        try {
            $logEntry = ParsingService::parseLine($line);
        } catch (ParsingException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals('/app/modules/randomgallery.php', $logEntry->path());
        $this->assertEquals(200, $logEntry->statusCode());
        $this->assertEquals(46542, $logEntry->bytes());
    }

    public function testParseBadLine()
    {
        $this->expectException(ParsingException::class);
        $line = 'This is an invalid log entry';
        ParsingService::parseLine($line);
    }
}