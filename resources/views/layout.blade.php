<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>
		@yield('title') - SPK Stunting
	</title>
	<link rel="shortcut icon" href="{{ secure_asset('assets/compiled/svg/favicon.svg') }}"
		type="image/x-icon" />
	<link rel="shortcut icon" href="{{ secure_asset('assets/static/images/logo/favicon.png') }}"
		type="image/png" />
	<link rel="stylesheet" href="{{ secure_asset('assets/compiled/css/app.css') }}" />
	<link rel="stylesheet" href="{{ secure_asset('assets/compiled/css/app-dark.css') }}" />
	<link rel="stylesheet" href="{{ secure_asset('assets/compiled/css/iconly.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ secure_asset('assets/extensions/DataTables/datatables.min.css') }}">
	<link rel="stylesheet" type="text/css"
		href="{{ secure_asset('assets/compiled/css/table-datatable-jquery.css') }}">
	<link rel="stylesheet" href="{{ secure_asset('assets/extensions/apexcharts/apexcharts.css') }}">
	<link rel="stylesheet"
		href="{{ secure_asset('assets/extensions/toastify-js/src/toastify.css') }}" />
	<link rel="stylesheet" type="text/css"
		href="{{ secure_asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
	<link rel="stylesheet"
		href="{{ secure_asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}" />
	<script src="{{ secure_asset('assets/static/js/initTheme.js') }}"></script>
</head>

<body onload="switchvalidation()">
	<div id="app">
		<div id="sidebar" class="active">
			<div class="sidebar-wrapper active">
				<div class="sidebar-header position-relative">
					<div class="d-flex justify-content-between align-items-center">
						<div class="logo">
							<a href="{{ route('home.index') }}">
								<!-- <img src="{{ secure_asset('assets/compiled/svg/logo.svg') }}" alt="Logo" /> -->
							</a>
						</div>
						<div class="theme-toggle d-flex gap-2 align-items-center mt-2">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
								aria-hidden="true" role="img" class="iconify iconify--system-uicons"
								width="20" height="20" preserveAspectRatio="xMidYMid meet"
								viewBox="0 0 21 21">
								<g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
									stroke-linejoin="round">
									<path
										d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
										opacity=".3"></path>
									<g transform="translate(-210 -1)">
										<path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
										<circle cx="220.5" cy="11.5" r="4"></circle>
										<path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
										</path>
									</g>
								</g>
							</svg>
							<div class="form-check form-switch fs-6">
								<input class="form-check-input me-0" type="checkbox" id="toggle-dark"
									style="cursor: pointer" />
								<label class="form-check-label"></label>
							</div>
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
								aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
								height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
								<path fill="currentColor"
									d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
								</path>
							</svg>
						</div>
						<div class="sidebar-toggler x">
							<a href="javascript:void(0)" class="sidebar-hide d-xl-none d-block">
								<i class="bi bi-x bi-middle"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="sidebar-menu">
					<ul class="menu">
						@auth
							<li class="sidebar-title">Menu</li>
							<li class="sidebar-item">
								<a href="{{ route('home.index') }}" class="sidebar-link">
									<i class="bi bi-house-fill"></i>
									<span>Beranda</span>
								</a>
							</li>
							<li class="sidebar-item has-sub">
								<a href="#" class="sidebar-link">
									<i class="bi bi-clipboard-data-fill"></i>
									<span>Data Master</span>
								</a>
								<ul class="submenu">
									<li class="submenu-item">
										<a href="{{ route('kriteria.index') }}" class="submenu-link">
											Kriteria
										</a>
									</li>
									<li class="submenu-item">
										<a href="{{ route('subkriteria.index') }}" class="submenu-link">
											Sub Kriteria
										</a>
									</li>
									<li class="submenu-item">
										<a href="{{ route('alternatif.index') }}" class="submenu-link">
											Alternatif
										</a>
									</li>
								</ul>
							</li>
							<li
								class="sidebar-item has-sub {{ request()->is('bobot/hasil') || request()->is('bobot/sub/*') ? 'active' : '' }}">
								<a href="#" class="sidebar-link">
									<i class="bi bi-calculator-fill"></i>
									<span>Pembobotan</span>
								</a>
								<ul class="submenu">
									<li
										class="submenu-item
									 {{ request()->is('bobot/hasil') ? 'active' : '' }}">
										<a href="{{ route('bobotkriteria.index') }}" class="submenu-link">
											Kriteria
										</a>
									</li>
									<li
										class="submenu-item
									 {{ request()->is('bobot/sub/*') ? 'active' : '' }}">
										<a href="{{ route('bobotsubkriteria.pick') }}" class="submenu-link">
											Sub Kriteria
										</a>
									</li>
								</ul>
							</li>
							<li class="sidebar-item">
								<a href="{{ route('nilai.index') }}" class="sidebar-link">
									<i class="bi bi-pen-fill"></i>
									<span>Penilaian Alternatif</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="{{ route('nilai.show') }}" class="sidebar-link">
									<i class="bi bi-bar-chart-line-fill"></i>
									<span>Hasil</span>
								</a>
							</li>
						@else
							<li class="sidebar-item active">
								<a href="{{ route('login') }}" class="sidebar-link">
									<i class="bi bi-box-arrow-in-right me-2"></i>
									<span>Login</span>
								</a>
							</li>
						@endauth
					</ul>
				</div>
			</div>
		</div>
		<div id="main" class="layout-navbar navbar-fixed">
			<header class="mb-3">
				<nav class="navbar navbar-expand navbar-light navbar-top">
					<div class="container-fluid">
						<a href="javascript:void(0)" class="burger-btn d-block">
							<i class="bi bi-justify fs-3"></i>
						</a>
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
							data-bs-target="#navbarSupportedContent" aria-label="Toggle navigation"
							aria-controls="navbarSupportedContent" aria-expanded="false">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							@auth
								<ul class="navbar-nav ms-auto mb-lg-0">
									<li class="nav-item me-5">
										<a class="nav-link active text-gray-600" href="{{ route('php.info') }}"
											target="_blank">
											PHP Info
										</a>
									</li>
								</ul>
								<div class="dropdown">
									<a href="#" data-bs-toggle="dropdown" aria-expanded="false">
										<div class="user-menu d-flex">
											<div class="user-name text-end me-3">
												<p class="mb-0 text-gray-600">
													{{ auth()->user()->name }}
												</p>
											</div>
											<div class="user-img d-flex align-items-center">
												<div class="avatar me-3 {{ session('avatar-bg') }}">
													<span class="avatar-content">{{ substr(auth()->user()->name, 0, 1) }}</span>
												</div>
											</div>
										</div>
									</a>
									<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
										style="min-width: 11rem">
										<li>
											<h6 class="dropdown-header">Akun</h6>
										</li>
										<li>
											<a class="dropdown-item" href="{{ route('akun.show') }}">
												<i class="icon-mid bi bi-person me-2"></i> Edit Akun
											</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>
										<li>
											<a class="dropdown-item" href="{{ route('logout') }}"
												onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
												<i class="icon-mid bi bi-box-arrow-left me-2"></i>
												Logout
											</a>
										</li>
									</ul>
								</div>
								<form method="POST" id="logout-form" action="{{ route('logout') }}">
									@csrf
								</form>
							@endauth
						</div>
					</div>
				</nav>
			</header>
			<div id="main-content">
				<div class="page-heading">
					<div class="page-title">
						<h3>@yield('subtitle')</h3>
						@hasSection('page-desc')
							<p class="text-subtitle text-muted">@yield('page-desc')</p>
						@endif
					</div>
					<section class="content">
						<x-no-script />
						<x-errors />
						<x-alert type="error" icon="bi bi-x-circle-fill" />
						<x-alert type="warning" icon="bi bi-exclamation-circle-fill" />
						<x-alert type="success" icon="bi bi-check-circle-fill" />
						@yield('content')
					</section>
				</div>
				<footer>
					<div class="footer clearfix mb-0 text-muted">
						<div class="float-start">
							<p>{{ date('Y') }} &copy; SPK Stunting</p>
						</div>
						<div class="float-end">
							<p>
								Dashboard template from
								<a href="https://zuramai.github.io/mazer/" _blank>Mazer</a>
								<br>
								Developed by
								<a href="https://sendhyrama.dev" _blank>Sendhy Ramadhinata</a>
							</p>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{{ secure_asset('js/navbar.js') }}"></script>
	<script src="{{ secure_asset('assets/static/js/components/dark.js') }}"></script>
	<script src="{{ secure_asset('assets/compiled/js/app.js') }}"></script>
	<script type="text/javascript"
		src="{{ secure_asset('assets/extensions/jquery/jquery.min.js') }}"></script>
	<script
		src="{{ secure_asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}">
	</script>
	<script type="text/javascript"
		src="{{ secure_asset('assets/extensions/DataTables/datatables.min.js') }}"></script>
	<script type="text/javascript"
		src="{{ secure_asset('assets/extensions/DataTables/Buttons-2.4.2/js/buttons.print.min.js') }}">
	</script>
	<script src="{{ secure_asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
	<script type="text/javascript"
		src="{{ secure_asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
	<script type="text/javascript"
		src="{{ secure_asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
	<script type="text/javascript" src="{{ secure_asset('js/tooltip.js') }}"></script>
	<script type="text/javascript" src="{{ secure_asset('js/datatables.js') }}"></script>
	<script type="text/javascript" src="{{ secure_asset('js/validate.js') }}"></script>
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			}
		});
	</script>
	@yield('js')
</body>

</html>
