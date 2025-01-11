<?php

/**
 * @author  Rizky Adi Ryanto
 * @link github.com/rizkyadiryanto14
 *
 * @property $Karyawan_model
 * @property $Absensi_model
 */

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Karyawan_model');
		$this->load->model('Absensi_model');
	}

	public function index()
	{
		$data['karyawan_total']	= $this->Karyawan_model->get_all_data();
		$data['absensi_counts']	= $this->Absensi_model->get_count_per_jenis();
		$this->load->view('backend/dashboard', $data);
	}
}
