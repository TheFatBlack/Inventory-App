<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use App\Models\Item;
use App\Models\ItemStock;
use App\Models\Pengguna;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PenggunaController extends Controller
{
    /**
     * Dashboard for pengguna
     */
    public function dashboard()
    {
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPengguna = User::where('role', 'pengguna')->count();

        return view('pengguna.index', [
            'menu' => 'home',
            'total_admin' => $totalAdmin,
            'total_petugas' => $totalPetugas,
            'total_pengguna' => $totalPengguna,
            'total_stock' => ItemStock::sum('stock'),
            'total_barang' => Item::count(),
        ]);
    }

    /**
     * Display a listing of user's transactions (taking items from warehouse)
     */
    public function index()
    {
        $pengguna = Pengguna::where('user_id', Auth::id())->first();
        if (!$pengguna) {
            return redirect()->back()
                ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
        }

        $penggunaIds = array_unique([$pengguna->id, Auth::id()]);
        $transactions = ItemTransaction::whereIn('pengguna_id', $penggunaIds)
            ->with(['item', 'petugas', 'pengguna'])
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        return view('pengguna.ItemTransaction.index', [
            'menu' => 'transaction',
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for creating a new transaction (take item from warehouse)
     */
    public function create()
    {
        $items = Item::with('stock')->get();

        return view('pengguna.ItemTransaction.create', [
            'menu' => 'transaction',
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created transaction in storage
     */
    public function store(Request $request)
    {
        $pengguna = Pengguna::where('user_id', Auth::id())->first();
        if (!$pengguna) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
        }

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
        $quantity = (int) $validated['quantity'];
        if ($quantity < 1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah wajib diisi minimal 1.');
        }

        $transaction = ItemTransaction::create([
            'item_id' => $validated['item_id'],
            'pengguna_id' => $pengguna->id,
            'type' => 'keluar',
            'quantity' => $quantity,
            'transaction_date' => $validated['transaction_date'],
            'note' => $validated['note'],
        ]);

        // Decrease stock
        $stock->update([
            'stock' => $stock->stock - $quantity
        ]);

        return redirect()->route('pengguna.transaction.index')->with('success', 'Pengambilan barang berhasil dicatat.');
    }

    /**
     * Display the specified transaction
     */
    public function show($id)
    {
        $pengguna = Pengguna::where('user_id', Auth::id())->first();
        if (!$pengguna) {
            return redirect()->back()
                ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
        }

        $penggunaIds = array_unique([$pengguna->id, Auth::id()]);
        $transaction = ItemTransaction::with(['item', 'petugas', 'pengguna'])
            ->where('id', $id)
            ->whereIn('pengguna_id', $penggunaIds)
            ->firstOrFail();

        return view('pengguna.ItemTransaction.show', [
            'menu' => 'transaction',
            'transaction' => $transaction,
        ]);
    }

    /**
     * Show the form for editing the specified transaction
     */
    public function edit($id)
    {
        $pengguna = Pengguna::where('user_id', Auth::id())->first();
        if (!$pengguna) {
            return redirect()->back()
                ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
        }

        $penggunaIds = array_unique([$pengguna->id, Auth::id()]);
        $transaction = ItemTransaction::with('item')
            ->where('id', $id)
            ->whereIn('pengguna_id', $penggunaIds)
            ->firstOrFail();

        $items = Item::with('stock')->get();

        return view('pengguna.ItemTransaction.edit', [
            'menu' => 'transaction',
            'transaction' => $transaction,
            'items' => $items,
        ]);
    }

    /**
     * Update the specified transaction in storage
     */
    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::where('user_id', Auth::id())->first();
        if (!$pengguna) {
            return redirect()->back()
                ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
        }

        $penggunaIds = array_unique([$pengguna->id, Auth::id()]);
        $transaction = ItemTransaction::where('id', $id)
            ->whereIn('pengguna_id', $penggunaIds)
            ->firstOrFail();

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'note' => 'nullable|string'
        ]);

        $item = $transaction->item;
        $oldQuantity = $transaction->quantity;
        $newQuantity = (int) $validated['quantity'];
        if ($newQuantity < 1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jumlah wajib diisi minimal 1.');
        }
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
        $pengguna = Pengguna::where('user_id', Auth::id())->first();
        if (!$pengguna) {
            return redirect()->back()
                ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
        }

        $penggunaIds = array_unique([$pengguna->id, Auth::id()]);
        $transaction = ItemTransaction::where('id', $id)
            ->whereIn('pengguna_id', $penggunaIds)
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

    public function transactionExportPDF()
    {
        $pengguna = Pengguna::where('user_id', Auth::id())->first();
        if (!$pengguna) {
            return redirect()->back()
                ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
        }

        $penggunaIds = array_unique([$pengguna->id, Auth::id()]);
        $transactions = ItemTransaction::with(['item', 'petugas', 'pengguna'])
            ->whereIn('pengguna_id', $penggunaIds)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.pengguna-transactions-pdf', [
            'transactions' => $transactions,
            'tanggal' => now()->format('d-m-Y H:i:s'),
        ]);

        return $pdf->download('pengguna-transactions.pdf');
    }
}
