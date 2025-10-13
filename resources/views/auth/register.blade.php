<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register POS</title>
  <link rel="shortcut icon" href="{{ asset('assets/images/logos/PPS.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    /* Custom Styles */
    body {
      background-color: #e3f9e5; /* Latar belakang hijau muda */
      font-family: 'Arial', sans-serif;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      background-color: white;
    }
    .card-body {
      padding: 30px;
    }
    .btn-success {
      background-color: #28a745; /* Hijau */
      border-color: #28a745;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .btn-success:hover {
      background-color: #218838; /* Gelap sedikit */
      transform: translateY(-3px);
    }
    .form-control {
      border-radius: 8px;
      border: 1px solid #28a745;
    }
    .form-control:focus {
      border-color: #218838;
      box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
    }
    .text-primary {
      color: #28a745 !important;
    }
    .card-header {
      background-color: #28a745;
      color: white;
      text-align: center;
      font-size: 24px;
      padding: 15px;
    }
    .footer-text {
      font-size: 14px;
      color: #777;
    }
    .footer-text a {
      color: #28a745;
      text-decoration: none;
    }
    .footer-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="page-wrapper min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row justify-content-center w-100">
      <div class="col-md-8 col-lg-6 col-xxl-3">
        <div class="card mb-0">
          <div class="card-header">
            <img src="{{ asset('assets/images/logos/PPS.png') }}" width="180" alt="Logo">
          </div>
          <div class="card-body">
            <p class="text-center">Buat akun baru</p>
            <form method="POST" action="{{ route('register.post') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="Nama" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="Email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="Password" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="Password_confirmation" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-success w-100 py-2 fs-5 mb-3 rounded-2">Daftar</button>
              <div class="text-center">
                <p class="fs-6 mb-0 footer-text">Sudah punya akun?
                  <a href="{{ route('login') }}" class="fw-bold text-primary">Masuk</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    @if(session('success'))
      Swal.fire({
        toast: true,
        icon: 'success',
        title: "{{ session('success') }}",
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' }
      })
    @endif

    @if($errors->any())
      Swal.fire({
        toast: true,
        icon: 'error',
        title: "{{ $errors->first() }}",
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' }
      })
    @endif
  </script>
</body>
</html>
