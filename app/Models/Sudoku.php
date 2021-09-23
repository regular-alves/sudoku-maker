<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sudoku extends Model
{
    use HasFactory;

    protected $fillable = [
        'positions'
    ];
    protected $cast = [
        'positions' => 'json'
    ];

    public function setPositions($positions): void
    {
        $this['positions'] = $positions;
    }

    public function getSection(
        int $yAxisRow,
        string $yAxisCol,
        int $xAxisRow,
        string $xAxisCol,
        bool $without_null = false
    ): array {
        $yAxisCol = strtolower($yAxisCol);
        $xAxisCol = strtolower($xAxisCol);
        $result_set = [];

        array_map(
            function ($row) use ($yAxisCol, $xAxisCol, &$result_set) {
                for ($i = $yAxisCol; $i <= $xAxisCol; $i++) {
                    $result_set[] = $row[$i];
                }
            },
            array_slice($this->positions, $yAxisRow, ($xAxisRow - $yAxisRow) + 1, true)
        );

        if ($without_null) {
            $result_set = $this->clean($result_set);
        }

        return $result_set;
    }

    public function getColumn(string $col, bool $without_null = false): array
    {
        $col = strtolower($col);
        $result_set = [];

        foreach ($this->positions as $row) {
            $result_set[] = $row[$col];
        }

        if ($without_null) {
            $result_set = $this->clean($result_set);
        }

        return $result_set;
    }

    public function getRow(int $row, bool $without_null = false): array
    {
        $result_set = $this->positions[$row];

        if ($without_null) {
            $result_set = $this->clean($result_set);
        }

        return $result_set;
    }

    private function clean(array $fields)
    {
        return array_filter(
            $fields,
            fn ($val) => boolval($val)
        );
    }

    public function isValid()
    {
        $board_length = count($this->positions);
        $section_length = sqrt($board_length);

        $columns = array_keys($this->positions[0]);
        $sequence = range(1, $board_length);


        for ($i = 0; $i < $board_length; $i++) {
            $sec_row_start = floor($i / $section_length) * $section_length;
            $sec_row_end = $sec_row_start + $section_length - 1;

            $sec_col_start = ($i % $section_length) * $section_length;
            $sec_col_end = $sec_col_start + $section_length - 1;

            if (
                !isset($columns[$sec_col_start]) ||
                !isset($columns[$sec_col_end]) ||
                !isset($columns[$i])
            ) {
                return false;
            }

            $section = $this->getSection(
                $sec_row_start,
                $columns[$sec_col_start],
                $sec_row_end,
                $columns[$sec_col_end],
                true
            );

            $row = $this->getRow($i, true);
            $col = $this->getColumn($columns[$i], true);

            array_unique($row);
            array_unique($col);
            array_unique($section);

            sort($row);
            sort($col);
            sort($section);

            if (
                count($section) !== $board_length ||
                count($row) !== $board_length ||
                count($col) !== $board_length ||
                $section !== $sequence ||
                $row !== $sequence ||
                $col !== $sequence
            ) {
                return false;
            }
        }

        return true;
    }

    public function getSectionFrom(int $row, string $col, bool $without_null = false): array
    {
        $section_length = sqrt(count($this->positions));
        $columns = array_keys($this->positions[0]);

        if (!in_array($col, $columns)) {
            return [];
        }

        $col = array_search($col, $columns);

        $sec_row_start = floor($row / $section_length) * $section_length;
        $sec_row_end = ($sec_row_start + $section_length) - 1;

        $sec_col_start = floor($col / $section_length) * $section_length;
        $sec_col_end = ($sec_col_start + $section_length) - 1;

        return $this->getSection(
            $sec_row_start,
            $columns[$sec_col_start],
            $sec_row_end,
            $columns[$sec_col_end],
            $without_null
        );
    }

    public function toTable()
    {
        ob_start();

        echo '<table style="border:1px solid #000; text-align: center;">';

        foreach($this->positions as $row) {
            echo '<tr>';

            foreach($row as $col) {
                echo '<td>';
                // echo '<input type="text" style="width: 25px;" value="' . $col . '"/>';
                echo $col;
                echo '</td>';
            }

            echo '</tr>';
        }

        echo '</table>';

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}
