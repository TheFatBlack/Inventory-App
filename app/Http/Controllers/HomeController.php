<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Pengguna;
use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Dashboard
    public function index()
    {
        $user = Auth::user();
        $role = strtolower((string) ($user->role ?? ''));

        if ($role === 'petugas') {
            return redirect()->route('petugas.home');
        }

        if ($role === 'pengguna') {
            return redirect()->route('pengguna.dashboard');
        }

        $totalAdmin = User::where('role', 'admin')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPengguna = User::where('role', 'pengguna')->count();

        return view('layouts.admin.index', [
            'menu' => 'home',
            'menu_title' => 'home',
            'admins' => User::where('role','admin')->paginate(20),
            'total_barang'   => Item::count(),
            'total_admin'    => $totalAdmin,
            'total_stock'    => ItemStock::sum('stock'),
            'total_petugas'  => $totalPetugas,
            'total_pengguna' => $totalPengguna,
            'petugas'  => Petugas::with('user')->get(),
            'pengguna' => Pengguna::with('user')->get()
        ]);
    }      
}
