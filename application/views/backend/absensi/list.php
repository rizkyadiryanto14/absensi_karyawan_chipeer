<?php $this->load->view('templates/header') ?>
<?php $this->load->view('templates/navbar') ?>
<?php $this->load->view('templates/sidebar') ?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Absensi</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Absensi</li>
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
				<?php if ($this->session->userdata('role') == 'admin') { ?>
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="absensi" class="table table-bordered">
										<thead>
										<tr>
											<th>No</th>
											<th>Nama</th>
											<th>Alamat</th>
											<th>Jabatan</th>
											<th>Waktu Absensi</th>
											<th>Keterangan</th>
										</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php } elseif ($this->session->userdata('role') == 'karyawan') { ?>
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								<h5>Masukkan Absensi</h5>
							</div>
							<div class="card-body">
								<form id="form-absensi" method="POST" action="<?= base_url('absensi/submit/' .$karyawan['id']); ?>">
									<div class="form-group">
										<label for="keterangan">Keterangan</label>
										<input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan absensi" required>
									</div>
									<div class="form-group">
										<label for="jenis_absensi">Keterangan</label>
										<select name="jenis_absensi" id="jenis_absensi" class="form-control" aria-required="true">
											<option selected disabled>Pilih Jenis Absensi</option>
											<option value="Masuk">Absensi Masuk</option>
											<option value="Keluar">Absensi Keluar</option>
											<option value="Izin">Izin</option>
											<option value="Sakit">Sakit</option>
										</select>
									</div>
									<button type="submit" class="btn btn-primary">Submit</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">
								<h5>Data Absensi Saya</h5>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="absensi" class="table table-bordered">
										<thead>
										<tr>
											<th>No</th>
											<th>Nama</th>
											<th>Alamat</th>
											<th>Jabatan</th>
											<th>Waktu Absensi</th>
											<th>Keterangan</th>
										</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Masukkan DataTables JS di sini -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function () {
		var dataTable = $('#absensi').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "<?php echo site_url('admin/get_data_absensi'); ?>",
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
