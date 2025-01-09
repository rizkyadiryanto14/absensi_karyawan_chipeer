<?php
/**
 * @property $db
 */

class Karyawan_model extends CI_Model
{
	public function get()
	{
		return $this->db->get('karyawan')->result();
	}
}
