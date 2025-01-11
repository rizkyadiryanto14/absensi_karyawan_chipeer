<?php

/**
 * @author  Rizky Adi Ryanto
 * @link github.com/rizkyadiryanto14
 * @property $db
 */

class Karyawan_model extends CI_Model
{
	/**
	 * Mengambil semua data karyawan
	 */
	public function get()
	{
		return $this->db->get('karyawan')->result();
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('karyawan');
	}

	/**
	 * @param $id
	 * Mengambil data karyawan berdasarkan id
	 * @return mixed
	 */
	public function getById($id)
	{
		return $this->db->get_where('karyawan', ['id' => $id])->row_array();
	}

	/**
	 * Menyimpan data karyawan ke database
	 */
	public function simpan(array $data): bool
	{
		return $this->db->insert('karyawan', $data);
	}

	/**
	 * Membuat query untuk datatables
	 */
	function make_query()
	{
		$this->db->select('karyawan.*')->from("karyawan");
		if (isset($_POST["search"]["value"])) {
			$this->db->like("nama", $_POST["search"]["value"]);
			$this->db->or_like("alamat", $_POST["search"]["value"]);
			$this->db->or_like("jabatan", $_POST["search"]["value"]);
		}
		if (isset($_POST["order"])) {
			$this->db->order_by($_POST['order']['0']['column'], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id', 'DESC');
		}
	}

	/**
	 * Mengambil data untuk datatables
	 */
	function make_datatables()
	{
		$this->make_query();
		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Menghitung jumlah data setelah filter
	 */
	function get_filtered_data()
	{
		$this->make_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	/**
	 * Menghitung jumlah total data
	 */
	function get_all_data()
	{
		$this->db->select("*");
		$this->db->from("karyawan");
		return $this->db->count_all_results();
	}
}
