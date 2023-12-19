@extends('layout')
@php
	use App\Http\Controllers\SubKriteriaController;
	$subkriteriacomp = new SubKriteriaController();
	$title = $subkriteriacomp->nama_kriteria($kriteria_id);
@endphp
@section('title', 'Hasil Perbandingan Sub Kriteria' . $title)
@section('subtitle', 'Hasil Perbandingan Sub Kriteria ' . $title)
@section('content')
	<x-inconsistent-reason />
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Matriks Perbandingan Awal</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-striped text-center">
					<thead>
						<tr>
							<th>Sub Kriteria</th>
							@foreach ($data['subkriteria'] as $kr)
								<th>{{ $kr->name }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach ($data['subkriteria'] as $kr)
							<tr>
								<th>{{ $kr->name }}</th>
								@foreach ($data['matriks_awal'] as $ma)
									@if ($ma['kode_kriteria'] === $kr->idsubkriteria)
										<td>{!! $ma['nilai'] !!}</td>
									@endif
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Matriks Nilai Perbandingan</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-striped text-center">
					<thead>
						<tr>
							<th>Sub Kriteria</th>
							@foreach ($data['subkriteria'] as $kr)
								<th>{{ $kr->name }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach ($data['subkriteria'] as $kr)
							<tr>
								<th>{{ $kr->name }}</th>
								@foreach ($data['matriks_perbandingan'] as $mp)
									@if ($mp['kode_kriteria'] === $kr->idsubkriteria)
										<td>{{ round($mp['nilai'], 5) }}</td>
									@endif
								@endforeach
							</tr>
						@endforeach
						<tr>
							<th>Jumlah</th>
							@foreach ($data['jumlah'] as $nilai)
								<td class="text-info">{{ round($nilai, 5) }}</td>
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Normalisasi dan Eigen</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-striped text-center">
					<thead>
						<tr>
							<th>Sub Kriteria</th>
							@foreach ($data['subkriteria'] as $kr)
								<th>{{ $kr->name }}</th>
							@endforeach
							<th>Jumlah Baris</th>
							<th data-bs-toggle="tooltip" title="Bobot Prioritas">
								Eigen
							</th>
							<th>Consistency Measure</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data['subkriteria'] as $kr)
							<tr>
								<th>{{ $kr->name }}</th>
								@foreach ($data['matriks_normalisasi'] as $mn)
									@if ($mn['kode_kriteria'] === $kr->idsubkriteria)
										<td>{{ round($mn['nilai'], 5) }}</td>
									@endif
								@endforeach
								@if ($data['bobot_prioritas'][$loop->index]['kode_kriteria'] === $kr->idsubkriteria)
									<td class="text-info">
										{{ round($data['bobot_prioritas'][$loop->index]['jumlah_baris'], 5) }}
									</td>
									<td class="text-info">
										{{ round($data['bobot_prioritas'][$loop->index]['bobot'], 5) }}
									</td>
								@endif
								@if ($data['cm'][$loop->index]['kode_kriteria'] === $kr->idsubkriteria)
									<td class="text-info">
										{{ round($data['cm'][$loop->index]['cm'], 5) }}
									</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<div class="card-title">Nilai Konsistensi</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
						<td>Principe Eigen Vektor</td>
						<td>{{ round($data['average_cm'], 5) }}</td>
					</tr>
					<tr>
						<td>Consistency Index (CI)</td>
						<td>{{ round($data['ci'], 5) }}</td>
					</tr>
					<tr>
						<td>Consistency Ratio (CR)</td>
						<td>
							@if (is_numeric($data['result']))
								{{ round($data['result'], 5) }}
								<span @class(['text-danger' => $data['result'] > 0.1])>
									({{ round($data['result'] * 100, 2) }}%)
								</span>
								@php
									$consistent = $data['result'] <= 0.1;
								@endphp
							@else
								@php
									$consistent = true;
									echo '-';
								@endphp
							@endif
						</td>
					</tr>
					<tr>
						<td>Hasil Konsistensi</td>
						<td>
							<span @class([
								'text-warning' => !is_numeric($data['result']),
								'text-danger' => !$consistent,
								'text-success' => is_numeric($data['result']) && $data['result'] <= 0.1,
							])>
								@if (!is_numeric($data['result']))
									<b>Tidak bisa dievaluasi</b>
								@elseif ($consistent)
									<b>Konsisten</b>
								@else
									<b>Tidak Konsisten</b>, mohon untuk menginput ulang perbandingan!
								@endif
							</span>
						</td>
					</tr>
				</table>
				<div class="col-12 d-flex justify-content-end">
					<div class="spinner-grow text-info me-3 d-none" role="status">
						<span class="visually-hidden">Mereset...</span>
					</div>
					<div class="btn-group">
						<a href="{{ route('bobotsubkriteria.pick') }}" class="btn btn-secondary">
							<i class="bi bi-arrow-left"></i> Kembali
						</a>
						<a href="{{ route('bobotsubkriteria.index', $kriteria_id) }}"
							class="btn btn-primary">
							<i class="bi bi-pencil-fill"></i> Edit
						</a>
						<a href="{{ route('bobotsubkriteria.reset', $kriteria_id) }}"
							class="btn btn-warning" id="reset-button">
							<i class="bi bi-arrow-counterclockwise"></i> Reset
						</a>
						@if ($data['bobot_sub_kosong'] == 0)
							<a href="{{ route('nilai.index') }}" class="btn btn-success">
								<i class="bi bi-arrow-right"></i> Lanjut
							</a>
						@elseif(!$consistent)
							<button type="button" class="btn btn-info" data-bs-toggle="modal"
								data-bs-target="#inconsistentModal">
								?
							</button>
						@endif
					</div>
					<form action="{{ route('bobotsubkriteria.reset', $kriteria_id) }}"
						id="reset-subkriteria" method="POST">
						@csrf
						@method('DELETE')
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script type="text/javascript">
		$(document).on('click', '#reset-button', function(e) {
			e.preventDefault();
			Swal.fire({
				title: 'Reset perbandingan?',
				text: "Anda akan mereset perbandingan Sub Kriteria {{ $title }}. " +
					"Bobot Sub Kriteria {{ $title }} akan direset!",
				icon: 'question',
				showCancelButton: true,
				confirmButtonText: 'Ya',
				cancelButtonText: 'Tidak',
				customClass: {
					confirmButton: 'btn btn-primary me-3',
					cancelButton: 'btn btn-secondary'
				},
				buttonsStyling: false
			}).then(function(result) {
				if (result.value) {
					document.getElementById('reset-subkriteria').submit();
					$('.spinner-grow').removeClass('d-none');
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire({
						title: 'Dibatalkan',
						text: "Perbandingan Sub Kriteria {{ $title }} tidak direset.",
						icon: 'warning',
						customClass: {
							confirmButton: 'btn btn-success'
						}
					});
				}
			});
		});
	</script>
@endsection
