<?php

namespace Tests\Unit;

use App\Models\Sudoku;
use PHPUnit\Framework\TestCase;

class SudokuTest extends TestCase
{
    protected $sudoku;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sudoku = Sudoku::factory()->make();
    }

    public function test_getSection()
    {
        $position_set = $this->sudoku->getSection(0, 'A', 2, 'C');
        $this->assertIsArray($position_set);
        $this->assertCount(9, $position_set);
    }

    public function test_getColumn()
    {
        $position_set = $this->sudoku->getColumn('A');
        $this->assertIsArray($position_set);
        $this->assertCount(9, $position_set);
    }

    public function test_getRow()
    {
        $position_set = $this->sudoku->getRow(0);
        $this->assertIsArray($position_set);
        $this->assertCount(9, $position_set);
    }
}
