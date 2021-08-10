<?php

namespace Tests\Feature;

use App\Models\Sudoku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SudokuFactoryTest extends TestCase
{
    private $sudoku;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sudoku = Sudoku::factory()->make();
    }

    public function test_MustReturnASudokuInstance()
    {
        $this->assertInstanceOf(Sudoku::class, $this->sudoku);
        $this->assertEquals(true, $this->sudoku->isValid());
    }
}
