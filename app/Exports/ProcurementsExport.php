<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProcurementsExport implements FromView, ShouldAutoSize
{
    protected $procurements;

    public function __construct($procurements)
    {
        $this->procurements = $procurements;
    }

    public function view(): View
    {
        return view('exports.procurements_excel', [
            'procurements' => $this->procurements
        ]);
    }
}
