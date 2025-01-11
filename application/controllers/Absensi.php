<?php

/**
 * @author  Rizky Adi Ryanto
 * @link github.com/rizkyadiryanto14
 * @property $Absensi_model
 * @property $Karyawan_model
 * @property $session
 * @property $form_validation
 * @property $input
 */

class Absensi extends CI_Controller
{
	private $cipherKey = 'KUNCIENKRIPSI';


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Absensi_model');
		$this->load->model('Karyawan_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['karyawan']		= $this->Karyawan_model->getById($this->session->userdata('user_id'));
		$this->load->view('backend/absensi/list', $data);
	}

	public function submit($id_karyawan)
	{


		if ($id_karyawan){
			$this->form_validation->set_rules('jenis_absensi', 'Jenis Absensi', 'required');
			if (!$this->form_validation->run()) {
				$this->session->set_flashdata('error', 'Harap mengisi semua field');
			}else {
				$data = [
					'karyawan_id'  => $id_karyawan,
					'jenis_absensi'=> $this->input->post('jenis_absensi'),
					'waktu_absensi' => date("Y-m-d H:i:s"),
					'keterangan'	=> $this->input->post('keterangan')
				];
				$absen = $this->Absensi_model->insert($data);

				if ($absen){
					$this->session->set_flashdata('success', 'Absensi berhasil');
				}else{
					$this->session->set_flashdata('error', 'Absensi gagal');
				}
				redirect(base_url('karyawan/absensi'));
			}
		}else{
			$this->session->set_flashdata('error', 'Kesalahan Sistem, Data tidak ditemukan');
		}
		redirect(base_url('karyawan/absensi'));
	}

	/**
	 * Fungsi untuk mengenkripsi teks menggunakan Vigenère Cipher
	 * Jangan Ubah ini ya kakak, kecuali memang mau mengubah panjang text dari proses algoritmanya
	 */
	private function encryptVigenere(string $text, string $key): string
	{
		$encryptedText = '';
		$key = strtoupper($key); // Pastikan kunci dalam huruf besar
		$keyLength = strlen($key);
		$textLength = strlen($text);

		for ($i = 0, $j = 0; $i < $textLength; $i++) {
			$char = $text[$i];

			if (ctype_alpha($char)) {
				// Proses karakter alfabet
				$isUpper = ctype_upper($char);
				$char = strtoupper($char);
				$shift = ord($key[$j % $keyLength]) - ord('A');
				$encryptedChar = chr(((ord($char) - ord('A') + $shift) % 26) + ord('A'));
				$encryptedText .= $isUpper ? $encryptedChar : strtolower($encryptedChar);
				$j++;
			} elseif (ctype_digit($char)) {
				// Proses angka
				$shift = ord($key[$j % $keyLength]) % 10;
				$encryptedChar = (string)((((int)$char) + $shift) % 10);
				$encryptedText .= $encryptedChar;
				$j++;
			} else {
				// Tetapkan karakter non-alfabet dan non-angka
				$encryptedText .= $char;
			}
		}

		return $encryptedText;
	}

	/**
	 * Menampilkan data karyawan menggunakan AJAX
	 */
	public function get_data_absensi(): void
	{
		// Mengambil role dan id_karyawan dari session
		$role = $this->session->userdata('role');
		$id_karyawan = $this->session->userdata('user_id');

		// Mengambil data absensi sesuai role dan id_karyawan
		$fetch_data = $this->Absensi_model->make_datatables($role, $id_karyawan);
		if (is_array($fetch_data)) {
			$data = array();
			$start = $_POST['start'];
			$no = $start + 1;
			foreach ($fetch_data as $row) {
				$sub_array = array();
				$sub_array[] = $no++;
				$sub_array[] = $this->decryptVigenere($row->nama_karyawan, $this->cipherKey);
				$sub_array[] = $this->decryptVigenere($row->alamat, $this->cipherKey);
				$sub_array[] = $this->decryptVigenere($row->jabatan, $this->cipherKey);
				$sub_array[] = $row->waktu_absensi;
				$sub_array[] = $row->keterangan;
				$data[] = $sub_array;
			}

			// Membuat output untuk DataTables
			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $this->Absensi_model->get_all_data($role, $id_karyawan),
				"recordsFiltered" => $this->Absensi_model->get_filtered_data($role, $id_karyawan),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			echo json_encode(["error" => "Data tidak tersedia"]);
		}
	}

	/**
	 * Fungsi untuk mendekripsi teks menggunakan Vigenère Cipher
	 */
	private function decryptVigenere(string $encryptedText, string $key): string
	{
		$decryptedText = '';
		$key = strtoupper($key);
		$keyLength = strlen($key);
		$textLength = strlen($encryptedText);

		for ($i = 0, $j = 0; $i < $textLength; $i++) {
			$char = $encryptedText[$i];

			if (ctype_alpha($char)) {
				$isUpper = ctype_upper($char);
				$char = strtoupper($char);
				$shift = ord($key[$j % $keyLength]) - ord('A');
				$decryptedChar = chr(((ord($char) - ord('A') - $shift + 26) % 26) + ord('A'));
				$decryptedText .= $isUpper ? $decryptedChar : strtolower($decryptedChar);
				$j++;
			} elseif (ctype_digit($char)) {
				$shift = ord($key[$j % $keyLength]) % 10;
				$decryptedChar = (string)((((int)$char) - $shift + 10) % 10);
				$decryptedText .= $decryptedChar;
				$j++;
			} else {
				$decryptedText .= $char;
			}
		}

		return $decryptedText;
	}
}
