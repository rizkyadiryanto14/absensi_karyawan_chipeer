<?php

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model'); // Load model Auth_model
	}

	/**
	 * Halaman login
	 */
	public function index()
	{
		$this->load->view('auth/login'); // Load view login
	}

	/**
	 * Proses login
	 */
	public function login()
	{
		// Ambil input dari form
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		// Ambil data user dari database
		$user = $this->Auth_model->get_user_by_username($username);

		if ($user) {
			// Verifikasi password
			if (password_verify($password, $user->password)) {
				// Set session jika login berhasil
				$this->session->set_userdata([
					'user_id' => $user->id,
					'username' => $user->username,
					'role' => $user->role,
					'logged_in' => true
				]);
				redirect('dashboard'); // Redirect ke halaman dashboard
			} else {
				// Password salah
				$this->session->set_flashdata('error', 'Password salah!');
			}
		} else {
			// Username tidak ditemukan
			$this->session->set_flashdata('error', 'Username tidak ditemukan!');
		}

		redirect('auth'); // Redirect kembali ke halaman login
	}

	/**
	 * Proses logout
	 */
	public function logout()
	{
		// Hapus semua session
		$this->session->unset_userdata(['user_id', 'username', 'role', 'logged_in']);
		$this->session->sess_destroy();
		redirect('auth'); // Redirect ke halaman login
	}
}
