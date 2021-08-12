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
        return $this->afterMaking(fn (Sudoku $sudoku) => $this->polulateBySection($sudoku));
    }

    public function polulateLinearly(Sudoku $sudoku)
    {
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
                $setted_num,
                $remain,
                $key,
                $positions
            );

            $row_n = floor($n / $board_length);
            $col_n = $n % $board_length;

            $setted_num = array_merge(
                $sudoku->getRow($row_n, true),
                $sudoku->getColumn($columns[$col_n], true),
                $sudoku->getSectionFrom($row_n, $columns[$col_n], true)
            );

            $remain = array_diff($possible_num, $setted_num);

            if (!$remain) {
                continue;
            }

            $key = array_rand($remain);

            $positions = $sudoku->positions;
            $positions[$row_n][$columns[$col_n]] = $remain[$key];
            $sudoku->setPositions($positions);
        }

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

    public function polulateBySection(Sudoku $sudoku): Sudoku
    {
        $section_length = 3;
        $board_length = pow($section_length, 2);
        $possibles = range(1, $board_length);
        $columns = $this->getAlpha($board_length);

        $counter = $i = 0;

        while (!$sudoku->isValid() && $counter < 50) {
            shuffle($possibles);

            $positions = $sudoku->positions;
            $row_n = floor($i / $section_length) * $section_length;
            $col_n = ($i % $section_length) * $section_length;

            foreach ($possibles as $k => $field) {
                $row = floor($k / $section_length);
                $col = $k % $section_length;
                $col = $columns[$col_n + $col];

                $positions[$row_n + $row][$col] = $field;
            }

            $sudoku->setPositions($positions);
            $counter++;
            $i++;

            if ($i >= $board_length) {
                $i = 0;
            }
        };

        return $sudoku;
    }
}
