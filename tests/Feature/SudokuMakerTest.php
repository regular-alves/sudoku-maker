<?php

namespace Tests\Feature;

use App\Http\Controllers\SudokuMaker;
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
    public function testMustReturnASudokuInstance()
    {
        $sudoku = SudokuMaker::make();

        $this->assertInstanceOf(Sudoku::class, $sudoku);
    }

    public function testGetPositionsMustReturnAnArrayOfArrays()
    {
        $maker = new SudokuMaker();
        $positions = $maker->getPositions();

        $this->assertCount(9, $positions);

        foreach ($positions as $row) {
            $this->assertCount(9, $row);
        }
    }
}
