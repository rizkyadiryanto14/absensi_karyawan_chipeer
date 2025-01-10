<?php $this->load->view('templates/header') ?>
<?php $this->load->view('templates/navbar') ?>
<?php $this->load->view('templates/sidebar') ?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Karyawan</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Karyawan</li>
					</ol>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->


	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card-header">
						<button class="btn btn-primary" data-toggle="modal" data-target=".tambah-karyawan">Tambah Karyawan</button>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="karyawan" class="table table-bordered">
								<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Alamat</th>
									<th>Tgl Lahir</th>
									<th>Jabatan</th>
									<th>No.Telepon</th>
									<th>No KTP</th>
									<th>Action</th>
								</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade tambah-karyawan">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Form Tambah Karyawan</h3>
			</div>
			<form action="<?= base_url('karyawan/simpan') ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<label for="nama">Nama</label>
						<input type="text" name="nama" id="nama" class="form-control">
					</div>
					<div class="form-group">
						<label for="alamat">Alamat</label>
						<input type="text" name="alamat" id="alamat" class="form-control">
					</div>
					<div class="form-group">
						<label for="tgl_lahir">Tgl Lahir</label>
						<input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control">
					</div>
					<div class="form-group">
						<label for="jabatan">Jabatan</label>
						<input type="text" name="jabatan" id="jabatan" class="form-control">
					</div>
					<div class="form-group">
						<label for="no_telepon">No.Telepon</label>
						<input type="text" name="no_telepon" id="no_telepon" class="form-control">
					</div>
					<div class="form-group">
						<label for="no_ktp">No.KTP</label>
						<input type="text" name="no_ktp" id="no_ktp" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" type="submit">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Masukkan DataTables JS di sini -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
		var dataTable = $('#karyawan').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "<?php echo site_url('admin/get_data_karyawan'); ?>",
				type: "POST"
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4],
				"orderable": false,
			}],
		});
	});
</script>

<?php $this->load->view('templates/footer') ?>
