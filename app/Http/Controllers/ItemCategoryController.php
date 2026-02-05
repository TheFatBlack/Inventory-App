<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('petugas.item_category.index', [
            'menu' => 'item-category',
            'categories' => ItemCategory::paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.item_category.create', [
            'menu' => 'item-category',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:item_categories,name',
            'code' => 'nullable|string|max:50|unique:item_categories,code',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('item-categories', 'public');
        }

        ItemCategory::create([
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'created_by' => Auth::user()->name ?? null,
        ]);

        return redirect()->route('petugas.item-category.index')->with('success', 'Kategori item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemCategory $itemCategory)
    {
        return view('petugas.item_category.show', [
            'menu' => 'item-category',
            'category' => $itemCategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemCategory $itemCategory)
    {
         return view('petugas.item_category.edit', [
            'menu' => 'item-category',
            'category' => $itemCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategory $itemCategory)
    {
        $validated = $request->validate([
            'name' => 'required|unique:item_categories,name,'.$itemCategory->id,
            'code' => 'nullable|string|max:50|unique:item_categories,code,'.$itemCategory->id,
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'description' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($itemCategory->image && Storage::disk('public')->exists($itemCategory->image)) {
                Storage::disk('public')->delete($itemCategory->image);
            }
            $data['image'] = $request->file('image')->store('item-categories', 'public');
        }

        $itemCategory->update($data);

        return redirect()->route('petugas.item-category.index')->with('success', 'Kategori item berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $itemCategory)
    {
        if ($itemCategory->image && Storage::disk('public')->exists($itemCategory->image)) {
            Storage::disk('public')->delete($itemCategory->image);
        }

        $itemCategory->delete();
        return redirect()->back()->with('success', 'Kategori item berhasil dihapus');
    }
}
