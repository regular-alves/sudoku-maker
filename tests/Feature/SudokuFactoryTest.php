<?php

namespace Tests\Feature;

use App\Models\Sudoku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SudokuFactoryTest extends TestCase
{
    private $sudoku;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sudoku = Sudoku::factory()->make();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_MustReturnASudokuInstance()
    {
        $this->assertInstanceOf(Sudoku::class, $this->sudoku);
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
        $positions = array_filter(
            $this->sudoku->getSection(0, 'A', 8, 'I'),
            fn ($field) => boolval($field)
        );
        $this->assertCount(9 * 9, $positions);
    }
}
