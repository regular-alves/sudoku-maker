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

    public function getSection(
        int $yAxisRow,
        string $yAxisCol,
        int $xAxisRow,
        string $xAxisCol
    ): array {
        $yAxisCol = strtolower($yAxisCol);
        $xAxisCol = strtolower($xAxisCol);

        $positions = array_map(
            function ($row) use ($yAxisCol, $xAxisCol) {
                $return_set = [];

                for ($i = $yAxisCol; $i <= $xAxisCol; $i++) {
                    $return_set[] = $row[$i];
                }

                return $return_set;
            },
            array_slice($this->positions, $yAxisRow, $xAxisRow, true)
        );

        $result_set = [];

        array_walk_recursive(
            $positions,
            function ($col) use (&$result_set) {
                $result_set[] = $col;
            }
        );

        return $result_set;
    }

    public function getColumn(string $col): array
    {
        $col = strtolower($col);
        $result_set = [];

        foreach ($this->positions as $row) {
            $result_set[] = $row[$col];
        }

        return $result_set;
    }

    public function getRow(int $row): array
    {
        return $this->positions[$row];
    }
}
