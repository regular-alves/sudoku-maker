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

    public function configure()
    {
        return $this->afterMaking(fn (Sudoku $sudoku) => $this->polulate($sudoku));
    }

    public function polulate(Sudoku $sudoku)
    {
        $positions = $sudoku->positions;

        $section_length = 3;
        $board_length = pow($section_length, 2);

        $columns = $this->getAlpha($board_length);
        $fields = range(0, pow($board_length, 2) - 1);
        $possible_num = range(1, $board_length);

        shuffle($fields);

        foreach ($fields as $n) {
            unset(
                $row_n,
                $col_n,
                $sec_row_start,
                $sec_row_end,
                $sec_col_start,
                $sec_col_end,
                $setted_num,
                $remain,
                $key
            );

            $row_n = floor($n / $board_length);
            $col_n = $n % $board_length;

            $sec_row_start = floor($row_n / $section_length) * $section_length;
            $sec_row_end = ($sec_row_start + $section_length) - 1;

            $sec_col_start = floor($col_n / $section_length) * $section_length;
            $sec_col_end = ($sec_col_start + $section_length) - 1;

            $setted_num = array_merge(
                $sudoku->getRow($row_n, true),
                $sudoku->getColumn($columns[$col_n], true),
                $sudoku->getSection(
                    $sec_row_start,
                    $columns[$sec_col_start],
                    $sec_row_end,
                    $columns[$sec_col_end],
                    true
                )
            );

            $remain = array_diff($possible_num, $setted_num);
            $key = array_rand($remain);

            $positions[$row_n][$columns[$col_n]] = $remain[$key];
        }

        $sudoku->setPositions($positions);

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

    public function getAlpha(int $length): array
    {
        $letter = 'a';
        $columns = [];

        for ($i = 0; $i < $length; $i++) {
            $columns[] = $letter++;
        }

        return $columns;
    }
}
