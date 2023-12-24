@extends('admin.auth')
@section('title', 'Lupa Password')
@section('auth-title', 'Lupa Password')
@section('auth-subtitle', 'Masukkan email Anda untuk mendapatkan link reset password')
@section('auth-css', secure_asset('assets/compiled/css/auth-forgot-password.css'))
@section('content')
	<form action="{{ route('password.email') }}" method="post" class="needs-validation">
		@csrf
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="email" placeholder="Email" name="email" value="{{ old('email') }}"
				class="form-control form-control-xl @error('email') is-invalid @enderror " required />
			<div class="form-control-icon"><i class="bi bi-envelope"></i></div>
			<div class="invalid-feedback">
				@error('email')
					{{ $message }}
				@else
					Masukkan Email Akun yang lupa password
				@enderror
			</div>
		</div>
		<button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
			id="submitBtn">
			<i class="bi bi-send-fill"></i> Kirim
		</button>
	</form>
	<div class="text-center mt-5 text-lg fs-4">
		<p class="text-gray-600">
			Ingat akun Anda? <a href="{{ route('login') }}" class="font-bold">Login</a>
		</p>
	</div>
@endsection
