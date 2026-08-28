<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProcurementRequest;
use App\Models\FundingSource;
use App\Models\Item;
use App\Models\Procurement;
use App\Models\Supplier;
use App\Services\ProcurementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Procurement::with(['supplier', 'fundingSource', 'creator']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $procurements = $query->latest()->paginate(10)->withQueryString();

        return view('procurements.index', compact('procurements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $suppliers = Supplier::all();
        $fundingSources = FundingSource::all();
        // Get all items to choose from
        $items = Item::orderBy('name')->get();

        return view('procurements.create', compact('suppliers', 'fundingSources', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProcurementRequest $request, ProcurementService $service): RedirectResponse
    {
        try {
            $procurement = $service->createProcurement($request->validated(), Auth::id());
            
            return redirect()->route('procurements.index')
                ->with('success', 'Transaksi pengadaan berhasil dicatat dengan nomor: ' . $procurement->number);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mencatat pengadaan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Procurement $procurement): View
    {
        $procurement->load(['supplier', 'fundingSource', 'creator', 'items.item']);

        return view('procurements.show', compact('procurement'));
    }
}
