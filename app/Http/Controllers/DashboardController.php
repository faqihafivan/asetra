<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemExit;
use App\Models\Procurement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function index(): View
    {
        // 1. Core Summary Cards
        $totalItems = Item::count();
        $totalProcurements = Procurement::count();
        $totalItemExits = ItemExit::count();
        $totalSuppliers = Supplier::count();

        // 2. Calculate Total Inventory Value (Stock * Latest Unit Price)
        $totalInventoryValue = 0;
        $items = Item::all();
        foreach ($items as $item) {
            $latestPurchase = $item->procurementItems()->latest()->first();
            $price = $latestPurchase ? $latestPurchase->unit_price : 0;
            $totalInventoryValue += $item->stock * $price;
        }

        // 3. Low Stock Items (stok <= min_stock)
        $lowStockItems = Item::with(['category', 'location'])
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->take(5)
            ->get();

        // 4. Monthly Procurement Graph (Total Price per Month in current year)
        $monthlyProcurement = DB::table('procurements')
            ->selectRaw('MONTH(date) as month, SUM(total_price) as total')
            ->whereYear('date', date('Y'))
            ->groupByRaw('MONTH(date)')
            ->pluck('total', 'month')
            ->all();

        $procurementValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $procurementValues[] = $monthlyProcurement[$m] ?? 0;
        }

        // 5. Monthly Exit Graph (Total Quantity exited per Month in current year)
        $monthlyExits = DB::table('item_exits')
            ->selectRaw('MONTH(date) as month, SUM(quantity) as total')
            ->whereYear('date', date('Y'))
            ->groupByRaw('MONTH(date)')
            ->pluck('total', 'month')
            ->all();

        $exitValues = [];
        for ($m = 1; $m <= 12; $m++) {
            $exitValues[] = $monthlyExits[$m] ?? 0;
        }

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // 6. Recent Activities Feed (Merged Procurements & Exits)
        $recentProcurements = Procurement::with(['supplier', 'creator'])->latest()->take(5)->get()->map(function($p) {
            return [
                'type' => 'procurement',
                'title' => 'Pengadaan: ' . $p->number,
                'description' => "Pembelian dari {$p->supplier->name} senilai Rp " . number_format($p->total_price, 0, ',', '.'),
                'time' => $p->created_at,
                'user' => $p->creator->name ?? 'Operator',
            ];
        });

        $recentExits = ItemExit::with(['item', 'creator'])->latest()->take(5)->get()->map(function($e) {
            return [
                'type' => 'exit',
                'title' => 'Barang Keluar: ' . $e->item->name,
                'description' => "Pengeluaran {$e->quantity} {$e->item->unit} ke {$e->destination} (PJ: {$e->pic})",
                'time' => $e->created_at,
                'user' => $e->creator->name ?? 'Operator',
            ];
        });

        $activities = $recentProcurements->concat($recentExits)->sortByDesc('time')->take(6);

        return view('dashboard', compact(
            'totalItems', 'totalProcurements', 'totalItemExits', 'totalSuppliers', 'totalInventoryValue',
            'lowStockItems', 'procurementValues', 'exitValues', 'months', 'activities'
        ));
    }
}
