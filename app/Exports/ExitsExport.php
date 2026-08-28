<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExitsExport implements FromView, ShouldAutoSize
{
    protected $exits;

    public function __construct($exits)
    {
        $this->exits = $exits;
    }

    public function view(): View
    {
        return view('exports.exits_excel', [
            'exits' => $this->exits
        ]);
    }
}
