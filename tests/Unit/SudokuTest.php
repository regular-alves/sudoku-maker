<?php

namespace Tests\Unit;

use App\Http\Controllers\SudokuMaker;
use PHPUnit\Framework\TestCase;

class SudokuTest extends TestCase
{
    protected $sudoku;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sudoku = SudokuMaker::make();
    }

    public function test_getSection()
    {
        $position_set = $this->sudoku->getSection(1, 'A', 3, 'C');
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
        $position_set = $this->sudoku->getRow(1);
        $this->assertIsArray($position_set);
        $this->assertCount(9, $position_set);
    }
}
