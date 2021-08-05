<?php

namespace Tests\Unit;

use App\Models\Sudoku;
use Database\Factories\SudokuFactory;
use PHPUnit\Framework\TestCase;

class SudokuTest extends TestCase
{
    private $sudoku;

    protected function setUp(): void
    {
        parent::setUp();

        $sudoku = new Sudoku;
        $factory = new SudokuFactory;

        $alpha = $factory->getAlpha(9);
        $positions = array_map(
            function ($row) use ($alpha) {
                return array_combine($alpha, $row);
            },
            [
                [1, 4, 5, 6, 7, 8, 9, 2, 3],
                [2, 6, 7, 0, 0, 0, 0, 0, 0],
                [3, 8, 9, 0, 0, 0, 0, 0, 0],
                [4, 0, 0, 0, 0, 0, 0, 0, 0],
                [5, 0, 0, 0, 0, 0, 0, 0, 0],
                [6, 0, 0, 0, 0, 0, 0, 0, 0],
                [7, 0, 0, 0, 0, 0, 0, 0, 0],
                [8, 0, 0, 0, 0, 0, 0, 0, 0],
                [9, 0, 0, 0, 0, 0, 0, 0, 0],
            ]
        );

        $sudoku->setPositions($positions);

        $this->sudoku = $sudoku;
    }

    public function test_getSection()
    {
        $position_set = $this->sudoku->getSection(0, 'A', 2, 'C');

        sort($position_set);

        $this->assertIsArray($position_set);
        $this->assertCount(9, $position_set);
        $this->assertEquals(
            range(1, 9),
            $position_set
        );
    }

    public function test_getColumn()
    {
        $position_set = $this->sudoku->getColumn('A');

        sort($position_set);

        $this->assertIsArray($position_set);
        $this->assertCount(9, $position_set);
        $this->assertEquals(
            range(1, 9),
            $position_set
        );
    }

    public function test_getRow()
    {
        $position_set = $this->sudoku->getRow(0);

        sort($position_set);

        $this->assertIsArray($position_set);
        $this->assertCount(9, $position_set);
        $this->assertEquals(
            range(1, 9),
            $position_set
        );
    }
}
