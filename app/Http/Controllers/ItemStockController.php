<?php

namespace App\Http\Controllers;

use App\Models\ItemStock;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('petugas.item_stock.index', [
            'stocks' => ItemStock::with('item')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.item_stock.create', [
            'items' => Item::doesntHave('stock')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id|unique:item_stocks,item_id',
            'stock' => 'required|integer|min:0'
        ]);

        ItemStock::create($validated);

        return redirect()->route('petugas.item_stock.index')
            ->with('success', 'Stock item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemStock $itemStock, $id)
    {
        return view('petugas.item_stock.show', [
            'stock' => ItemStock::with('item')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemStock $itemStock)
    {
        return view('petugas.item_stock.edit', [
            'stock' => $itemStock->load('item')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemStock $itemStock)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $itemStock->update($validated);

        return redirect()->route('petugas.item_stock.index')
            ->with('success', 'Stock item berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemStock $itemStock)
    {
        $itemStock->delete();

        return redirect()->route('petugas.item_stock.index')
            ->with('success', 'Stock item berhasil dihapus');
    }
}