@extends('layout')
@section('title', 'Sub Kriteria')
@section('subtitle', 'Sub Kriteria')
@section('content')
	<div class="modal fade text-left" id="SubCritModal" tabindex="-1" role="dialog"
		aria-labelledby="SubCritLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="SubCritLabel">Tambah Sub Kriteria</h4>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<i data-feather="x"></i>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{ route('subkriteria.store') }}" method="post"
						enctype="multipart/form-data" id="SubCritForm" class="needs-validation">
						<input type="hidden" name="id" id="subkriteria-id">
						<label for="nama-sub">Nama Sub Kriteria</label>
						<div class="form-group">
							<input type="text" class="form-control" name="name" id="nama-sub" required />
							<div class="invalid-feedback" id="nama-error">
								Masukkan Nama Sub Kriteria
							</div>
						</div>
						<div class="input-group has-validation mb-3">
							<label class="input-group-text" for="kriteria-select">
								Kriteria
							</label>
							<select class="form-select" id="kriteria-select" name="kriteria_id" required>
								<option value="">Pilih</option>
								@foreach ($kriteria as $kr)
									<option value="{{ $kr->id }}">{{ $kr->name }}</option>
								@endforeach
							</select>
							<div class="invalid-feedback" id="kriteria-error">
								Pilih Kriteria
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<div class="spinner-grow text-primary d-none" role="status">
						<span class="visually-hidden">Menyimpan...</span>
					</div>
					<button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
						<i class="bi bi-x d-block d-sm-none"></i>
						<span class="d-none d-sm-block">Batal</span>
					</button>
					<button type="submit" class="btn btn-primary ml-1 data-submit" form="SubCritForm">
						<i class="bi bi-check d-block d-sm-none"></i>
						<span class="d-none d-sm-block">Simpan</span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-start justify-content-between">
						<div class="content-left">
							<span>Jumlah</span>
							<div class="d-flex align-items-end mt-2">
								<h3 class="mb-0 me-2"><span id="total-counter">-</span></h3>
							</div>
						</div>
						<span class="badge bg-primary rounded p-2">
							<i class="bi bi-list-nested"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
						title="Sub Kriteria Terbanyak per Kriteria">
						<div class="content-left">
							<span>Terbanyak</span>
							<div class="d-flex align-items-end mt-2">
								<h3 class="mb-0 me-2"><span id="total-max">-</span></h3>
							</div>
						</div>
						<span class="badge bg-success rounded p-2">
							<i class="bi bi-list-ol"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
		{{-- <div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<div class="d-flex align-items-start justify-content-between" data-bs-toggle="tooltip"
						title="Klik kolom Nama Sub Kriteria untuk mencari Sub Kriteria duplikat">
						<div class="content-left">
							<span>Duplikat</span>
							<div class="d-flex align-items-end mt-2">
								<h3 class="mb-0 me-2"><span id="total-duplicate">-</span></h3>
							</div>
						</div>
						<span class="badge bg-warning rounded p-2">
							<i class="bi bi-exclamation-circle-fill"></i>
						</span>
					</div>
				</div>
			</div>
		</div> --}}
	</div>
	<div class="card">
		<div class="card-header">Daftar Sub Kriteria</div>
		<div class="card-body">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal"
				data-bs-target="#SubCritModal" id="spare-button">
				<i class="bi bi-plus-lg"></i> Tambah Sub Kriteria
			</button>
			<div class="spinner-grow text-danger d-none" role="status">
				<span class="visually-hidden">Menghapus...</span>
			</div>
			<table class="table table-hover table-striped" id="table-subcrit" style="width: 100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode</th>
						<th>Nama Sub Kriteria</th>
						<th>Kriteria</th>
						<th data-bs-toggle="tooltip"
							title="Bobot didapat melalui pembobotan Sub Kriteria secara konsisten">
							Bobot
						</th>
						<th>Aksi</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
@endsection
@section('js')
	<script type="text/javascript">
		var dt_subkriteria;
		$(document).ready(function() {
			try {
				$.fn.dataTable.ext.errMode = 'none';
				dt_subkriteria = $('#table-subcrit').DataTable({
					stateSave: true,
					lengthChange: false,
					searching: false,
					serverSide: true,
					processing: true,
					responsive: true,
					ajax: {
						url: "{{ route('subkriteria.data') }}",
						type: 'POST'
					},
					order: [
						[3, 'asc']
					],
					columns: [{
						data: 'kr_name'
					}, {
						data: 'id'
					}, {
						data: 'name'
					}, {
						data: 'kriteria_id'
					}, {
						data: 'bobot'
					}, {
						data: 'id'
					}],
					columnDefs: [{
						targets: 0,
						orderable: false,
						render: function(data, type, full, meta) {
							return meta.row + meta.settings
								._iDisplayStart + 1;
						}
					}, {
						targets: 1,
						render: function(data) {
							return 'S' + data;
						}
					}, {
						targets: 3,
						render: function(data, type, full) {
							return `<span title="${full['desc_kr']}">C${data}: ${full['kr_name']}</span>`;
						}
					}, { //Aksi
						orderable: false,
						targets: -1,
						render: function(data, type, full) {
							return (
								'<div class="btn-group" role="group">' +
								`<button class="btn btn-sm btn-primary edit-record" data-id="${data}" data-bs-toggle="modal" data-bs-target="#SubCritModal" title="Edit"><i class="bi bi-pencil-square"></i></button>` +
								`<button class="btn btn-sm btn-danger delete-record" data-id="${data}" data-name="${full['name']}" title="Hapus"><i class="bi bi-trash3-fill"></i></button>` +
								'</div>'
							);
						}
					}],
					language: {
						url: "{{ asset('assets/extensions/DataTables/DataTables-id.json') }}"
					},
					dom: 'Bfrtip',
					buttons: [{
						text: '<i class="bi bi-plus-lg me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Tambah Sub Kriteria</span>',
						className: 'add-new btn',
						attr: {
							'data-bs-toggle': 'modal',
							'data-bs-target': '#SubCritModal'
						}
					}, {
						extend: 'collection',
						text: '<i class="bi bi-download me-0 me-sm-1"></i> Ekspor',
						className: 'btn dropdown-toggle',
						buttons: [{
							extend: 'print',
							title: 'Sub Kriteria',
							text: '<i class="bi bi-printer me-2"></i> Print',
							className: 'dropdown-item',
							exportOptions: {
								columns: [1, 2, 3, 4]
							}
						}, {
							extend: 'csv',
							title: 'Sub Kriteria',
							text: '<i class="bi bi-file-text me-2"></i> CSV',
							className: 'dropdown-item',
							exportOptions: {
								columns: [1, 2, 3, 4]
							}
						}, {
							extend: 'excel',
							title: 'Sub Kriteria',
							text: '<i class="bi bi-file-spreadsheet me-2"></i> Excel',
							className: 'dropdown-item',
							exportOptions: {
								columns: [1, 2, 3, 4]
							}
						}, {
							extend: 'pdf',
							title: 'Sub Kriteria',
							text: '<i class="bi bi-file-text me-2"></i> PDF',
							className: 'dropdown-item',
							exportOptions: {
								columns: [1, 2, 3, 4]
							}
						}, {
							extend: 'copy',
							title: 'Sub Kriteria',
							text: '<i class="bi bi-clipboard me-2"></i> Copy',
							className: 'dropdown-item',
							exportOptions: {
								columns: [1, 2, 3, 4]
							}
						}]
					}],
				}).on('error.dt', function(e, settings, techNote, message) {
					errorDT(message, techNote);
				}).on('preDraw', function() {
					$.get("{{ route('subkriteria.count') }}", function(data) {
						// $("#total-duplicate").text(data.duplicates);
						$('#total-max').text(data.max);
						$("#total-counter").text(data.total);
					}).fail(function(xhr, stat, err) {
						Toastify({
							text: "Gagal memuat jumlah: Kesalahan HTTP " +
								xhr.status + '. ' + (xhr
									.statusText ?? err),
							style: {
								background: "#dc3545"
							},
							duration: 9000
						}).showToast();
					});
				}).on('draw', setTableColor).on('preInit.dt', removeBtn());
			} catch (dterr) {
				initError(dterr.message);
			}
		}).on('click', '.delete-record', function() {
			var sub_id = $(this).data('id'),
				sub_name = $(this).data('name');

			Swal.fire({
				title: 'Hapus sub kriteria?',
				text: "Anda akan menghapus sub kriteria " + sub_name + ".",
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
				if (result.value) { // delete the data
					$.ajax({
						type: 'DELETE',
						url: '/kriteria/sub/del/' + sub_id,
						beforeSend: function() {
							$('.spinner-grow.text-danger')
								.removeClass('d-none');
						},
						complete: function() {
							$('.spinner-grow.text-danger')
								.addClass('d-none');
						},
						success: function(data) {
							dt_subkriteria.draw();
							Swal.fire({
								icon: 'success',
								title: 'Dihapus',
								text: data.message,
								customClass: {
									confirmButton: 'btn btn-success'
								}
							});
						},
						error: function(xhr, stat, err) {
							if (xhr.status === 404)
								dt_subkriteria.draw();
							Swal.fire({
								icon: 'error',
								title: 'Gagal hapus',
								text: 'Kesalahan HTTP ' + xhr
									.status + '. ' + (xhr
										.responseJSON
										.message ?? err),
								customClass: {
									confirmButton: 'btn btn-success'
								}
							});
						}
					});
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					Swal.fire({
						title: 'Dibatalkan',
						text: 'Sub Kriteria tidak dihapus.',
						icon: 'warning',
						customClass: {
							confirmButton: 'btn btn-success'
						}
					});
				}
			});
		}).on('click', '.edit-record', function() {
			var sub_id = $(this).data('id');

			// changing the title of offcanvas
			$('#SubCritForm :input').prop('disabled', true);
			$('#SubCritLabel').html('Edit Sub Kriteria');
			$('.data-submit').prop('disabled', true);
			$('.spinner-grow.text-primary').removeClass('d-none');

			// get data
			$.get('/kriteria/sub/edit/' + sub_id, function(data) {
				$('#subkriteria-id').val(data.id);
				$('#nama-sub').val(data.name);
				$('#kriteria-select').val(data.kriteria_id);
			}).fail(function(xhr, stat, err) {
				if (xhr.status === 404)
					dt_subkriteria.draw();
				Swal.fire({
					icon: 'error',
					title: 'Kesalahan',
					text: 'Kesalahan HTTP ' + xhr.status + '. ' +
						(xhr.responseJSON.message ?? err),
					customClass: {
						confirmButton: 'btn btn-success'
					}
				});
			}).always(function() {
				$('#SubCritForm :input').prop('disabled', false);
				$('.data-submit').prop('disabled', false);
				$('.spinner-grow.text-primary').addClass('d-none');
			});
		});

		function submitform(event) {
			var errmsg, actionurl = $('#subkriteria-id').val() == '' ?
				"{{ route('subkriteria.store') }}" : "{{ route('subkriteria.update') }}";
			event.preventDefault();
			$.ajax({
				data: $('#SubCritForm').serialize(),
				url: actionurl,
				type: 'POST',
				beforeSend: function() {
					$('#SubCritForm :input')
						.prop('disabled', true);
					$('#SubCritForm :input')
						.removeClass('is-invalid');
					$('.data-submit').prop('disabled', true);
					$('.spinner-grow.text-primary').removeClass('d-none');
				},
				complete: function() {
					$('#SubCritForm :input')
						.prop('disabled', false);
					$('.data-submit').prop('disabled', false);
					$('.spinner-grow.text-primary').addClass('d-none');
				},
				success: function(status) {
					if ($.fn.DataTable.isDataTable("#table-subcrit"))
						dt_subkriteria.draw();
					$('#SubCritModal').modal('hide');
					Swal.fire({
						icon: 'success',
						title: 'Sukses',
						text: status.message,
						customClass: {
							confirmButton: 'btn btn-success'
						}
					});
				},
				error: function(xhr, st, err) {
					if (xhr.status === 422) {
						resetvalidation();
						if (typeof xhr.responseJSON.errors.name !==
							"undefined") {
							$('#nama-sub').addClass('is-invalid');
							$('#nama-error')
								.text(xhr.responseJSON.errors.name);
						}
						if (typeof xhr.responseJSON.errors.kriteria_id !==
							"undefined") {
							$('#kriteria-select').addClass('is-invalid');
							$('#kriteria-error')
								.text(xhr.responseJSON.errors.kriteria_id);
						}
						errmsg = xhr.responseJSON.message;
					} else {
						errmsg = 'Kesalahan HTTP ' + xhr.status + '. ' +
							(xhr.responseJSON.message ?? err);
					}
					Swal.fire({
						title: 'Gagal',
						text: errmsg,
						icon: 'error',
						customClass: {
							confirmButton: 'btn btn-success'
						}
					});
				}
			});
		};
		// clearing form data when modal hidden
		$('#SubCritModal').on('hidden.bs.modal', function() {
			resetvalidation();
			$('#SubCritForm')[0].reset();
			$('#subkriteria-id').val("");
			$('#SubCritLabel').html('Tambah Sub Kriteria');
		});
	</script>
@endsection
