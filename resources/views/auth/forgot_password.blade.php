@extends('auth.authApp')
@section('title')
GuruCoding | Login
@endsection
@section('content')
<section class="bg-light py-3 py-md-5 d-flex justify-content-center align-items-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="text-center mb-3">
              <a href="#!">
                <img src="{{ asset('img/gurucoding.png') }}" alt="BootstrapBrain Logo" width="320" height="60">
              </a>
            </div>
            <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Masuk ke akun Anda</h2>
            @if(Session::has('error'))
              <div class="alert alert-danger" role="alert" style="text-align: center">{{ Session::get('error') }}</div>
            @endif
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert" style="text-align: center">{{ Session::get('success') }}</div>
            @endif
            <form method="POST" action="{{ route('forgot-password') }}">
                @csrf
                <div class="row gy-2 overflow-hidden">
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                            <label for="email" class="form-label">Email</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                            <label for="password" class="form-label">Password</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Again" required>
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-grid my-3">
                            <button id="loginButton" class="btn btn-primary btn-lg" type="submit" disabled>Ganti Password</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="m-0 text-secondary text-center"><a href="{{ route('login') }}" class="link-primary text-decoration-none">Kembali</a></p>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<style>
  @media (max-width: 768px) {
    section {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('loginButton');

    function toggleLoginButton() {
      if (emailInput.value.trim() !== '' && passwordInput.value.trim() !== '') {
        loginButton.removeAttribute('disabled');
      } else {
        loginButton.setAttribute('disabled', 'true');
      }
    }

    emailInput.addEventListener('input', toggleLoginButton);
    passwordInput.addEventListener('input', toggleLoginButton);
  });
</script>
@endsection
