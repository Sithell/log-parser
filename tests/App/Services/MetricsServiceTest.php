<?php

namespace App\Services;

use Console\App\Services\MetricsService;
use PHPUnit\Framework\TestCase;

class MetricsServiceTest extends TestCase
{
    public function testCollectMetrics()
    {
        $metricsCollected = MetricsService::instance()->collectMetrics([
            '84.242.208.111 - - [11/May/2013:06:31:00 +0200] "POST /chat.php HTTP/1.1" 200 354 "http://bim-bom.ru/" "Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0"',
            '91.224.96.130 - - [11/May/2013:04:09:02 -0700] "GET /mod.php HTTP/1.0" 301 12413 "http://wiki.org/index.php#lang=en" "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)"',
            'This is a bad line',
            '77.21.132.156 - - [24/May/2013:23:38:03 +0200] "POST /app/engine/api.php HTTP/1.1" 200 80 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) Googlebot/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"'
        ]);
        $this->assertEquals(3, $metricsCollected->views());
        $this->assertEquals(434, $metricsCollected->traffic());
        $this->assertEquals([200 => 2, 301 => 1], $metricsCollected->statusCodes());

        $crawlers = $metricsCollected->crawlers();
        $this->assertArrayHasKey('Google', $crawlers);
        $this->assertEquals(1, $crawlers['Google']);
        unset($crawlers['Google']);
        $this->assertEmpty(array_filter($crawlers));

        $this->assertEquals(count($metricsCollected->distinctUrlHashes()), $metricsCollected->distinctUrlsCount());
        $this->assertEquals(1, $metricsCollected->badLines());
    }
}