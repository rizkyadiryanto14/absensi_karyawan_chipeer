<?php $this->load->view('templates/header') ?>
<?php $this->load->view('templates/navbar') ?>
<?php $this->load->view('templates/sidebar') ?>

<style>
	.uppercase {
		text-transform: uppercase;
		font-weight: bold;
	}
</style>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Dashboard</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<!-- Small boxes (Stat box) -->
				<?php if ($this->session->userdata('role') == 'admin') { ?>
				<div class="row">
					<div class="col-lg-3 col-6">
						<!-- small box -->
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?= $karyawan_total ?></h3>

								<p>Total Karyawan</p>
							</div>
							<div class="icon">
								<i class="ion ion-bag"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
					<div class="col-lg-3 col-6">
						<div class="small-box bg-success">
							<div class="inner">
								<h3><?= isset($absensi_counts['Masuk']) ? $absensi_counts['Masuk'] : 0; ?></h3>
								<p>Absensi Masuk</p>
							</div>
							<div class="icon">
								<i class="ion ion-stats-bars"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- Absensi Keluar -->
					<div class="col-lg-3 col-6">
						<div class="small-box bg-warning">
							<div class="inner">
								<h3><?= isset($absensi_counts['Keluar']) ? $absensi_counts['Keluar'] : 0; ?></h3>
								<p>Absensi Keluar</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- Absensi Izin -->
					<div class="col-lg-3 col-6">
						<div class="small-box bg-info">
							<div class="inner">
								<h3><?= isset($absensi_counts['Izin']) ? $absensi_counts['Izin'] : 0; ?></h3>
								<p>Absensi Izin</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- Absensi Sakit -->
					<div class="col-lg-3 col-6">
						<div class="small-box bg-danger">
							<div class="inner">
								<h3><?= isset($absensi_counts['Sakit']) ? $absensi_counts['Sakit'] : 0; ?></h3>
								<p>Absensi Sakit</p>
							</div>
							<div class="icon">
								<i class="ion ion-bag"></i>
							</div>
							<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					</div>
					<!-- ./col -->
				</div>
				<!-- /.row -->
				<div class="container">
					<h1 class="text-center mb-4">Laporan Absensi</h1>

					<!-- Grafik Chart.js -->
					<div class="card">
						<div class="card-body">
							<canvas id="absensiChart" width="400" height="200"></canvas>
						</div>
					</div>
				</div>
				<?php }else{ ?>
					<!-- Row Selamat Datang -->
					<div class="row mb-4">
						<div class="col-lg-3 col-6">
							<p class="uppercase">Selamat Datang, <?= strtoupper($this->session->userdata('username')) ?></p>
						</div>
					</div>
				<?php } ?>
			</div>
			<!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script untuk Chart.js -->
<script>
	// Data dari PHP
	const absensiCounts = <?= json_encode($absensi_counts); ?>;

	const labels = Object.keys(absensiCounts);
	const data = Object.values(absensiCounts);

	const ctx = document.getElementById('absensiChart').getContext('2d');
	const absensiChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [{
				label: 'Jumlah Absensi',
				data: data,
				backgroundColor: [
					'rgba(75, 192, 192, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 99, 132, 0.2)'
				],
				borderColor: [
					'rgba(75, 192, 192, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 99, 132, 1)'
				],
				borderWidth: 1
			}]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					display: true,
					position: 'top',
				},
			},
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>

<?php $this->load->view('templates/footer') ?>
