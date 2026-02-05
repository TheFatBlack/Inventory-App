<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemStock;
use App\Models\ItemCategory;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PetugasController extends Controller
{
    /**
     * Dashboard for petugas
     */
    public function index()
    {
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPengguna = User::where('role', 'pengguna')->count();

        return view('petugas.index', [
            'menu' => 'home',
            'total_admin' => $totalAdmin,
            'total_petugas' => $totalPetugas,
            'total_pengguna' => $totalPengguna,
            'total_stock' => ItemStock::sum('stock'),
            'total_barang' => Item::count(),
        ]);
    }
    /**
     * Display a listing of items
     */
    public function Itemindex()
    {
        $items = Item::with(['category', 'stock', 'petugas'])->paginate(10);

        return view('petugas.item.index', [
            'menu' => 'petugas',
            'items' => $items,
            'total_items' => Item::count(),
            'total_stock' => ItemStock::sum('stock'),
            'total_categories' => ItemCategory::count(),
        ]);
    }

    public function itemExportPDF()
    {
        $items = Item::with(['category', 'stock', 'petugas'])
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView('exports.items-pdf', [
            'items' => $items,
            'tanggal' => now()->format('d-m-Y H:i:s'),
        ]);

        return $pdf->download('items-list.pdf');
    }

    /**
     * Show the form for creating a new item
     */
    public function create()
    {
        $categories = ItemCategory::all();

        return view('petugas.item.create', [
            'menu' => 'petugas',
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created item in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:items,name',
            'code' => 'required|unique:items,code',
            'item_category_id' => 'required|exists:item_categories,id',
            'unit' => 'required',
            'description' => 'nullable',
            'stock' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('items', 'public');
        }

        $petugas = Petugas::where('user_id', Auth::id())->first();
        if (!$petugas) {
            return redirect()->back()
                ->withErrors(['petugas_id' => 'Data petugas tidak ditemukan untuk user ini.'])
                ->withInput();
        }

        $item = Item::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'item_category_id' => $validated['item_category_id'],
            'unit' => $validated['unit'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'petugas_id' => $petugas->id,
        ]);

        // Create default stock record
        $initialStock = (int) ($validated['stock'] ?? 0);
        ItemStock::create([
            'item_id' => $item->id,
            'stock' => $initialStock,
        ]);

        return redirect()->route('petugas.item.index')->with('success', 'Item berhasil ditambahkan.');
    }

    /**
     * Display the specified item
     */
    public function show($id)
    {
        $item = Item::with(['category', 'stock'])->findOrFail($id);

        return view('petugas.item.show', [
            'menu' => 'petugas',
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified item
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = ItemCategory::all();

        return view('petugas.item.edit', [
            'menu' => 'petugas',
            'item' => $item,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified item in storage
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:items,name,' . $id,
            'code' => 'required|unique:items,code,' . $id,
            'item_category_id' => 'required|exists:item_categories,id',
            'unit' => 'required',
            'description' => 'nullable',
            'stock' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'name' => $validated['name'],
            'code' => $validated['code'],
            'item_category_id' => $validated['item_category_id'],
            'unit' => $validated['unit'],
            'description' => $validated['description'],
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($item->photo && Storage::disk('public')->exists($item->photo)) {
                Storage::disk('public')->delete($item->photo);
            }
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item->update($data);

        if (array_key_exists('stock', $validated)) {
            ItemStock::updateOrCreate(
                ['item_id' => $item->id],
                ['stock' => (int) $validated['stock']]
            );
        }

        return redirect()->route('petugas.item.show', $item->id)->with('success', 'Item berhasil diupdate.');
    }

    /**
     * Remove the specified item from storage
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        // Delete photo if exists
        if ($item->photo && Storage::disk('public')->exists($item->photo)) {
            Storage::disk('public')->delete($item->photo);
        }

        // Delete related stock
        ItemStock::where('item_id', $item->id)->delete();

        // Delete item
        $item->delete();

        return redirect()->route('petugas.item.index')->with('success', 'Item berhasil dihapus.');
    }
}
