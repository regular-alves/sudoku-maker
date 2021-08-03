<?php

namespace Tests\Feature;

use App\Models\Sudoku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SudokuMakerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_MustReturnASudokuInstance()
    {
        $sudoku = Sudoku::factory()->make();

        $this->assertInstanceOf(Sudoku::class, $sudoku);
    }

    public function test_GetPositionsMustReturnAnArrayOfArrays()
    {
        $sudoku = Sudoku::factory()->make();

        $this->assertCount(9, $sudoku->positions);

        foreach ($sudoku->positions as $row) {
            $this->assertCount(9, $row);
        }
    }
}
