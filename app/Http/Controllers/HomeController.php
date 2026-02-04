<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Pengguna;
use App\Models\Item;
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
        return view('layouts.admin.index', [
            'menu' => 'home',
            'menu_title' => 'home',
            'admins' => User::where('role','admin')->paginate(20),
            'total_barang'   => Item::count(),
            'total_admin'    => User::where('role', 'admin')->count(),
            'total_stock'    => Item::sum('unit'),
            'total_petugas'  => Petugas::count(),
            'total_pengguna' => Pengguna::count(),
            'petugas'  => Petugas::with('user')->get(),
            'pengguna' => Pengguna::with('user')->get()
        ]);
    }   

    
}