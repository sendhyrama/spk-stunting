<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>401 Unauthorized | Sistem Pendukung Keputusan metode AHP & SAW</title>
	<link rel="stylesheet" href="{{ secure_asset('assets/compiled/css/app.css') }}" />
	<link rel="stylesheet" href="{{ secure_asset('assets/compiled/css/error-403.css') }}" />
	<link rel="shortcut icon" href="{{ secure_asset('assets/compiled/svg/favicon.svg') }}"
		type="image/x-icon" />
	<link rel="shortcut icon"
		href="{{ secure_asset('assets/static/images/logo/favicon.png') }}"
		type="image/png" />
	<script src="{{ secure_asset('assets/static/js/initTheme.js') }}"></script>
</head>

<body>
	<div id="error">
		<div class="error-page container">
			<div class="col-md-8 col-12 offset-md-2">
				<div class="text-center">
					<h1 class="error-title">401 Unauthorized</h1>
					<p class="fs-5 text-gray-600">
						Anda tidak bisa mengakses halaman ini tanpa otorisasi.
					</p>
					<a href="{{ route('home.index') }}"
						class="btn btn-lg btn-outline-primary mt-3">
						<i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Beranda
					</a>
				</div>
			</div>
		</div>
	</div>
</body>

</html>
