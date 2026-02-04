<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    /**
     * Display a listing of user's transactions (taking items from warehouse)
     */
    public function index()
    {
        $transactions = ItemTransaction::where('pengguna_id', Auth::id())
            ->with(['item', 'petugas'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        return view('pengguna.transaction.index', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new transaction (take item from warehouse)
     */
    public function create()
    {
        $items = Item::with('stock')->get();

        return view('pengguna.transaction.create', [
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created transaction in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        $item = Item::findOrFail($validated['item_id']);
        $stock = $item->stock;

        // Check available stock for taking items
        if ($stock->stock < $validated['quantity']) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Stok tidak cukup. Stok tersedia: {$stock->stock} {$item->unit}");
        }

        // Create transaction (keluar - decrease stock)
        $transaction = ItemTransaction::create([
            'item_id' => $validated['item_id'],
            'pengguna_id' => Auth::id(),
            'type' => 'keluar',
            'quantity' => $validated['quantity'],
            'transaction_date' => $validated['transaction_date'],
            'note' => $validated['note'],
        ]);

        // Decrease stock
        $stock->update([
            'stock' => $stock->stock - $validated['quantity']
        ]);

        return redirect()->route('pengguna.transaction.index')->with('success', 'Pengambilan barang berhasil dicatat.');
    }

    /**
     * Display the specified transaction
     */
    public function show($id)
    {
        $transaction = ItemTransaction::with(['item', 'petugas'])
            ->where('id', $id)
            ->where('pengguna_id', Auth::id())
            ->firstOrFail();

        return view('pengguna.transaction.show', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Show the form for editing the specified transaction
     */
    public function edit($id)
    {
        $transaction = ItemTransaction::with('item')
            ->where('id', $id)
            ->where('pengguna_id', Auth::id())
            ->firstOrFail();

        $items = Item::with('stock')->get();

        return view('pengguna.transaction.edit', [
            'transaction' => $transaction,
            'items' => $items,
        ]);
    }

    /**
     * Update the specified transaction in storage
     */
    public function update(Request $request, $id)
    {
        $transaction = ItemTransaction::where('id', $id)
            ->where('pengguna_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        $item = $transaction->item;
        $oldQuantity = $transaction->quantity;
        $newQuantity = $validated['quantity'];
        $quantityDiff = $newQuantity - $oldQuantity;

        $stock = $item->stock;

        // Check if new quantity is valid
        if ($quantityDiff > 0) {
            // Increase in quantity - check available stock
            if ($stock->stock < $quantityDiff) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Stok tidak cukup. Stok tersedia: {$stock->stock} {$item->unit}");
            }
        }

        // Update transaction
        $transaction->update([
            'quantity' => $newQuantity,
            'transaction_date' => $validated['transaction_date'],
            'note' => $validated['note'],
        ]);

        // Update stock
        $stock->update([
            'stock' => $stock->stock - $quantityDiff
        ]);

        return redirect()->route('pengguna.transaction.show', $transaction->id)->with('success', 'Transaksi berhasil diupdate.');
    }

    /**
     * Remove the specified transaction from storage
     */
    public function destroy($id)
    {
        $transaction = ItemTransaction::where('id', $id)
            ->where('pengguna_id', Auth::id())
            ->firstOrFail();

        $item = $transaction->item;
        $stock = $item->stock;

        // Restore stock when deleting transaction
        $stock->update([
            'stock' => $stock->stock + $transaction->quantity
        ]);

        $transaction->delete();

        return redirect()->route('pengguna.transaction.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
