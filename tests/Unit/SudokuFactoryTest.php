<?php

namespace Tests\Unit;

use App\Models\Sudoku;
use Database\Factories\SudokuFactory;
use PHPUnit\Framework\TestCase;

class SudokuFactoryTest extends TestCase
{
    protected $factory;
    protected $sudoku;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new SudokuFactory();
        $this->sudoku = Sudoku::factory()->make();
    }

    public function test_GetAlphaShouldReturnSequenceFromAToB()
    {
        $sequence = $this->factory->getAlpha(3);
        $this->assertEquals(['a', 'b', 'c'], $sequence);
    }

    public function test_GetPositionsMustReturnAnArrayOfArrays()
    {
        $this->assertCount(9, $this->sudoku->positions);

        foreach ($this->sudoku->positions as $row) {
            $this->assertCount(9, $row);
        }
    }

    public function test_SudokuShouldBefilledInAllPositions()
    {
        $this->assertCount(9 * 9, $this->sudoku->getSection(0, 'A', 8, 'I', true));
    }
}
