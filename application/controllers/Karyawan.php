<?php

/**
 * @property $Karyawan_model
 * @property $session
 * @property $input
 * @property $Auth_model
 */

class Karyawan extends CI_Controller
{
	private $cipherKey = 'KUNCIENKRIPSI';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Karyawan_model');
		$this->load->model('Auth_model');
	}

	/**
	 * Menampilkan daftar karyawan
	 */
	public function index(): void
	{
		$data['karyawan'] = $this->Karyawan_model->get();
		$this->load->view('backend/karyawan/list', $data);
	}

	/**
	 * Menyimpan data karyawan dengan enkripsi
	 */
	public function simpan(): void
	{
		$postData = $this->input->post();

		// Data yang akan dienkripsi
		$data = [
			'nama'       => $this->encryptVigenere($postData['nama'], $this->cipherKey),
			'alamat'     => $this->encryptVigenere($postData['alamat'], $this->cipherKey),
			'tgl_lahir'  => $postData['tgl_lahir'],
			'jabatan'    => $this->encryptVigenere($postData['jabatan'], $this->cipherKey),
			'no_telepon' => $this->encryptVigenere($postData['no_telepon'], $this->cipherKey),
			'no_ktp'     => $this->encryptVigenere($postData['no_ktp'], $this->cipherKey),
		];


		// Simpan data ke database
		$insert = $this->Karyawan_model->simpan($data);
		if ($insert) {
			$this->session->set_flashdata('success', 'Data berhasil disimpan');
		}else {
			$this->session->set_flashdata('error', 'Data gagal disimpan');
		}
		redirect(base_url('admin/karyawan'));
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
	public function get_data_karyawan(): void
	{
		$fetch_data = $this->Karyawan_model->make_datatables();
		if (is_array($fetch_data)) {
			$data = array();
			$start = $_POST['start'];
			$no = $start + 1;
			foreach ($fetch_data as $row) {
				$sub_array = array();
				$sub_array[] = $no++;
				$sub_array[] = $this->decryptVigenere($row->nama, $this->cipherKey);
				$sub_array[] = $this->decryptVigenere($row->alamat, $this->cipherKey);
				$sub_array[] = $row->tgl_lahir;
				$sub_array[] = $this->decryptVigenere($row->jabatan, $this->cipherKey);
				$sub_array[] = $this->decryptVigenere($row->no_telepon, $this->cipherKey);
				$sub_array[] = $this->decryptVigenere($row->no_ktp, $this->cipherKey);
				$sub_array[] = '<a href="' . site_url('karyawan/verify/' . $row->id) . '" onclick="return confirm(\'Apakah anda yakin menambahkan akun ini sebagai users?\')" class="btn btn-info btn-xs "><i class="fa fa-check"></i></a>
                     <a href="' . site_url('karyawan/delete/' . $row->id) . '" onclick="return confirm(\'Apakah anda yakin?\')" class="btn btn-danger btn-xs delete"><i class="fa fa-trash"></i></a>';
				$data[] = $sub_array;
			}

			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $this->Karyawan_model->get_all_data(),
				"recordsFiltered" => $this->Karyawan_model->get_filtered_data(),
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

	public function verify($id_karyawan)
	{
		if ($id_karyawan) {
			$data_karyawan = $this->Karyawan_model->getById($id_karyawan);
			$data = [
				'username'		=> $this->decryptVigenere($data_karyawan['nama'], $this->cipherKey),
				'password'		=> $this->decryptVigenere(password_hash($data_karyawan['username'], PASSWORD_DEFAULT),$this->cipherKey),
				'role'			=> 'karyawan',
				'karyawan_id'	=> $data_karyawan['id']
			];

			$insert = $this->Auth_model->insert($data);
			if ($insert){
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
			}else{
				$this->session->set_flashdata('error', 'Data gagal disimpan');
			}
			redirect(base_url('admin/karyawan'));
		}else {
			$this->session->set_flashdata('error', 'Terdapat Kesalahan Sistem, Data Tidak Ditemukan');
		}
		redirect(base_url('admin/karyawan'));
	}

}
