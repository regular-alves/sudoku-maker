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
        $result_set = [];

        array_map(
            function ($row) use ($yAxisCol, $xAxisCol, &$result_set) {
                for ($i = $yAxisCol; $i <= $xAxisCol; $i++) {
                    $result_set[] = $row[$i];
                }
            },
            array_slice($this->positions, $yAxisRow, ($xAxisRow - $yAxisRow) + 1, true)
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
