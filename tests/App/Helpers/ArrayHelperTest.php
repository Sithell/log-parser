<?php

namespace App\Helpers;

use Console\App\Helpers\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    public function testMerge()
    {
        $this->assertEquals(
            ['1' => 1, '2' => 2, '3' => 1],
            ArrayHelper::merge(
                ['1' => 1, '2' => 1],
                ['2' => 1, '3' => 1]
            )
        );
    }
}