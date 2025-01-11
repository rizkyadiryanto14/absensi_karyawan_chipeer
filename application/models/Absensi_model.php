<?php

/**
 * @author  Rizky Adi Ryanto
 * @link github.com/rizkyadiryanto14
 *
 * @property $db
 */

class Absensi_model extends CI_Model
{

	public function insert($data)
	{
		return $this->db->insert('absensi', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('absensi');
	}

	public function get_count_per_jenis() {
		$jenis_absensi = ['Masuk', 'Keluar', 'Izin', 'Sakit'];

		$result = [];
		foreach ($jenis_absensi as $jenis) {
			$this->db->where('jenis_absensi', $jenis);
			$this->db->from('absensi');
			$count = $this->db->count_all_results();
			$result[$jenis] = $count;
		}

		return $result;
	}

	/**
	 * Membuat query untuk datatables
	 */
	function make_query($role, $id_karyawan = null)
	{
		$this->db->select('absensi.*, karyawan.nama as nama_karyawan, karyawan.alamat as alamat, karyawan.jabatan as jabatan')
			->from("absensi")
			->join("karyawan", "karyawan.id = absensi.karyawan_id");

		// Filter data berdasarkan role
		if ($role === 'karyawan' && $id_karyawan !== null) {
			$this->db->where('absensi.karyawan_id', $id_karyawan);
		}

		// Filter pencarian
		if (isset($_POST["search"]["value"])) {
			$this->db->group_start(); // Mulai grup kondisi OR
			$this->db->like("karyawan.nama", $_POST["search"]["value"]);
			$this->db->or_like("karyawan.alamat", $_POST["search"]["value"]);
			$this->db->or_like("karyawan.jabatan", $_POST["search"]["value"]);
			$this->db->group_end();
		}

		// Urutkan data
		if (isset($_POST["order"])) {
			$this->db->order_by($_POST['order']['0']['column'], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id', 'DESC');
		}
	}


	/**
	 * Mengambil data untuk datatables
	 */
	function make_datatables($role, $id_karyawan = null)
	{
		$this->make_query($role, $id_karyawan);
		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Menghitung jumlah data setelah filter
	 */
	function get_filtered_data($role, $id_karyawan = null)
	{
		$this->make_query($role, $id_karyawan);
		$query = $this->db->get();
		return $query->num_rows();
	}


	/**
	 * Menghitung jumlah total data
	 */
	function get_all_data()
	{
		$this->db->select("*");
		$this->db->from("absensi");
		return $this->db->count_all_results();
	}
}
