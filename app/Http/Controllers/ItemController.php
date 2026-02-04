<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('petugas.item.index', [
            'items' => Item::with('category','stock')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.item.create', [
            'categories' => ItemCategory::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:items,code',
            'name' => 'required',
            'unit' => 'required',
            'description' => 'nullable',
            'item_category_id' => 'required|exists:item_categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('items', 'public');
        }

        $item = Item::create([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'unit' => $validated['unit'],
            'description' => $validated['description'] ?? null,
            'item_category_id' => $validated['item_category_id'],
            'photo' => $photoPath
        ]);

        ItemStock::create([
            'item_id' => $item->id,
            'stock' => 0
        ]);

        return redirect()->route('item.index')->with('success', 'Item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item, $id)
    {
        return view('petugas.item.show', [
            'item' => Item::with('category','stock')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item, $id)
    {
         return view('petugas.item.edit', [
            'item' => Item::findOrFail($id),
            'categories' => ItemCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item, $id)
    {
        $itemData = Item::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|unique:items,code,'.$id,
            'name' => 'required',
            'unit' => 'required',
            'description' => 'nullable',
            'item_category_id' => 'required|exists:item_categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($itemData->photo && Storage::disk('public')->exists($itemData->photo)) {
                Storage::disk('public')->delete($itemData->photo);
            }
            $validated['photo'] = $request->file('photo')->store('items', 'public');
        } else {
            $validated['photo'] = $itemData->photo;
        }

        Item::where('id', $id)->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'unit' => $validated['unit'],
            'description' => $validated['description'] ?? null,
            'item_category_id' => $validated['item_category_id'],
            'photo' => $validated['photo']
        ]);

        return redirect()->route('item.index')->with('success', 'Item berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item, $id)
    {
        $itemData = Item::findOrFail($id);
        
        // Delete photo if exists
        if ($itemData->photo && Storage::disk('public')->exists($itemData->photo)) {
            Storage::disk('public')->delete($itemData->photo);
        }

        Item::destroy($id);
        return redirect()->back()->with('success', 'Item berhasil dihapus');
    }
}