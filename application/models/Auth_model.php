<?php

/**
 * @author  Rizky Adi Ryanto
 * @link github.com/rizkyadiryanto14
 *
 * @property $db
 */

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

	public function getByKaryawanId($id)
	{
		return $this->db->get_where('users', ['karyawan_id' => $id])->row();
	}

	public function getByKaryawanIdArray($karyawan_id)
	{
		$this->db->where('karyawan_id', $karyawan_id);
		$query = $this->db->get('users');
		return $query->row_array();
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
