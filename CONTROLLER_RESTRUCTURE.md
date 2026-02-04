# Restructure Controllers - User Management Consolidation

## Summary
Semua operasi user management (admin, petugas, pengguna) telah dipindahkan ke **AdminController**. 
- **PetugasController** sekarang fokus pada **Item Management** (barang warehouse)
- **PenggunaController** sekarang fokus pada **Transaction Management** (ambil barang dari gudang)

---

## Controller Changes

### 1. AdminController (diperluas)
**File**: `app/Http/Controllers/AdminController.php`

Sekarang handle 3 kategori user management:

#### Admin Management
- `index()` - Dashboard admin, lihat semua admin
- `create()` - Form buat admin baru
- `store()` - Simpan admin baru
- `show($id)` - Lihat detail admin
- `edit($id)` - Form edit admin
- `update($id)` - Update data admin
- `destroy($id)` - Hapus admin
- `exportPDF()` - Export admin ke PDF

#### Petugas Management (Staff Gudang)
- `petugasIndex()` - Daftar semua petugas
- `petugasCreate()` - Form buat petugas
- `petugasStore()` - Simpan petugas baru
- `petugasShow($id)` - Lihat detail petugas
- `petugasEdit($id)` - Form edit petugas
- `petugasUpdate($id)` - Update petugas
- `petugasDestroy($id)` - Hapus petugas
- `petugasExportPDF()` - Export petugas ke PDF

#### Pengguna Management (Users)
- `penggunaIndex()` - Daftar semua pengguna
- `penggunaCreate()` - Form buat pengguna
- `penggunaStore()` - Simpan pengguna baru
- `penggunaShow($id)` - Lihat detail pengguna
- `penggunaEdit($id)` - Form edit pengguna
- `penggunaUpdate($id)` - Update pengguna
- `penggunaDestroy($id)` - Hapus pengguna
- `penggunaExportPDF()` - Export pengguna ke PDF

### 2. PetugasController (disederhanakan)
**File**: `app/Http/Controllers/PetugasController.php`

Sekarang handle Item Barang Management saja:

- `index()` - Daftar semua barang dengan stock
- `create()` - Form buat barang baru
- `store()` - Simpan barang baru (dengan auto-create stock record)
- `show($id)` - Lihat detail barang
- `edit($id)` - Form edit barang
- `update($id)` - Update data barang
- `destroy($id)` - Hapus barang + stock-nya

**Flow**:
- Petugas login → akses `/petugas/item/*` untuk kelola barang
- Kelola kategori di `/petugas/item-category/*`
- Kelola transaksi gudang di `/petugas/transaction/*` (masuk/keluar)

### 3. PenggunaController (disederhanakan)
**File**: `app/Http/Controllers/PenggunaController.php`

Sekarang handle Pengguna Transactions saja (ambil barang):

- `index()` - Daftar transaksi milik pengguna yg login (hanya keluar)
- `create()` - Form ambil barang dari gudang
- `store()` - Simpan pengambilan barang (auto-decrease stock, pengguna_id diset)
- `show($id)` - Lihat detail transaksi
- `edit($id)` - Edit transaksi (ubah jumlah/tanggal)
- `update($id)` - Update transaksi
- `destroy($id)` - Batalkan pengambilan barang (restore stock)

**Flow**:
- Pengguna login → akses `/pengguna/dashboard`
- Ambil barang di `/pengguna/transaction/*`
- Hanya bisa lihat transaksi miliknya sendiri (filtered by Auth::id() = pengguna_id)

---

## Routes Updated

### Admin Routes (`/admin` prefix, no middleware)
```
GET    /admin                      → admin.index
GET    /admin/create               → admin.create
POST   /admin/store                → admin.store
GET    /admin/{id}                 → admin.show
GET    /admin/{id}/edit            → admin.edit
PUT    /admin/{id}/update          → admin.update
DELETE /admin/{id}                 → admin.destroy

GET    /admin/petugas              → petugas.index     [AdminController@petugasIndex]
GET    /admin/petugas/create       → petugas.create    [AdminController@petugasCreate]
POST   /admin/petugas/store        → petugas.store     [AdminController@petugasStore]
GET    /admin/petugas/{id}         → petugas.show      [AdminController@petugasShow]
GET    /admin/petugas/{id}/edit    → petugas.edit      [AdminController@petugasEdit]
PUT    /admin/petugas/{id}/update  → petugas.update    [AdminController@petugasUpdate]
DELETE /admin/petugas/{id}         → petugas.destroy   [AdminController@petugasDestroy]

GET    /admin/pengguna             → pengguna.index    [AdminController@penggunaIndex]
GET    /admin/pengguna/create      → pengguna.create   [AdminController@penggunaCreate]
POST   /admin/pengguna/store       → pengguna.store    [AdminController@penggunaStore]
GET    /admin/pengguna/{id}        → pengguna.show     [AdminController@penggunaShow]
GET    /admin/pengguna/{id}/edit   → pengguna.edit     [AdminController@penggunaEdit]
PUT    /admin/pengguna/{id}/update → pengguna.update   [AdminController@penggunaUpdate]
DELETE /admin/pengguna/{id}        → pengguna.destroy  [AdminController@penggunaDestroy]
```

### Petugas Routes (`/petugas` prefix, middleware: auth + petugas)
```
GET    /petugas/dashboard          → petugas.dashboard

GET    /petugas/item               → petugas.item.index
GET    /petugas/item/create        → petugas.item.create
POST   /petugas/item/store         → petugas.item.store
GET    /petugas/item/{id}          → petugas.item.show
GET    /petugas/item/{id}/edit     → petugas.item.edit
PUT    /petugas/item/{id}          → petugas.item.update
DELETE /petugas/item/{id}          → petugas.item.destroy

GET    /petugas/item-category      → petugas.item-category.index
...

GET    /petugas/transaction        → petugas.transaction.index
...
```

### Pengguna Routes (`/pengguna` prefix, middleware: auth + pengguna)
```
GET    /pengguna/dashboard         → pengguna.dashboard

GET    /pengguna/transaction       → pengguna.transaction.index
GET    /pengguna/transaction/create → pengguna.transaction.create
POST   /pengguna/transaction/store  → pengguna.transaction.store
GET    /pengguna/transaction/{id}   → pengguna.transaction.show
GET    /pengguna/transaction/{id}/edit → pengguna.transaction.edit
PUT    /pengguna/transaction/{id}   → pengguna.transaction.update
DELETE /pengguna/transaction/{id}   → pengguna.transaction.destroy
```

---

## Database Migration

**File**: `database/migrations/2026_02_05_000004_modify_item_transactions_nullable_columns.php`

Membuat `petugas_id` dan `pengguna_id` menjadi nullable pada tabel `item_transactions`.

**Alasan**:
- Ketika petugas membuat transaksi → set `petugas_id`, `pengguna_id` = NULL
- Ketika pengguna membuat transaksi → set `pengguna_id`, `petugas_id` = NULL

---

## Key Features

### Petugas (Warehouse Staff)
✅ Kelola item barang (CRUD)
✅ Kelola kategori barang
✅ Catat transaksi gudang (masuk/keluar) → auto-adjust stock
✅ Dashboard menampilkan total barang, stock, kategori

### Pengguna (Users)
✅ Lihat barang yg tersedia
✅ Ambil barang dari gudang (create transaksi keluar)
✅ Lihat riwayat pengambilan barang (hanya miliknya)
✅ Dashboard dengan statistik dasar

### Admin
✅ Kelola semua akun (admin, petugas, pengguna)
✅ Lihat statistik keseluruhan
✅ Export data ke PDF

---

## Notes
- Semua user yang dibuat disimpan di `users` table dengan role enum
- Petugas dan Pengguna juga ada di tabel terpisah (`petugas`, `penggunas`) untuk historical data
- Photo uploads terorganisir: `/admin`, `/petugas`, `/pengguna`, `/items`
- Transaksi bisa dibuat oleh petugas (record masuk/keluar) atau pengguna (ambil barang)
