<?php

/**
 * @author  Rizky Adi Ryanto
 * @link github.com/rizkyadiryanto14
 *
 * @property $session
 * @property $input
 * @property $Auth_model
 */
class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
	}

	/**
	 * Halaman login
	 */
	public function index()
	{
		$this->load->view('auth/login');
	}

	/**
	 * Proses login
	 */
	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->Auth_model->get_user_by_username($username);

		if ($user) {
			if (password_verify($password, $user->password)) {
				$this->session->set_userdata([
					'user_id' => $user->karyawan_id,
					'username' => $user->username,
					'role' => $user->role,
					'logged_in' => true
				]);
				redirect(base_url('dashboard'));
			} else {
				$this->session->set_flashdata('error', 'Password salah!');
			}
		} else {
			$this->session->set_flashdata('error', 'Username tidak ditemukan!');
		}

		redirect('auth');
	}

	/**
	 * Proses logout
	 */
	public function logout()
	{
		// Hapus semua session
		$this->session->unset_userdata(['user_id', 'username', 'role', 'logged_in']);
		$this->session->sess_destroy();
		redirect('auth');
	}
}
