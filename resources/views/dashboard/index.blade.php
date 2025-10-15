@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Tambahan Waktu, Hari, Tanggal, dan Jam -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="fs-2 text-primary me-3">
                                    <i class="ti ti-clock"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold" id="currentTime">14:30:45</div>
                                    <div class="text-muted" id="currentDate">Selasa, 15 Oktober 2024</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="fw-semibold text-success" id="greeting">Selamat Siang!</div>
                            <div class="badge bg-light text-dark mt-1" id="currentDay">Hari Kerja</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="fs-5 text-primary mb-10"><i class="ti ti-package"></i></div>
                        <h6 class="fw-bold mb-1">Produk</h6>
                        <h4 class="mb-0">{{ $totalProduk }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="fs-5 text-success mb-10"><i class="ti ti-shopping-cart"></i></div>
                        <h6 class="fw-bold mb-1">Penjualan</h6>
                        <h4 class="mb-0">{{ $totalPenjualan }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="fs-5 text-warning mb-10"><i class="ti ti-users"></i></div>
                        <h6 class="fw-bold mb-1">User</h6>
                        <h4 class="mb-0">{{ $totalUser }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="fs-5 text-danger mb-10"><i class="ti ti-cash"></i></div>
                        <h6 class="fw-bold mb-1">Pemasukan {{ date('Y') }}</h6>
                        <h4 class="mb-0">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Penjualan Bulanan --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Grafik Penjualan Bulanan</h6>
                        <form method="GET" action="{{ route('dashboard.index') }}">
                            <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </form>
                    </div>
                    <div class="card-body">
                        <canvas id="penjualanChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Sisa Produk & Tabel Minimum --}}
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">Grafik Sisa Produk (Stok)</h6>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div style="width:300px; height:300px;">
                            <canvas id="sisaProdukChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-success">
                    <div class="card-header bg-success-subtle">
                        <h6 class="mb-0 text-success fw-bold"> Minimum Produk </h6>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-success text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $minimumProduk = \App\Produk::where('Stok', '<', 10)->get();
                                @endphp

                                @forelse($minimumProduk as $p)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->NamaProduk }}</td>
                                    <td class="fw-bold text-danger">{{ $p->Stok }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-success fw-bold">Semua stok aman</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Fungsi untuk memperbarui waktu secara real-time
function updateTime() {
    const now = new Date();
    
    // Format tanggal: Selasa, 15 Oktober 2024
    const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', optionsDate);
    
    // Format waktu: 14:30:45
    const timeString = now.toLocaleTimeString('id-ID', { hour12: false });
    document.getElementById('currentTime').textContent = timeString;
    
    // Tentukan hari kerja atau akhir pekan
    const dayOfWeek = now.getDay();
    const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
    document.getElementById('currentDay').textContent = isWeekend ? 'Akhir Pekan' : 'Hari Kerja';
    
    // Tentukan salam berdasarkan waktu
    const hour = now.getHours();
    let greeting = '';
    if (hour < 11) greeting = 'Selamat Pagi!';
    else if (hour < 15) greeting = 'Selamat Siang!';
    else if (hour < 19) greeting = 'Selamat Sore!';
    else greeting = 'Selamat Malam!';
    document.getElementById('greeting').textContent = greeting;
}

// Panggil fungsi pertama kali dan atur interval pembaruan
updateTime();
setInterval(updateTime, 1000);

document.addEventListener("DOMContentLoaded", function () {
    // === Grafik Penjualan Bulanan ===
    const ctx = document.getElementById('penjualanChart').getContext('2d');
    const chartLabels = {!! json_encode($chartLabels ?? []) !!};
    const chartData = {!! json_encode($chartData ?? []) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels.map(b => 'Bulan ' + b),
            datasets: [{
                label: 'Total Penjualan',
                data: chartData,
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderColor: 'rgb(79, 70, 229)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });

    // === Grafik Pie Sisa Produk (TIDAK DIUBAH) ===
    const ctxPie = document.getElementById('sisaProdukChart').getContext('2d');
    const produkLabels = [];
    const produkStok = [];

    @foreach(\App\Produk::all() as $p)
        produkLabels.push("{{ $p->NamaProduk }}");
        produkStok.push({{ max(0, $p->Stok) }});
    @endforeach

    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: produkLabels,
            datasets: [{
                label: 'Sisa Produk',
                data: produkStok,
                backgroundColor: [
                    '#3b82f6', '#22c55e', '#ef4444', '#f97316', '#a855f7',
                    '#06b6d4', '#facc15', '#14b8a6', '#e11d48', '#8b5cf6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        padding: 10,
                        font: { size: 12 },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' unit';
                        }
                    }
                }
            },
            layout: {
                padding: { top: 10, bottom: 10 }
            }
        }
    });
});
</script>

<style>
#sisaProdukChart {
    margin-bottom: 10px;
}
.chartjs-render-monitor + div ul {
    display: flex !important;
    flex-wrap: wrap !important;
    justify-content: center !important;
    gap: 8px 16px !important;
    text-align: center !important;
    list-style: none !important;
    padding: 0 !important;
}
.chartjs-render-monitor + div li {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    font-size: 13px !important;
}
.table td, .table th {
    vertical-align: middle !important;
}
</style>
@endsection