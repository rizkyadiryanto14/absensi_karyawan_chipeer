<?php

class Auth_model extends CI_Model
{
	/**
	 * Ambil data user berdasarkan username
	 *
	 * @param string $username
	 * @return object|null
	 */
	public function get_user_by_username($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('users')->row();
	}

	/**
	 * @param $data
	 * Memasukan Data user dari karyawan kedalam tabel users
	 * @return mixed
	 */
	public function insert($data)
	{
		return $this->db->insert('users', $data);
	}
}
