<?php

namespace Database\Factories;

use App\Models\Sudoku;
use Illuminate\Database\Eloquent\Factories\Factory;

class SudokuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sudoku::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'positions' => $this->getPositions()
        ];
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
