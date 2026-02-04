# Routes & Middleware Struktur

## Middleware yang Dibuat
- **PetugasMiddleware**: Memastikan hanya user dengan role 'petugas' yang bisa akses
- **PenggunaMiddleware**: Memastikan hanya user dengan role 'pengguna' yang bisa akses

Middleware terdaftar di `bootstrap/app.php` dengan alias 'petugas' dan 'pengguna'.

---

## Route Grouping

### 1. ADMIN ROUTES (`/admin`)
- Hanya user dengan role 'admin'
- **Akses**: Kelola Admin, Petugas, Pengguna
- **Fitur**:
  - CRUD Admin (`/admin/*`)
  - CRUD Petugas (`/admin/petugas/*`)
  - CRUD Pengguna (`/admin/pengguna/*`)
  - Export PDF

**Routes**:
```
GET    /admin                      → admin.index (Dashboard)
GET    /admin/create               → admin.create
POST   /admin/store                → admin.store
GET    /admin/show/{id}            → admin.show
GET    /admin/edit/{id}            → admin.edit
PUT    /admin/update/{id}          → admin.update
DELETE /admin/{id}                 → admin.destroy
GET    /admin/export-pdf           → admin.exportPDF

GET    /admin/petugas              → admin.petugas.index
GET    /admin/petugas/create       → admin.petugas.create
POST   /admin/petugas/store        → admin.petugas.store
GET    /admin/petugas/show/{id}    → admin.petugas.show
GET    /admin/petugas/edit/{id}    → admin.petugas.edit
PUT    /admin/petugas/update/{id}  → admin.petugas.update
DELETE /admin/petugas/{id}         → admin.petugas.destroy
GET    /admin/petugas/export-pdf   → admin.petugas.exportPDF

GET    /admin/pengguna             → admin.pengguna.index
GET    /admin/pengguna/create      → admin.pengguna.create
POST   /admin/pengguna/store       → admin.pengguna.store
GET    /admin/pengguna/show/{id}   → admin.pengguna.show
GET    /admin/pengguna/edit/{id}   → admin.pengguna.edit
PUT    /admin/pengguna/update/{id} → admin.pengguna.update
DELETE /admin/pengguna/{id}        → admin.pengguna.destroy
GET    /admin/pengguna/export-pdf  → admin.pengguna.exportPDF
```

---

### 2. PETUGAS ROUTES (`/petugas`)
- **Middleware**: `auth`, `petugas`
- **Akses**: Kelola barang, kategori, dan transaksi warehouse
- **Fitur**:
  - Dashboard Petugas
  - CRUD Item Barang (`/petugas/item/*`)
  - CRUD Kategori Barang (`/petugas/item-category/*`)
  - CRUD Transaksi (Masuk/Keluar) (`/petugas/item-transaction/*`)

**Routes**:
```
GET    /petugas/dashboard                          → petugas.dashboard

GET    /petugas/item                               → petugas.item.index
GET    /petugas/item/create                        → petugas.item.create
POST   /petugas/item/store                         → petugas.item.store
GET    /petugas/item/{id}                          → petugas.item.show
GET    /petugas/item/{id}/edit                     → petugas.item.edit
PUT    /petugas/item/{id}                          → petugas.item.update
DELETE /petugas/item/{id}                          → petugas.item.destroy

GET    /petugas/item-category                      → petugas.item-category.index
GET    /petugas/item-category/create               → petugas.item-category.create
POST   /petugas/item-category/store                → petugas.item-category.store
GET    /petugas/item-category/{id}                 → petugas.item-category.show
GET    /petugas/item-category/{id}/edit            → petugas.item-category.edit
PUT    /petugas/item-category/{id}                 → petugas.item-category.update
DELETE /petugas/item-category/{id}                 → petugas.item-category.destroy

GET    /petugas/item-transaction                   → petugas.item-transaction.index
GET    /petugas/item-transaction/create            → petugas.item-transaction.create
POST   /petugas/item-transaction/store             → petugas.item-transaction.store
GET    /petugas/item-transaction/{id}              → petugas.item-transaction.show
GET    /petugas/item-transaction/{id}/edit         → petugas.item-transaction.edit
PUT    /petugas/item-transaction/{id}              → petugas.item-transaction.update
DELETE /petugas/item-transaction/{id}              → petugas.item-transaction.destroy
```

---

### 3. PENGGUNA ROUTES (`/pengguna`)
- **Middleware**: `auth`, `pengguna`
- **Akses**: Ambil barang dari gudang (hanya transaksi keluar)
- **Fitur**:
  - Dashboard Pengguna
  - Lihat & buat transaksi pengambilan barang

**Routes**:
```
GET    /pengguna/dashboard                         → pengguna.dashboard

GET    /pengguna/transaction                       → pengguna.transaction.index
GET    /pengguna/transaction/create                → pengguna.transaction.create
POST   /pengguna/transaction/store                 → pengguna.transaction.store
GET    /pengguna/transaction/{id}                  → pengguna.transaction.show
GET    /pengguna/transaction/{id}/edit             → pengguna.transaction.edit
PUT    /pengguna/transaction/{id}                  → pengguna.transaction.update
DELETE /pengguna/transaction/{id}                  → pengguna.transaction.destroy
```

---

## Middleware Registrasi

Di `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'petugas' => \App\Http\Middleware\PetugasMiddleware::class,
        'pengguna' => \App\Http\Middleware\PenggunaMiddleware::class,
    ]);
})
```

---

## Catatan Penting

1. **Pengguna (User)** akan mengakses `/pengguna/transaction` untuk ambil barang
2. **Petugas (Warehouse Staff)** akan mengakses `/petugas/item*` untuk kelola barang dan kategori
3. Kedua role bisa melihat transaksi, tapi dengan controller logic yang berbeda (pengguna hanya bisa lihat transaksi miliknya)
4. **Admin** hanya kelola user/staff, tidak kelola inventory
5. Semua akses dilindungi middleware role check
