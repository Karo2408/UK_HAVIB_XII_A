    <?php
    
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\KategoriController;
    use App\Http\Controllers\ProdukController;
    use App\Http\Controllers\PelangganController;
    use App\Http\Controllers\PenjualanController;
    use App\Http\Controllers\PembayaranController;
    use App\Http\Controllers\LaporanController;
    
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {

        //admin
        Route::middleware(['role:admin'])->group(function () {

            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

            Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
            Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
            Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
            Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
            Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
            Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

            Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
            Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
            Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
            Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
            Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
            Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

            Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');



            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPDF');
        });

    //kasir
        Route::middleware(['role:kasir'])->group(function () {

            Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
            Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
            Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
            Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
            Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
            Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

            Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
            Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
            Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
            Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
            Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
            Route::put('/penjualan/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
            Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
            Route::get('/penjualan/{id}/cetak', [PenjualanController::class, 'cetak'])->name('penjualan.cetak');

            Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
            Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
            Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
            Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
            Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
            Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        });

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });
            Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
            Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
            Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');