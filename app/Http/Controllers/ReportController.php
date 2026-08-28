<?php

namespace App\Http\Controllers;

use App\Exports\ExitsExport;
use App\Exports\ItemsExport;
use App\Exports\ProcurementsExport;
use App\Models\Category;
use App\Models\FundingSource;
use App\Models\Item;
use App\Models\ItemExit;
use App\Models\Location;
use App\Models\Procurement;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display the report page with filters and listings.
     */
    public function index(Request $request): View
    {
        $type = $request->get('type', 'stock'); // Default report type is 'stock'

        $categories = Category::all();
        $suppliers = Supplier::all();
        $locations = Location::all();
        $fundingSources = FundingSource::all();
        $operators = User::where('role', 'operator')->get();

        $data = $this->getFilteredData($request, $type);

        return view('reports.index', compact(
            'type', 'categories', 'suppliers', 'locations', 'fundingSources', 'operators', 'data'
        ));
    }

    /**
     * Export reports to PDF.
     */
    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'stock');
        $data = $this->getFilteredData($request, $type);
        
        $pdf = Pdf::loadView('reports.pdf_' . $type, [
            'data' => $data,
            'filter' => $request->all(),
            'date' => date('d M Y')
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan_' . $type . '_' . date('YmdHis') . '.pdf');
    }

    /**
     * Export reports to Excel.
     */
    public function exportExcel(Request $request)
    {
        $type = $request->get('type', 'stock');
        $data = $this->getFilteredData($request, $type);

        $filename = 'laporan_' . $type . '_' . date('YmdHis') . '.xlsx';

        if ($type === 'stock') {
            return Excel::download(new ItemsExport($data), $filename);
        } elseif ($type === 'procurement') {
            return Excel::download(new ProcurementsExport($data), $filename);
        } else {
            return Excel::download(new ExitsExport($data), $filename);
        }
    }

    /**
     * Helper to retrieve filtered data based on report type.
     */
    private function getFilteredData(Request $request, string $type)
    {
        if ($type === 'stock') {
            $query = Item::with(['category', 'location']);

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->filled('location_id')) {
                $query->where('location_id', $request->location_id);
            }
            
            return $query->latest()->get();

        } elseif ($type === 'procurement') {
            $query = Procurement::with(['supplier', 'fundingSource', 'creator', 'items.item']);

            if ($request->filled('start_date')) {
                $query->whereDate('date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('date', '<=', $request->end_date);
            }
            if ($request->filled('supplier_id')) {
                $query->where('supplier_id', $request->supplier_id);
            }
            if ($request->filled('funding_source_id')) {
                $query->where('funding_source_id', $request->funding_source_id);
            }
            if ($request->filled('operator_id')) {
                $query->where('created_by', $request->operator_id);
            }

            return $query->latest()->get();

        } else { // exit
            $query = ItemExit::with(['item.category', 'item.location', 'creator']);

            if ($request->filled('start_date')) {
                $query->whereDate('date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('date', '<=', $request->end_date);
            }
            if ($request->filled('category_id')) {
                $query->whereHas('item', function($q) use ($request) {
                    $q->where('category_id', $request->category_id);
                });
            }
            if ($request->filled('location_id')) {
                $query->whereHas('item', function($q) use ($request) {
                    $q->where('location_id', $request->location_id);
                });
            }
            if ($request->filled('operator_id')) {
                $query->where('created_by', $request->operator_id);
            }

            return $query->latest()->get();
        }
    }
}
