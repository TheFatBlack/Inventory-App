<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use App\Models\ItemTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;
use App\Models\Pengguna;

class ItemTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = ItemTransaction::with('item', 'petugas')->latest();

        $user = Auth::user();
        if ($user && $user->role === 'petugas') {
            $petugas = Petugas::where('user_id', $user->id)->first();
            if ($petugas) {
                $query->where('petugas_id', $petugas->id);
            }
        }

        return view('petugas.ItemTransaction.index', [
            'menu' => 'transaction',
            'transactions' => $query->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.ItemTransaction.create', [
            'menu' => 'transaction',
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

        $user = Auth::user();
        $petugasId = null;
        $penggunaId = null;

        if ($user && $user->role === 'petugas') {
            $petugas = Petugas::where('user_id', $user->id)->first();
            if (!$petugas) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data petugas tidak ditemukan untuk user ini.');
            }
            $petugasId = $petugas->id;
        } elseif ($user && $user->role === 'pengguna') {
            $pengguna = Pengguna::where('user_id', $user->id)->first();
            if (!$pengguna) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Data pengguna tidak ditemukan untuk user ini.');
            }
            $penggunaId = $pengguna->id;
        }

        // Validasi stok jika keluar
        if ($validated['type'] === 'keluar' && $stock->stock < $validated['quantity']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak cukup. Stok tersedia: ' . $stock->stock);
        }

        // Hitung perubahan stok
        if ($user && $user->role === 'petugas') {
            $validated['type'] = 'masuk';
        }

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
            'petugas_id' => $petugasId,
            'pengguna_id' => $penggunaId,
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
        return view('petugas.ItemTransaction.show', [
            'menu' => 'transaction',
            'transaction' => ItemTransaction::with('item', 'petugas')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemTransaction $itemTransaction, $id)
    {
        return view('petugas.ItemTransaction.edit', [
            'menu' => 'transaction',
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
