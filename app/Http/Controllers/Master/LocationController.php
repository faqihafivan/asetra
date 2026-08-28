<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreLocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Location::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $locations = $query->latest()->paginate(10)->withQueryString();

        return view('master.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('master.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi/Ruangan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location): View
    {
        return view('master.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi/Ruangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location): RedirectResponse
    {
        if ($location->items()->exists()) {
            return redirect()->route('locations.index')
                ->with('error', 'Lokasi/Ruangan tidak dapat dihapus karena masih menampung beberapa item.');
        }

        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Lokasi/Ruangan berhasil dihapus.');
    }
}
