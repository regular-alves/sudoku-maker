<?php

namespace Tests\Unit;

use App\Models\Sudoku;
use Database\Factories\SudokuFactory;
use PHPUnit\Framework\TestCase;

class SudokuTest extends TestCase
{
    private $sudoku;
    private $invalid;

    protected function setUp(): void
    {
        parent::setUp();

        $sudoku = new Sudoku;
        $invalid = new Sudoku;
        $factory = new SudokuFactory;

        $alpha = $factory->getAlpha(9);
        $sudoku->setPositions(array_map(
            function ($row) use ($alpha) {
                return array_combine($alpha, $row);
            },
            [
                [1, 4, 7, 2, 5, 8, 3, 6, 9],
                [2, 5, 8, 3, 6, 9, 1, 4, 7],
                [3, 6, 9, 1, 4, 7, 2, 5, 8],
                [4, 7, 1, 5, 8, 2, 6, 9, 3],
                [5, 8, 2, 6, 9, 3, 4, 7, 1],
                [6, 9, 3, 4, 7, 1, 5, 8, 2],
                [7, 1, 4, 8, 2, 5, 9, 3, 6],
                [8, 2, 5, 9, 3, 6, 7, 1, 4],
                [9, 3, 6, 7, 1, 4, 8, 2, 5],
            ]
        ));

        $invalid->setPositions(array_map(
            function ($row) use ($alpha) {
                return array_combine($alpha, $row);
            },
            [
                [1, 4, 7, 2, 5, 8, 3, 6, 9],
                [1, 4, 7, 2, 5, 8, 3, 6, 9],
                [3, 6, 9, 1, 4, 7, 2, 5, 8],
                [4, 7, 1, 5, 8, 2, 6, 9, 3],
                [5, 8, 2, 6, 9, 3, 4, 7, 1],
                [6, 9, 3, 4, 7, 1, 5, 8, 2],
                [7, 1, 4, 8, 2, 5, 9, 3, 6],
                [8, 2, 5, 9, 3, 6, 7, 1, 4],
                [9, 3, 6, 7, 1, 4, 8, 2, 5],
            ]
        ));

        $this->sudoku = $sudoku;
        $this->invalid = $invalid;
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

    public function test_getSectionFrom()
    {
        $first_set = $this->sudoku->getSectionFrom(0, 'a');
        $second_set = $this->sudoku->getSectionFrom(2, 'c');
        $third_set = $this->sudoku->getSectionFrom(10, 'k');

        sort($first_set);
        sort($second_set);

        $this->assertIsArray($first_set);
        $this->assertEquals(range(1, 9), $first_set);
        $this->assertCount(9, $first_set);

        $this->assertIsArray($second_set);
        $this->assertEquals(range(1, 9), $second_set);
        $this->assertCount(9, $second_set);

        $this->assertIsArray($third_set);
        $this->assertEquals([], $third_set);
        $this->assertCount(0, $third_set);
    }

    public function test_getNotAllowedFromAdjacent()
    {
        $first_set = $this->sudoku->getNotAllowedFromAdjacent(0, 'a');
        $second_set = $this->sudoku->getNotAllowedFromAdjacent(8, 'i');
        $third_set = $this->sudoku->getNotAllowedFromAdjacent(4, 'e');

        $this->assertIsArray($first_set);
        $this->assertEquals([1,3,5], $first_set);

        $this->assertIsArray($second_set);
        $this->assertEquals([1,3,5], $second_set);

        $this->assertIsArray($third_set);
        $this->assertEquals([2,4,5,6,7,8,9], $third_set);
    }

    public function testSudokuValider()
    {
        $this->assertEquals(true, $this->sudoku->isValid());
        $this->assertEquals(false, $this->invalid->isValid());
    }
}
