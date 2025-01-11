<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="index3.html" class="brand-link">
		<img src="<?= base_url() ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Sistem Absensi</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?= base_url() ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?= $this->session->userdata('username') ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<?php if ($this->session->userdata('role') == 'admin') { ?>
				<li class="nav-item ">
					<a href="<?= base_url('dashboard') ?>" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= base_url('admin/karyawan') ?>" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Karyawan
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= base_url('karyawan/absensi') ?>" class="nav-link">
						<i class="nav-icon fas fa-book"></i>
						<p>
							Absensi
						</p>
					</a>
				</li>
				<?php }elseif ($this->session->userdata('role') == 'karyawan') { ?>
					<li class="nav-item ">
						<a href="<?= base_url('dashboard') ?>" class="nav-link">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>
								Dashboard
							</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?= base_url('karyawan/absensi') ?>" class="nav-link">
							<i class="nav-icon fas fa-book"></i>
							<p>
								Absensi
							</p>
						</a>
					</li>
				<?php } ?>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
