<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Item::with(['category', 'location']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('specification', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Location Filter
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Low Stock Filter (stok <= min_stock)
        if ($request->boolean('low_stock')) {
            $query->whereColumn('stock', '<=', 'min_stock');
        }

        $items = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $locations = Location::all();

        return view('items.index', compact('items', 'categories', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('items.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Automatic Code Generation
        $validated['code'] = Item::generateCode();

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('items', 'public');
            $validated['photo_path'] = 'storage/' . $path;
        }

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan dengan kode: ' . $validated['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item): View
    {
        // Load relationships and transaction history
        $item->load([
            'category', 
            'location', 
            'procurementItems.procurement.supplier',
            'procurementItems.procurement.fundingSource',
            'itemExits.creator'
        ]);

        // Get purchase history (procurements)
        $purchaseHistory = $item->procurementItems()
            ->latest()
            ->paginate(5, ['*'], 'purchase_page');

        // Get exit history
        $exitHistory = $item->itemExits()
            ->latest()
            ->paginate(5, ['*'], 'exit_page');

        // Calculate chronological stock levels for Chart.js
        $purchases = $item->procurementItems()->with('procurement')->get()->map(function($pi) {
            return [
                'date' => $pi->procurement->date,
                'qty' => $pi->quantity,
                'type' => 'in'
            ];
        });

        $exits = $item->itemExits()->get()->map(function($ie) {
            return [
                'date' => $ie->date,
                'qty' => $ie->quantity,
                'type' => 'out'
            ];
        });

        $history = $purchases->concat($exits)->sortBy('date');

        $currentStock = 0;
        $chartLabels = [];
        $chartValues = [];

        // Add starting point
        if ($history->isNotEmpty()) {
            $firstTrxDate = $history->first()['date'];
            $chartLabels[] = date('d M Y', strtotime($firstTrxDate . ' -1 day'));
            $chartValues[] = 0;
        } else {
            $chartLabels[] = date('d M Y');
            $chartValues[] = 0;
        }

        foreach ($history as $trx) {
            if ($trx['type'] === 'in') {
                $currentStock += $trx['qty'];
            } else {
                $currentStock -= $trx['qty'];
            }
            $chartLabels[] = date('d M Y', strtotime($trx['date']));
            $chartValues[] = $currentStock;
        }

        return view('items.show', compact('item', 'purchaseHistory', 'exitHistory', 'chartLabels', 'chartValues'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item): View
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('items.edit', compact('item', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreItemRequest $request, Item $item): RedirectResponse
    {
        $validated = $request->validated();

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($item->photo_path) {
                $oldPath = str_replace('storage/', '', $item->photo_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('photo')->store('items', 'public');
            $validated['photo_path'] = 'storage/' . $path;
        }

        $item->update($validated);

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item): RedirectResponse
    {
        // We can soft delete the item. Note: we don't delete the physical photo file during soft delete
        // to preserve integrity in case of restoration.
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Barang berhasil dihapus (Soft Delete).');
    }

    /**
     * Print inventory label / sticker (KIR) for the item.
     */
    public function printLabel(Request $request, Item $item): View
    {
        $item->load(['category', 'location']);
        $quantity = max(1, intval($request->query('qty', 1)));
        
        return view('items.print-label', compact('item', 'quantity'));
    }
}
