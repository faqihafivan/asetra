<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreFundingSourceRequest;
use App\Models\FundingSource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FundingSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = FundingSource::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $fundingSources = $query->latest()->paginate(10)->withQueryString();

        return view('master.funding_sources.index', compact('fundingSources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('master.funding_sources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundingSourceRequest $request): RedirectResponse
    {
        FundingSource::create($request->validated());

        return redirect()->route('funding_sources.index')
            ->with('success', 'Sumber dana berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundingSource $fundingSource): View
    {
        return view('master.funding_sources.edit', compact('fundingSource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFundingSourceRequest $request, FundingSource $fundingSource): RedirectResponse
    {
        $fundingSource->update($request->validated());

        return redirect()->route('funding_sources.index')
            ->with('success', 'Sumber dana berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundingSource $fundingSource): RedirectResponse
    {
        if ($fundingSource->procurements()->exists()) {
            return redirect()->route('funding_sources.index')
                ->with('error', 'Sumber dana tidak dapat dihapus karena memiliki riwayat pengadaan.');
        }

        $fundingSource->delete();

        return redirect()->route('funding_sources.index')
            ->with('success', 'Sumber dana berhasil dihapus.');
    }
}
