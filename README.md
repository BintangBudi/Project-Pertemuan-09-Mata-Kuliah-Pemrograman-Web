
# Project-Pertemuan-09-Mata-Kuliah-Pemrograman-Web

### Proyek Kloning Halaman Registrasi Facebook
#### Nama Anggota Kelompok :
* Bintang Budi Pangestu (D1041221046)
* Dwiki Pratika Admaja (D1041221014)

-   **Frontend**: Dikerjakan menggunakan **HTML, CSS, dan JavaScript** untuk membangun antarmuka pengguna (UI) yang mirip dengan aslinya.
-   **Backend**: Dikerjakan menggunakan **PHP** untuk memproses data formulir, melakukan validasi, dan menyimpannya ke database.

---

## 📜 Aturan Validasi dan Alur Kerja

Berikut adalah rincian aturan validasi yang diterapkan pada Halaman Registrasi

### Validasi Frontend (JavaScript) 🖥️

Validasi ini terjadi langsung di browser pengguna untuk memberikan feedback secara cepat. Kode ini berfokus pada dua hal:

* **Input Wajib Diisi**: Semua kolom yang memiliki atribut `required` di HTML akan diperiksa. Jika ada yang kosong saat tombol "Sign Up" ditekan, `border` kolom tersebut akan berubah menjadi **merah** dan sebuah `alert` akan muncul.
* **Panjang Password**: Password yang dimasukkan harus memiliki panjang **minimal 6 karakter**. Jika kurang, sebuah `alert` akan memperingatkan pengguna dan `border` kolom password akan menjadi merah.

---

### Pemrosesan Backend (PHP) 🛡️

Backend tidak melakukan validasi data secara eksplisit (seperti mengecek `if empty()`), melainkan langsung mencoba memasukkan data ke database. Penanganan error terjadi berdasarkan hasil dari proses tersebut.

* **Keamanan Password**: Sebelum disimpan ke database, password pengguna akan diubah menjadi kode acak (di-hash) menggunakan fungsi `password_hash()`. Ini adalah langkah keamanan krusial agar password asli tidak tersimpan.
* **Pencegahan SQL Injection**: Kode menggunakan *Prepared Statements* (`prepare()` dan `bind_param()`) untuk memasukkan data. Ini adalah praktik terbaik untuk mencegah peretasan melalui metode SQL Injection.
* **Penanganan Email/Ponsel Duplikat**: Validasi untuk email atau nomor ponsel yang sudah terdaftar tidak diperiksa di awal. Sebaliknya, kode mencoba menyimpan data dan akan **menangkap error** dari database jika gagal. Jika kode error adalah `1062` (data duplikat), barulah sistem menampilkan pesan bahwa email/ponsel sudah terdaftar.

---

### Alur Setelah Submit ➡️

1.  Saat pengguna menekan "Sign Up", **JavaScript** akan melakukan validasi pertama (mengecek input kosong dan panjang password). Jika gagal, proses berhenti dan pengguna diberi tahu melalui `alert`.
2.  Jika validasi JavaScript lolos, data formulir dikirim ke server (**`register.php`**).
3.  **PHP** langsung mencoba menyimpan data ke database.
4.  Jika terjadi error karena **email/ponsel sudah ada**, halaman akan menampilkan pesan error spesifik mengenai data duplikat.
5.  Jika data berhasil disimpan tanpa error, pengguna akan melihat **halaman baru** dengan pesan "Registrasi Berhasil!".

## ✅ Cara Menjalankan Proyek Secara Keseluruhan

1.  Pastikan **Apache** dan **MySQL** berjalan di XAMPP.
2.  Buka browser dan akses `http://localhost/phpmyadmin/`.
3.  Buat database baru. Klik **New** di sidebar kiri, beri nama database `facebook_clone`, dan klik **Create**.
3.  Setelah database dibuat, klik tab **SQL** dan jalankan query berikut untuk membuat tabel `users`:

    ```sql
    CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `firstname` varchar(50) NOT NULL,
      `lastname` varchar(50) NOT NULL,
      `email_or_mobile` varchar(100) NOT NULL,
      `password` varchar(255) NOT NULL,
      `dob` date NOT NULL,
      `gender` enum('female','male','custom') NOT NULL,
      `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`),
      UNIQUE KEY `email_or_mobile` (`email_or_mobile`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

    Tabel ini akan menyimpan semua informasi yang dikirim dari formulir. Perhatikan bahwa `password` akan disimpan sebagai `varchar(255)` karena kita akan **meng-hash password** sebelum menyimpannya.
4.  Salin semua file proyek (`index.html`, `style.css`, `script.js`, `register.php`) ke dalam folder `htdocs` di direktori instalasi XAMPP.
    -   Contoh lokasi di Windows: `C:\xampp\htdocs\nama-folder-proyek\`
5.  Buka browser dan akses URL: `http://localhost/nama-folder-proyek/`
6.  Halaman registrasi akan muncul. Coba isi formulir dan klik "Sign Up".
7.  Jika berhasil, Anda akan melihat pesan sukses. Jika gagal, pesan error akan ditampilkan.
8.  Periksa tabel `users` di **phpMyAdmin** untuk memastikan data baru telah tersimpan dengan benar (dan password sudah di-hash!).
