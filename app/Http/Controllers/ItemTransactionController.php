<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use App\Models\ItemTransaction;
use Illuminate\Support\Facades\Auth;

class ItemTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Item-Transaction.index', [
            'transactions' => ItemTransaction::with('item', 'petugas')
                ->latest()
                ->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Item-Transaction.create', [
            'items' => Item::with('stock')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        $stock = ItemStock::where('item_id', $validated['item_id'])->firstOrFail();

        // Validasi stok jika keluar
        if ($validated['type'] === 'keluar' && $stock->stock < $validated['quantity']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak cukup. Stok tersedia: ' . $stock->stock);
        }

        // Hitung perubahan stok
        if ($validated['type'] === 'masuk') {
            $stock->increment('stock', $validated['quantity']);
        } else {
            $stock->decrement('stock', $validated['quantity']);
        }

        // Buat transaksi
        ItemTransaction::create([
            'item_id' => $validated['item_id'],
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'petugas_id' => Auth::id(),
            'transaction_date' => $validated['transaction_date'],
            'note' => $validated['note']
        ]);

        return redirect()->route('item-transaction.index')
            ->with('success', 'Transaksi barang berhasil dicatat');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemTransaction $itemTransaction, $id)
    {
        return view('Item-Transaction.show', [
            'transaction' => ItemTransaction::with('item', 'petugas')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemTransaction $itemTransaction, $id)
    {
        return view('Item-Transaction.edit', [
            'transaction' => ItemTransaction::with('item')->findOrFail($id),
            'items' => Item::with('stock')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemTransaction $itemTransaction, $id)
    {
        $transaction = ItemTransaction::findOrFail($id);
        $stock = ItemStock::where('item_id', $transaction->item_id)->firstOrFail();

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        // Rollback stok lama
        if ($transaction->type === 'masuk') {
            $stock->decrement('stock', $transaction->quantity);
        } else {
            $stock->increment('stock', $transaction->quantity);
        }

        // Validasi stok untuk tipe keluar
        if ($transaction->type === 'keluar' && $stock->stock < $validated['quantity']) {
            // Kembalikan stok ke kondisi sebelumnya
            if ($transaction->type === 'masuk') {
                $stock->increment('stock', $transaction->quantity);
            } else {
                $stock->decrement('stock', $transaction->quantity);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak cukup. Stok tersedia: ' . $stock->stock);
        }

        // Terapkan stok baru
        if ($transaction->type === 'masuk') {
            $stock->increment('stock', $validated['quantity']);
        } else {
            $stock->decrement('stock', $validated['quantity']);
        }

        // Update transaksi
        $transaction->update($validated);

        return redirect()->route('item-transaction.index')
            ->with('success', 'Transaksi barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemTransaction $itemTransaction, $id)
    {
        $transaction = ItemTransaction::findOrFail($id);
        $stock = ItemStock::where('item_id', $transaction->item_id)->firstOrFail();

        // Rollback stok
        if ($transaction->type === 'masuk') {
            $stock->decrement('stock', $transaction->quantity);
        } else {
            $stock->increment('stock', $transaction->quantity);
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi barang berhasil dihapus');
    }
}