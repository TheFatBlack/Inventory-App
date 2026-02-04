<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('petugas.item_category.index', [
            'categories' => ItemCategory::paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.item_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:item_categories,name',
            'description' => 'nullable'
        ]);

        ItemCategory::create($validated);

        return redirect()->route('item-category.index')->with('success', 'Kategori item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemCategory $itemCategory, $id)
    {
        return view('petugas.item_category.show', [
            'category' => ItemCategory::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemCategory $itemCategory, $id)
    {
         return view('petugas.item_category.edit', [
            'category' => ItemCategory::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategory $itemCategory, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:item_categories,name,'.$id,
            'description' => 'nullable'
        ]);

        ItemCategory::where('id', $id)->update($validated);

        return redirect()->route('item-category.index')->with('success', 'Kategori item berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $itemCategory, $id)
    {
        ItemCategory::destroy($id);
        return redirect()->back()->with('success', 'Kategori item berhasil dihapus');
    }
}