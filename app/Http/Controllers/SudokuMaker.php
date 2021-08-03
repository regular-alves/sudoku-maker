<?php

namespace App\Http\Controllers;

use App\Models\Sudoku;
use Illuminate\Http\Request;

class SudokuMaker extends Controller
{
    static function make(): Sudoku
    {
        $sudoku = new Sudoku();

        $sudoku->positions = (new Self)->getPositions();

        return $sudoku;
    }

    public function getPositions(): array
    {
        $columns = $rows = [];

        for ($i = 'a'; $i < 'j'; $i++) {
            $columns[$i] = null;
        }

        for ($i = 0; $i < 9; $i++) {
            $rows[$i] = $columns;
        }

        return $rows;
    }
}
