@extends('layout')
@section('title', 'Home')
@section('subtitle', 'Home')
@section('page-desc')
	@auth Hai, {{ auth()->user()->name }}
	@else
	@endauth
@endsection
@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">
				Selamat datang di Website SPK Stunting
			</h3>
		</div>
		<div class="card-body">
			<p>Sistem ini dapat memberikan kemudahan dalam menilai dan mengidentifikasi anak-anak yang 
				membutuhkan bantuan Stunting. Aplikasi ini dibuat dengan menggunakan metode Analytical Hierarchy Process (AHP) dan
				Simple Additive Weighting (SAW).</p>
			<p>Pembobotan Kriteria dan Sub Kriteria menggunakan metode AHP, sedangkan pembobotan
				Alternatif menggunakan metode Simple Additive Weighting (SAW).</p>
			<p>Bobot Kriteria dan Sub Kriteria didapat dengan cara melakukan perbandingan secara
				konsisten (Nilai CR &#8804; 10%). </p>
		</div>
	</div>
	@auth
		@if (array_key_exists('error', $jml))
			<div class="alert alert-danger" role="alert">
				<i class="bi bi-x-circle-fill"></i>
				Gagal memuat jumlah Data Master: {{ $jml['error'] }}
			</div>
		@else
			<div class="row">
				<div class="col-6 col-lg-4 col-md-6">
					<div class="card">
						<div class="card-body px-4 py-4-5">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon purple mb-2">
										<i class="iconly-boldShow"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Jumlah Kriteria</h6>
									<h6 class="font-extrabold mb-0">{{ $jml['kriteria'] }}</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-4 col-md-6">
					<div class="card">
						<div class="card-body px-4 py-4-5">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon blue mb-2">
										<i class="iconly-boldProfile"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Jumlah Sub Kriteria</h6>
									<h6 class="font-extrabold mb-0">{{ $jml['subkriteria'] }}</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-lg-4 col-md-6">
					<div class="card">
						<div class="card-body px-4 py-4-5">
							<div class="row">
								<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
									<div class="stats-icon green mb-2">
										<i class="iconly-boldAdd-User"></i>
									</div>
								</div>
								<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
									<h6 class="text-muted font-semibold">Jumlah Alternatif</h6>
									<h6 class="font-extrabold mb-0">{{ $jml['alternatif'] }}</h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
	@endauth
@endsection
