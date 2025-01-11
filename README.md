# Algoritma Vigenère Cipher untuk Enkripsi dan Dekripsi

## Pendahuluan
Algoritma **Vigenère Cipher** adalah metode enkripsi teks alfabet menggunakan substitusi polialfabetik. Dalam implementasi ini, algoritma diperluas untuk mendukung enkripsi dan dekripsi data berupa huruf alfabet serta angka.

Tujuan dari algoritma ini adalah untuk melindungi data sensitif (seperti nama, alamat, atau nomor identitas) sebelum disimpan di basis data. Data akan didekripsi saat ditampilkan kepada pengguna.

---

---

## Tools yang Dibutuhkan

Berikut adalah daftar tools yang diperlukan untuk menjalankan project ini:

1. **Text Editor**  
   Disarankan menggunakan **Visual Studio Code (VS Code)** sebagai editor teks.  
   Unduh di: [https://code.visualstudio.com/](https://code.visualstudio.com/)

2. **XAMPP (Versi PHP 7.4)**  
   Digunakan sebagai server lokal untuk menjalankan aplikasi PHP dan MySQL.  
   Unduh di: [XAMPP 7.4.33](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/xampp-windows-x64-7.4.33-0-VC15-installer.exe/download)

3. **Composer**  
   Digunakan untuk mengelola dependensi PHP seperti CodeIgniter 3 atau library tambahan.  
   Unduh di: [https://getcomposer.org/download/](https://getcomposer.org/download/)

---

## Struktur Database

Berikut adalah struktur database:

### Tabel `karyawan`
| Kolom       | Tipe Data     | Keterangan                             |
|-------------|---------------|-----------------------------------------|
| `id`        | INT(11)       | Primary key                            |
| `nama`      | VARCHAR(255)  | Nama karyawan                          |
| `alamat`    | TEXT          | Alamat karyawan                        |
| `tgl_lahir` | DATE          | Tanggal lahir karyawan                 |
| `jabatan`   | VARCHAR(100)  | Jabatan karyawan                       |
| `no_telepon`| VARCHAR(15)   | Nomor telepon karyawan                 |
| `no_ktp`    | VARCHAR(100)  | Nomor KTP karyawan                     |

### Tabel `absensi`
| Kolom          | Tipe Data       | Keterangan                             |
|-----------------|-----------------|-----------------------------------------|
| `id`           | INT(11)         | Primary key                            |
| `karyawan_id`  | INT(11)         | Foreign key ke tabel `karyawan`        |
| `jenis_absensi`| ENUM            | Jenis absensi: `Masuk`, `Keluar`, `Izin`, `Sakit` |
| `waktu_absensi`| DATETIME        | Waktu absensi                          |
| `keterangan`   | VARCHAR(255)    | Keterangan tambahan                    |

### Tabel `users`
| Kolom          | Tipe Data       | Keterangan                             |
|-----------------|-----------------|-----------------------------------------|
| `id`           | INT(11)         | Primary key                            |
| `username`     | VARCHAR(50)     | Username login                         |
| `password`     | VARCHAR(255)    | Password login                         |
| `role`         | ENUM            | Role: `admin`, `karyawan`              |
| `karyawan_id`  | INT(11)         | Foreign key ke tabel `karyawan`        |
| `created_at`   | TIMESTAMP       | Waktu data dibuat                      |
| `updated_at`   | TIMESTAMP       | Waktu data diperbarui                  |

---


## Algoritma Enkripsi

<img src="https://github.com/rizkyadiryanto14/absensi_karyawan_chipeer/blob/main/algortima%20encrypt%20chipper.png">

### Langkah-langkah:
1. **Konversi kunci ke huruf besar**:
	- Semua huruf pada kunci diubah menjadi huruf kapital untuk konsistensi.
2. **Iterasi pada setiap karakter teks**:
	- **Karakter alfabet**:
		- Hitung nilai pergeseran menggunakan karakter pada kunci:
		  ```
		  shift = ASCII(kunci[j % panjang_kunci]) - ASCII('A')
		  ```
		- Enkripsi karakter:
		  ```
		  encryptedChar = ((ASCII(karakter_plaintext) - ASCII('A') + shift) % 26) + ASCII('A')
		  ```
		- Kembalikan huruf ke format aslinya (huruf besar/kecil).
	- **Karakter angka**:
		- Hitung nilai pergeseran menggunakan modulus:
		  ```
		  shift = ASCII(kunci[j % panjang_kunci]) % 10
		  ```
		- Enkripsi angka:
		  ```
		  encryptedChar = ((angka_plaintext + shift) % 10)
		  ```
	- **Karakter selain alfabet dan angka**:
		- Karakter ini dibiarkan tanpa perubahan.
3. Gabungkan semua karakter terenkripsi untuk membentuk teks akhir.
4. Hasil Akhir
   <img src="https://github.com/rizkyadiryanto14/absensi_karyawan_chipeer/blob/main/bentuk_data.png">

---

## Algoritma Dekripsi

<img src="https://github.com/rizkyadiryanto14/absensi_karyawan_chipeer/blob/main/algoritma%20decrypt%20chipper.png">

### Langkah-langkah:
1. **Konversi kunci ke huruf besar**:
	- Semua huruf pada kunci diubah menjadi huruf kapital untuk konsistensi.
2. **Iterasi pada setiap karakter teks terenkripsi**:
	- **Karakter alfabet**:
		- Hitung nilai pergeseran menggunakan karakter pada kunci:
		  ```
		  shift = ASCII(kunci[j % panjang_kunci]) - ASCII('A')
		  ```
		- Dekripsi karakter dengan mengurangi pergeseran:
		  ```
		  decryptedChar = ((ASCII(karakter_ciphertext) - ASCII('A') - shift + 26) % 26) + ASCII('A')
		  ```
		- Kembalikan huruf ke format aslinya (huruf besar/kecil).
	- **Karakter angka**:
		- Hitung nilai pergeseran menggunakan modulus:
		  ```
		  shift = ASCII(kunci[j % panjang_kunci]) % 10
		  ```
		- Dekripsi angka:
		  ```
		  decryptedChar = ((angka_ciphertext - shift + 10) % 10)
		  ```
	- **Karakter selain alfabet dan angka**:
		- Karakter ini dibiarkan tanpa perubahan.
3. Gabungkan semua karakter yang didekripsi untuk membentuk teks akhir.

---

## Contoh

### Diberikan:
- **Kunci**: `KUNCI`
- **Teks asli**: `Rizky123`

### Proses Enkripsi:
1. **Karakter alfabet**:
	- 'R' dienkripsi menggunakan 'K' menjadi 'B'.
	- 'i' dienkripsi menggunakan 'U' menjadi 'C'.
	- 'z' dienkripsi menggunakan 'N' menjadi 'M'.
	- 'k' dienkripsi menggunakan 'C' menjadi 'M'.
	- 'y' dienkripsi menggunakan 'I' menjadi 'G'.

2. **Karakter angka**:
	- '1' dienkripsi menggunakan 'K' menjadi '3'.
	- '2' dienkripsi menggunakan 'U' menjadi '4'.
	- '3' dienkripsi menggunakan 'N' menjadi '6'.

**Hasil Enkripsi**: `BCMMG346`

---

### Proses Dekripsi:
1. **Karakter alfabet**:
	- 'B' didekripsi menggunakan 'K' menjadi 'R'.
	- 'C' didekripsi menggunakan 'U' menjadi 'I'.
	- 'M' didekripsi menggunakan 'N' menjadi 'Z'.
	- 'M' didekripsi menggunakan 'C' menjadi 'K'.
	- 'G' didekripsi menggunakan 'I' menjadi 'Y'.

2. **Karakter angka**:
	- '3' didekripsi menggunakan 'K' menjadi '1'.
	- '4' didekripsi menggunakan 'U' menjadi '2'.
	- '6' didekripsi menggunakan 'N' menjadi '3'.

**Hasil Dekripsi**: `Rizky123`

---

## Catatan
- **Kunci** harus dirahasiakan karena digunakan untuk proses enkripsi dan dekripsi (Terdapat pada controller Karyawan).
- Algoritma ini menjaga format data non-alfabet dan non-angka agar tetap tidak berubah (Hanya menambahkan dan mengacak posisi dari data).
- Pastikan input valid sebelum dilakukan enkripsi untuk menjaga integritas data (Form Validation).

