<?php

namespace Tests;

use App\RomanNumberConverter;
use PHPUnit\Framework\TestCase;

class RomanNumberConverterTest extends TestCase
{

    private $underTest;

    public function setUp(): void
    {
        $this->underTest = new RomanNumberConverter();
    }

    /**
     * @test
     */
    public function it_should_return_I_for_1()
    {
        $actual = $this->underTest->convert(1);

        $this->assertEquals("I", $actual);
    }
}