@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
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

        {{-- Grafik Sisa Produk (kecil) --}}
        <div class="row mt-4">
            <div class="col-lg-6 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Grafik Sisa Produk (Stok)</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="width:300px; height:300px;">
                            <canvas id="sisaProdukChart"></canvas>
                        </div>
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

    // === Grafik Pie Sisa Produk (kecil) ===
    const ctxPie = document.getElementById('sisaProdukChart').getContext('2d');
    const produkLabels = [];
    const produkStok = [];

    @foreach(\App\Produk::all() as $p)
        produkLabels.push("{{ $p->NamaProduk }}");
        produkStok.push({{ max(0, $p->Stok) }});
    @endforeach

    new Chart(ctxPie, {
        type: 'doughnut', // pakai doughnut biar keren dan kecil
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
            cutout: '60%', // bikin tengah bolong biar lebih kecil
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' unit';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
