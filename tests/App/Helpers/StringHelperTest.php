<?php

namespace App\Helpers;

use Console\App\Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function testMatch()
    {
        $pattern = '/^\D*(\d+)\D*$/';
        $subject = 'My age is 18 years';
        preg_match($pattern, $subject, $resultPreg);
        $resultMatch = StringHelper::match($pattern, $subject);
        $this->assertEquals($resultPreg, $resultMatch);
    }

    public function testContains()
    {
        $this->assertTrue(StringHelper::contains('Lore ipsum dolor sit', 'ipsum'));
        $this->assertTrue(StringHelper::contains('Multiline
        String', PHP_EOL));

        $this->assertFalse(StringHelper::contains('No text here', '121'));
        $this->assertFalse(StringHelper::contains('UPPERCASE TEXT', 'uppercase'));
        $this->assertFalse(StringHelper::contains('', 'something'));
        $this->assertFalse(StringHelper::contains('Something', ''));
        $this->assertFalse(StringHelper::contains('', ''));
    }

    public function testHash()
    {
        $caseString = '77.21.132.156 - - [24/May/2013:23:38:05 +0200] "POST /chat.php?id=a65 HTTP/1.1" 200 31 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"';
        $this->assertEquals(md5($caseString), StringHelper::hash($caseString));
    }
}