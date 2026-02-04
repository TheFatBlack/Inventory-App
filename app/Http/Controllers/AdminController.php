<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ============================================
    // ADMIN MANAGEMENT
    // ============================================
    public function index()
    {
        $admins = User::where('role', 'admin')->get();

        return view('layouts.admin.admin.index', [
            'menu' => 'admin',
            'admins' => $admins,
            'total_barang' => \App\Models\Item::count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_petugas' => Petugas::count(),
            'total_pengguna' => Pengguna::count(),
        ]);
    }

    public function create()
    {
        return view('layouts.admin.admin.create', [
            'menu' => 'admin'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'no_hp' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('admin', 'public');
        }

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'no_hp' => $validated['no_hp'],
            'photo' => $photoPath,
            'role' => 'admin',
        ]);

        return redirect()->route('admin.index')->with('success', 'Data admin berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('layouts.admin.admin.view', [
            'menu'   => 'admin',
            'user'   => $user,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('layouts.admin.admin.edit', [
            'menu' => 'admin',
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username'=>'required|unique:users,username,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'nullable|min:6',
            'name'=>'required',
            'nip'=>'required|unique:users,nip,'.$id,
            'no_hp'=>'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'username'=>$validated['username'],
            'email'=>$validated['email'],
            'name'=>$validated['name'],
            'nip'=>$validated['nip'],
            'no_hp'=>$validated['no_hp'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('admin', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.index')->with('success','Data admin berhasil diupdate');
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error','Tidak bisa menghapus akun sendiri.');
        }

        $user = User::findOrFail($id);
        
        // Delete photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Delete related petugas record if exists
        if ($user->role === 'petugas') {
            Petugas::where('user_id', $user->id)->delete();
        }

        // Delete related pengguna record if exists
        if ($user->role === 'pengguna') {
            Pengguna::where('user_id', $user->id)->delete();
        }

        $user->delete();

        return redirect()->back()->with('success','User berhasil dihapus.');
    }

    public function exportPDF()
    {
        $admins = User::where('role', 'admin')->get();
        
        return view('exports.admin-pdf', [
            'admins' => $admins,
            'tanggal' => now()->format('d-m-Y H:i:s'),
        ]);
    }

    // ============================================
    // PETUGAS MANAGEMENT
    // ============================================
    public function petugasIndex()
    {
        $petugas = Petugas::with('user')->get();

        return view('layouts.admin.petugas.index', [
            'menu' => 'petugas',
            'petugas' => $petugas,
            'total_barang' => \App\Models\Item::count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_petugas' => Petugas::count(),
            'total_pengguna' => Pengguna::count(),
        ]);
    }

    public function petugasCreate()
    {
        return view('layouts.admin.petugas.create', [
            'menu' => 'petugas'
        ]);
    }

    public function petugasStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'no_hp' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('petugas', 'public');
        }

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'no_hp' => $validated['no_hp'],
            'photo' => $photoPath,
            'role' => 'petugas',
        ]);

        Petugas::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'password' => $user->password,
            'name' => $user->name,
            'nip' => $user->nip,
            'no_hp' => $user->no_hp,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil ditambahkan.');
    }

    public function petugasShow($id)
    {
        $user = User::with('petugas')->findOrFail($id);
        $detail = $user->petugas;

        return view('layouts.admin.petugas.view', [
            'menu'   => 'petugas',
            'user'   => $user,
            'detail' => $detail,
        ]);
    }

    public function petugasEdit($id)
    {
        $user = User::with('petugas')->findOrFail($id);
        $detail = $user->petugas;

        return view('layouts.admin.petugas.edit', array_merge(compact('user','detail'), ['menu' => 'petugas']));
    }

    public function petugasUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username'=>'required|unique:users,username,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'nullable|min:6',
            'name'=>'required',
            'nip'=>'required|unique:users,nip,'.$id,
            'no_hp'=>'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'username'=>$validated['username'],
            'email'=>$validated['email'],
            'name'=>$validated['name'],
            'nip'=>$validated['nip'],
            'no_hp'=>$validated['no_hp'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('petugas', 'public');
        }

        $user->update($data);

        // Update petugas table
        $petugas = Petugas::where('user_id', $user->id)->first();
        if ($petugas) {
            $petugas->update([
                'username' => $user->username,
                'email' => $user->email,
                'password' => $user->password,
                'name' => $user->name,
                'nip' => $user->nip,
                'no_hp' => $user->no_hp,
                'photo' => $data['photo'] ?? $petugas->photo,
            ]);
        }

        return redirect()->route('admin.petugas.index')->with('success','User berhasil diupdate');
    }

    public function petugasDestroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error','Tidak bisa menghapus akun sendiri.');
        }

        $user = User::findOrFail($id);
        
        // Delete photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Delete petugas record
        Petugas::where('user_id', $user->id)->delete();
        
        // Delete user
        $user->delete();

        return redirect()->route('admin.petugas.index')->with('success','User berhasil dihapus.');
    }

    public function petugasExportPDF()
    {
        $petugas = Petugas::with('user')->get();
        
        return view('exports.petugas-pdf', [
            'petugas' => $petugas,
            'tanggal' => now()->format('d-m-Y H:i:s'),
        ]);
    }

    // ============================================
    // PENGGUNA MANAGEMENT
    // ============================================
    public function penggunaIndex()
    {
        $pengguna = Pengguna::with('user')->get();

        return view('layouts.admin.pengguna.index', [
            'menu' => 'pengguna',
            'pengguna' => $pengguna,
            'total_barang' => \App\Models\Item::count(),
            'total_pengguna' => Pengguna::count(),
        ]);
    }

    public function penggunaCreate()
    {
        return view('layouts.admin.pengguna.create', [
            'menu' => 'pengguna'
        ]);
    }

    public function penggunaStore(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required',
            'nip' => 'required|unique:users,nip',
            'no_hp' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pengguna', 'public');
        }

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'no_hp' => $validated['no_hp'],
            'photo' => $photoPath,
            'role' => 'pengguna',
        ]);

        Pengguna::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'password' => $user->password,
            'name' => $user->name,
            'nip' => $user->nip,
            'no_hp' => $user->no_hp,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    public function penggunaShow($id)
    {
        $user = User::with('pengguna')->findOrFail($id);
        $detail = $user->pengguna;

        return view('layouts.admin.pengguna.view', [
            'menu'   => 'pengguna',
            'user'   => $user,
            'detail' => $detail,
        ]);
    }

    public function penggunaEdit($id)
    {
        $user = User::with('pengguna')->findOrFail($id);
        $detail = $user->pengguna;

        return view('layouts.admin.pengguna.edit', array_merge(compact('user','detail'), ['menu' => 'pengguna']));
    }

    public function penggunaUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username'=>'required|unique:users,username,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'nullable|min:6',
            'name'=>'required',
            'nip'=>'required|unique:users,nip,'.$id,
            'no_hp'=>'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'username'=>$validated['username'],
            'email'=>$validated['email'],
            'name'=>$validated['name'],
            'nip'=>$validated['nip'],
            'no_hp'=>$validated['no_hp'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('pengguna', 'public');
        }

        $user->update($data);

        // Update pengguna table
        $pengguna = Pengguna::where('user_id', $user->id)->first();
        if ($pengguna) {
            $pengguna->update([
                'username' => $user->username,
                'email' => $user->email,
                'password' => $user->password,
                'name' => $user->name,
                'nip' => $user->nip,
                'no_hp' => $user->no_hp,
                'photo' => $data['photo'] ?? $pengguna->photo,
            ]);
        }

        return redirect()->route('admin.pengguna.index')->with('success','User berhasil diupdate');
    }

    public function penggunaDestroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error','Tidak bisa menghapus akun sendiri.');
        }

        $user = User::findOrFail($id);
        
        // Delete photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Delete pengguna record
        Pengguna::where('user_id', $user->id)->delete();
        
        // Delete user
        $user->delete();

        return redirect()->route('admin.pengguna.index')->with('success','User berhasil dihapus.');
    }

    public function penggunaExportPDF()
    {
        $pengguna = Pengguna::with('user')->get();
        
        return view('exports.pengguna-pdf', [
            'pengguna' => $pengguna,
            'tanggal' => now()->format('d-m-Y H:i:s'),
        ]);
    }

    // ============================================
    // REKAP / REPORTS
    // ============================================
    public function rekapIndex()
    {
        $items = \App\Models\Item::with(['category','stock'])->get();

        // compute sold qty per item (type 'keluar')
        foreach ($items as $item) {
            $sold = \App\Models\ItemTransaction::where('item_id', $item->id)
                ->where('type', 'keluar')
                ->sum('quantity');
            $item->sold_qty = $sold;
            $item->instock = $item->stock->stock ?? 0;
        }

        return view('layouts.admin.rekap.index', [
            'menu' => 'rekap',
            'items' => $items,
            'total_barang' => \App\Models\Item::count(),
        ]);
    }

    public function rekapExportPDF()
    {
        $items = \App\Models\Item::with(['category','stock'])->get();

        // compute sold qty per item (type 'keluar')
        foreach ($items as $item) {
            $sold = \App\Models\ItemTransaction::where('item_id', $item->id)
                ->where('type', 'keluar')
                ->sum('quantity');
            $item->sold_qty = $sold;
            $item->instock = $item->stock->stock ?? 0;
        }
        
        return view('exports.rekap-pdf', [
            'items' => $items,
            'tanggal' => now()->format('d-m-Y H:i:s'),
        ]);
    }
}

