@extends('layouts.app')
@section('title','Tambah Penjualan')

@section('content')

{{-- 🔔 Notifikasi sukses / error --}}
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<form action="{{ route('penjualan.store') }}" method="POST">
  @csrf
  <input type="hidden" name="TanggalPenjualan" id="TanggalPenjualan">
  <input type="hidden" name="TotalHarga" id="total-harga">
  <input type="hidden" name="TotalDiskon" id="total-diskon">

  <div class="row">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Tambah Produk</h5>
        </div>
        <div class="card-body">
          <table class="table table-sm align-middle">
            <thead class="table-light">
              <tr>
                <th>Produk</th>
                <th width="120">Harga</th>
                <th width="100">Jumlah</th>
                <th width="100">Diskon</th>
                <th width="120">Subtotal</th>
                <th width="50">Aksi</th>
              </tr>
            </thead>
            <tbody id="produk-wrapper"></tbody>
          </table>
          <button type="button" class="btn btn-secondary btn-sm" id="add-produk">+ Tambah Produk</button>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header"><h5 class="mb-0">Ringkasan Transaksi</h5></div>
        <div class="card-body">

          <div class="mb-3">
            <label>Tanggal & Waktu</label>
            <input type="text" class="form-control" id="TanggalPenjualanView" readonly>
          </div>

          <div class="mb-3">
            <label>Pelanggan</label>
            <select name="PelangganID" class="form-control" id="pelanggan">
              <option value="">Umum</option>
              @foreach($pelanggan as $p)
                <option value="{{ $p->PelangganID }}">{{ $p->NamaPelanggan }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-2">
            <label>Total Diskon</label>
            <input type="text" id="total-diskon-view" class="form-control" readonly>
          </div>

          <div class="mb-2">
            <label>Total Belanja</label>
            <input type="text" id="total-harga-view" class="form-control fw-bold" readonly>
          </div>

          <div class="mb-2">
            <label>Metode Pembayaran</label>
            <select name="Metode" id="metode" class="form-control" required>
              <option value="cash">Cash</option>
              <option value="debit">Debit</option>
              <option value="transfer">Transfer</option>
            </select>
          </div>

          <div class="mb-2">
            <label>Jumlah Bayar</label>
            <input type="number" name="JumlahBayar" id="jumlah-bayar" class="form-control">
          </div>

          <div class="mb-3">
            <label>Kembalian</label>
            <input type="number" id="kembalian" class="form-control" readonly>
          </div>

          <div class="d-grid gap-2">
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-success btn-lg">💾 Simpan Transaksi</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('produk-wrapper');
    const addBtn = document.getElementById('add-produk');
    const totalInput = document.getElementById('total-harga');
    const totalDiskonInput = document.getElementById('total-diskon');
    const totalHargaView = document.getElementById('total-harga-view');
    const totalDiskonView = document.getElementById('total-diskon-view');
    const bayarInput = document.getElementById('jumlah-bayar');
    const kembalianInput = document.getElementById('kembalian');
    const metodeSelect = document.getElementById('metode');
    const pelangganSelect = document.getElementById('pelanggan');
    const tglHidden = document.getElementById('TanggalPenjualan');
    const tglView = document.getElementById('TanggalPenjualanView');

    // Fungsi update tanggal & waktu otomatis
    function updateDateTime() {
        const now = new Date();
        const formatted = now.getFullYear() + "-" +
            String(now.getMonth() + 1).padStart(2,'0') + "-" +
            String(now.getDate()).padStart(2,'0') + " " +
            String(now.getHours()).padStart(2,'0') + ":" +
            String(now.getMinutes()).padStart(2,'0') + ":" +
            String(now.getSeconds()).padStart(2,'0');
        tglHidden.value = formatted;
        tglView.value = formatted;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Produk yang stoknya habis tidak ditampilkan
    const produkOptions = `@foreach($produk as $pr)
        @if($pr->Stok > 0)
          <option value="{{ $pr->ProdukID }}" data-harga="{{ $pr->Harga }}" data-stok="{{ $pr->Stok }}">{{ $pr->NamaProduk }} (Stok: {{ $pr->Stok }})</option>
        @endif
    @endforeach`;

    function addProdukItem() {
        const tr = document.createElement('tr');
        tr.classList.add('produk-item');
        tr.innerHTML = `
            <td>
              <select name="ProdukID[]" class="form-control produk-select" required>
                <option value="">-- Pilih --</option>${produkOptions}
              </select>
              <small class="text-muted stok-info"></small>
            </td>
            <td><input type="number" class="form-control harga" readonly></td>
            <td><input type="number" name="JumlahProduk[]" class="form-control jumlah-input" min="1" required></td>
            <td><input type="number" class="form-control diskon" readonly></td>
            <td><input type="number" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-sm btn-danger btn-remove">✖</button></td>
        `;

        const select = tr.querySelector('.produk-select');
        const hargaInput = tr.querySelector('.harga');
        const jumlahInput = tr.querySelector('.jumlah-input');
        const stokInfo = tr.querySelector('.stok-info');

        select.addEventListener('change', function() {
            const stok = parseInt(this.selectedOptions[0]?.dataset.stok || 0);
            hargaInput.value = parseFloat(this.selectedOptions[0]?.dataset.harga || 0);
            stokInfo.textContent = "Stok tersedia: " + stok;

            if(stok <= 0){
                jumlahInput.disabled = true;
                jumlahInput.value = 0;
            } else {
                jumlahInput.disabled = false;
            }

            hitungTotal();
        });

        jumlahInput.addEventListener('input', function() {
            const stok = parseInt(select.selectedOptions[0]?.dataset.stok || 0);
            if(parseInt(this.value) > stok){
                alert("Jumlah melebihi stok!");
                this.value = stok;
            }
            hitungTotal();
        });

        tr.querySelector('.btn-remove').addEventListener('click', function() { tr.remove(); hitungTotal(); });
        wrapper.appendChild(tr);
    }

    function hitungTotal() {
        let total = 0, totalDiskon = 0;
        const pelangganID = pelangganSelect.value;
        const isMember = pelangganID !== ""; // pelanggan diisi → member

        document.querySelectorAll('.produk-item').forEach(function(row) {
            const jumlah = parseFloat(row.querySelector('.jumlah-input').value || 0);
            const harga = parseFloat(row.querySelector('.produk-select').selectedOptions[0]?.dataset.harga || 0);
            const subtotal = harga * jumlah;

            // 🚫 Jika pelanggan "Umum" (tidak punya ID), tidak dapat diskon sama sekali
            let diskon = 0;
            if (isMember && jumlah >= 5) {
                diskon = subtotal * 0.05;
            }

            total += subtotal - diskon;
            totalDiskon += diskon;

            row.querySelector('.diskon').value = diskon.toFixed(0);
            row.querySelector('.subtotal').value = (subtotal - diskon).toFixed(0);
        });

        totalInput.value = total.toFixed(0);
        totalHargaView.value = total.toFixed(0);
        totalDiskonInput.value = totalDiskon.toFixed(0);
        totalDiskonView.value = totalDiskon.toFixed(0);

        const bayar = parseFloat(bayarInput.value || 0);

        if (metodeSelect.value === 'transfer') {
            bayarInput.value = total.toFixed(0);
            bayarInput.readOnly = true;
            kembalianInput.value = 0;
        } else {
            bayarInput.readOnly = false;
            const kembalian = bayar - total;

            // 💡 Hanya tampilkan angka kalau kembalian > 0
            if (kembalian > 0) {
                kembalianInput.value = kembalian.toFixed(0);
            } else {
                kembalianInput.value = 0;
            }
        }
    }

    addBtn.addEventListener('click', addProdukItem);
    bayarInput.addEventListener('input', hitungTotal);
    metodeSelect.addEventListener('change', hitungTotal);
    pelangganSelect.addEventListener('change', hitungTotal);
});
</script>
@endsection

