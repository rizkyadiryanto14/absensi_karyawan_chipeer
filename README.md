# Algoritma Vigenère Cipher untuk Enkripsi dan Dekripsi

## Pendahuluan
Algoritma **Vigenère Cipher** adalah metode enkripsi teks alfabet menggunakan substitusi polialfabetik. Dalam implementasi ini, algoritma diperluas untuk mendukung enkripsi dan dekripsi data berupa huruf alfabet serta angka.

Tujuan dari algoritma ini adalah untuk melindungi data sensitif (seperti nama, alamat, atau nomor identitas) sebelum disimpan di basis data. Data akan didekripsi saat ditampilkan kepada pengguna.

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
- **Kunci** harus dirahasiakan karena digunakan untuk proses enkripsi dan dekripsi.
- Algoritma ini menjaga format data non-alfabet dan non-angka agar tetap tidak berubah.
- Pastikan input valid sebelum dilakukan enkripsi untuk menjaga integritas data.

