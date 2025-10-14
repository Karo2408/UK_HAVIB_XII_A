@extends('layouts.app   ')

@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>Pengaturan Sistem
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('setting.update') }}" method="POST" id="settingsForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nama POS</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-store text-primary"></i>
                                        </span>
                                        <input type="text" 
                                               name="pos_name" 
                                               value="{{ $settings['pos_name'] ?? '' }}" 
                                               class="form-control ps-3"
                                               placeholder="Masukkan nama POS"
                                               id="pos_name">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone text-primary"></i>
                                        </span>
                                        <input type="text" 
                                               name="store_phone" 
                                               value="{{ $settings['store_phone'] ?? '' }}" 
                                               class="form-control ps-3"
                                               placeholder="Masukkan nomor telepon"
                                               id="store_phone">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Diskon Global (%)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-percentage text-primary"></i>
                                        </span>
                                        <input type="number" 
                                               name="diskon_global" 
                                               value="{{ $settings['diskon_global'] ?? '' }}" 
                                               class="form-control ps-3"
                                               min="0" 
                                               max="100"
                                               placeholder="0-100"
                                               id="diskon_global">
                                        <span class="input-group-text bg-light">%</span>
                                    </div>
                                    <small class="text-muted">Diskon global yang akan diterapkan pada semua transaksi</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Alamat Toko</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light align-items-start pt-3 border-end-0">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </span>
                                        <textarea name="store_address" 
                                                  class="form-control ps-3" 
                                                  rows="3"
                                                  placeholder="Masukkan alamat lengkap toko"
                                                  id="store_address">{{ $settings['store_address'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Catatan Struk</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light align-items-start pt-3 border-end-0">
                                            <i class="fas fa-sticky-note text-primary"></i>
                                        </span>
                                        <textarea name="footer_note" 
                                                  class="form-control ps-3" 
                                                  rows="3"
                                                  placeholder="Masukkan catatan yang akan muncul di struk"
                                                  id="footer_note">{{ $settings['footer_note'] ?? '' }}</textarea>
                                    </div>
                                    <small class="text-muted">Catatan ini akan muncul di bagian bawah struk</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-outline-secondary" id="resetBtn">
                                        <i class="fas fa-undo me-2"></i>Reset(jangan lupa simpan pengaturan sesudah di reset)
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Pengaturan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Preview Struk
                    </h5>
                </div>
                <div class="card-body">
                    <div class="border rounded p-4 bg-light">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-primary preview-pos-name">{{ $settings['pos_name'] ?? 'Nama POS' }}</h4>
                            <p class="text-muted mb-2 preview-store-address">{{ $settings['store_address'] ?? 'Alamat toko' }}</p>
                            <p class="text-muted mb-2">Telp: <span class="preview-store-phone">{{ $settings['store_phone'] ?? 'Nomor telepon' }}</span></p>
                            <hr>
                        </div>
                        
                        <div class="mb-3">
                            <p><strong>Diskon Global:</strong> <span class="preview-diskon">{{ $settings['diskon_global'] ?? '0' }}%</span></p>
                            <p class="text-muted small preview-footer-note">{{ $settings['footer_note'] ?? 'Catatan struk akan muncul di sini' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ===========================================================
   🎨 DESAIN MODERN: Soft Glass Dashboard Look
   =========================================================== */

body {
    background: linear-gradient(135deg, #6C63FF 0%, #48CAE4 100%);
    min-height: 100vh;
    background-attachment: fixed;
    font-family: 'Poppins', sans-serif;
    color: #212529;
}

/* === CARD STYLE === */
.card {
    border: none;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    overflow: hidden;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.card-header {
    background: linear-gradient(135deg, #6C63FF, #48CAE4);
    color: #fff;
    border-bottom: none;
    padding: 1rem 1.5rem;
}
.card-header .card-title i {
    color: #fff;
}
.card-title {
    font-weight: 700;
    font-size: 1.2rem;
}

/* === FORM STYLE === */
.form-label {
    color: #495057;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.input-group {
    box-shadow: 0 0 0 rgba(0,0,0,0);
    transition: all 0.3s ease;
}
.input-group:focus-within {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108,99,255,0.25);
}
.input-group-text {
    border-radius: 12px 0 0 12px;
    background: rgba(108, 99, 255, 0.1);
    border: none;
    color: #6C63FF;
    font-size: 1.1rem;
}
.form-control, textarea.form-control {
    border-radius: 12px;
    border: none;
    background: rgba(255,255,255,0.85);
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}
.form-control:focus, textarea.form-control:focus {
    background: #fff;
    box-shadow: 0 0 5px rgba(108,99,255,0.5);
}

/* === BUTTON STYLE === */
.btn {
    border-radius: 12px;
    font-weight: 600;
    padding: 0.6rem 1.2rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #6C63FF, #48CAE4);
    border: none;
    box-shadow: 0 5px 15px rgba(108,99,255,0.3);
}
.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(108,99,255,0.5);
}

.btn-outline-secondary {
    border: 2px solid #adb5bd;
    color: #495057;
}
.btn-outline-secondary:hover {
    background: #e9ecef;
    transform: translateY(-3px);
}

/* === ALERT STYLE === */
.alert {
    border: none;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    animation: fadeIn 0.5s ease-in-out;
}
.alert-success {
    background: linear-gradient(135deg, rgba(72,202,228,0.2), rgba(108,99,255,0.2));
    border-left: 4px solid #20c997;
}
.alert-danger {
    background: linear-gradient(135deg, rgba(255,99,132,0.2), rgba(255,56,96,0.2));
    border-left: 4px solid #dc3545;
}

/* === PREVIEW STRUK === */
.bg-light {
    background: rgba(255,255,255,0.9) !important;
    border-radius: 16px;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
}

.preview-pos-name {
    font-size: 1.6rem;
    font-weight: 700;
    color: #6C63FF;
    letter-spacing: 0.5px;
}
.preview-store-address {
    font-size: 0.9rem;
    color: #6c757d;
}
.preview-footer-note {
    color: #495057;
    font-style: italic;
    font-size: 0.9rem;
}

/* === TOAST STYLE === */
.toast {
    border-radius: 12px;
    border: none;
    background: rgba(255,255,255,0.95);
    box-shadow: 0 5px 15px rgba(108,99,255,0.2);
    border-left: 4px solid #6C63FF;
}
.toast-header {
    border-bottom: none;
    background: transparent;
}

/* === HEADER ILLUSTRATION === */
.page-header-hero {
    text-align: center;
    padding: 40px 20px;
    color: white;
}
.page-header-hero i {
    font-size: 3rem;
    color: #fff;
    animation: spinGear 6s linear infinite;
}
.page-header-hero h2 {
    font-weight: 700;
    margin-top: 10px;
}
.page-header-hero p {
    opacity: 0.9;
    font-weight: 300;
}

@keyframes spinGear {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    .page-header-hero h2 {
        font-size: 1.3rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simpan nilai default saat pertama kali load
        const defaultValues = {
            pos_name: "{{ $settings['pos_name'] ?? '' }}",
            store_phone: "{{ $settings['store_phone'] ?? '' }}",
            diskon_global: "{{ $settings['diskon_global'] ?? '' }}",
            store_address: "{{ $settings['store_address'] ?? '' }}",
            footer_note: "{{ $settings['footer_note'] ?? '' }}"
        };

        // Reset button functionality
        document.getElementById('resetBtn').addEventListener('click', function() {
            // Reset semua input ke nilai default (kosong)
            document.getElementById('pos_name').value = '';
            document.getElementById('store_phone').value = '';
            document.getElementById('diskon_global').value = '';
            document.getElementById('store_address').value = '';
            document.getElementById('footer_note').value = '';
            
            // Update preview juga
            updatePreview();
            
            // Show confirmation message
            showToast('Form telah direset ke nilai kosong');
        });

        // Real-time preview update
        const formInputs = document.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                updatePreview();
            });
        });
        
        function updatePreview() {
            const posName = document.getElementById('pos_name').value || 'Nama POS';
            const storeAddress = document.getElementById('store_address').value || 'Alamat toko';
            const storePhone = document.getElementById('store_phone').value || 'Nomor telepon';
            const diskonGlobal = document.getElementById('diskon_global').value || '0';
            const footerNote = document.getElementById('footer_note').value || 'Catatan struk akan muncul di sini';
            
            // Update preview elements
            document.querySelector('.preview-pos-name').textContent = posName;
            document.querySelector('.preview-store-address').textContent = storeAddress;
            document.querySelector('.preview-store-phone').textContent = storePhone;
            document.querySelector('.preview-diskon').textContent = diskonGlobal + '%';
            document.querySelector('.preview-footer-note').textContent = footerNote;
        }
        
        // Initialize preview
        updatePreview();
    });

    function showToast(message) {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="toast show" role="alert">
                <div class="toast-header">
                    <i class="fas fa-undo text-primary me-2"></i>
                    <strong class="me-auto">Reset Form</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }
</script>
@endpush