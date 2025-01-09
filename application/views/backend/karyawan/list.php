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
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Karyawan</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
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

<div class="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class=""></h3>
			</div>
		</div>
	</div>
</div>



<?php $this->load->view('templates/footer') ?>
