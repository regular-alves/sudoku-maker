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
}
