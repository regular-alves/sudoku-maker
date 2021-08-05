<?php

namespace Tests\Unit;

use Database\Factories\SudokuFactory;
use PHPUnit\Framework\TestCase;

class SudokuFactoryTest extends TestCase
{
    protected $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new SudokuFactory();
    }

    public function test_GetAlphaShouldReturnSequenceFromAToB()
    {
        $sequence = $this->factory->getAlpha(3);
        $this->assertEquals(['a', 'b', 'c'], $sequence);
    }
}
