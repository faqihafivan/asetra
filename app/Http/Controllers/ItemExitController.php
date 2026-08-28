<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemExitRequest;
use App\Models\Item;
use App\Models\ItemExit;
use App\Services\ItemExitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ItemExitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = ItemExit::with(['item', 'creator']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('destination', 'like', "%{$search}%")
                  ->orWhere('pic', 'like', "%{$search}%")
                  ->orWhereHas('item', function($iq) use ($search) {
                      $iq->where('name', 'like', "%{$search}%")
                         ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        $itemExits = $query->latest()->paginate(10)->withQueryString();

        return view('item_exits.index', compact('itemExits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Get only items that actually have stock (> 0) to output
        $items = Item::where('stock', '>', 0)->orderBy('name')->get();

        return view('item_exits.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemExitRequest $request, ItemExitService $service): RedirectResponse
    {
        try {
            $service->createItemExit($request->validated(), Auth::id());

            return redirect()->route('item_exits.index')
                ->with('success', 'Transaksi barang keluar berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
