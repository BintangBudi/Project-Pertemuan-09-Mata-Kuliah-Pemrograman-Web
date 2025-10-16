# Project-Pertemuan-09-Mata-Kuliah-Pemrograman-Web
Tugas Project Project Pertemuan 09 Mata Kuliah Pemrograman Web

# Proyek Kloning Halaman Registrasi Facebook

Proyek ini adalah rekreasi fungsional dari halaman registrasi Facebook. Tujuannya adalah untuk mempraktikkan pengembangan web full-stack dengan memisahkan tugas frontend dan backend.

-   **Frontend**: Dikerjakan menggunakan **HTML, CSS, dan JavaScript** untuk membangun antarmuka pengguna (UI) yang mirip dengan aslinya.
-   **Backend**: Dikerjakan menggunakan **PHP** untuk memproses data formulir, melakukan validasi, dan menyimpannya ke database.

## 🗂️ Struktur File

```
.
├── index.html       // File utama untuk struktur halaman (Frontend)
├── style.css        // File untuk styling halaman (Frontend)
├── script.js        // File untuk fungsionalitas di sisi klien (Frontend)
└── register.php     // File untuk memproses data di sisi server (Backend)
```

---

## 🚀 Tugas Backend Developer

Tugas Anda adalah membuat bagian backend berfungsi. Frontend sudah dibuat dan akan mengirimkan data formulir ke file `register.php` menggunakan metode `POST`. Anda perlu menyiapkan server, database, dan skrip PHP untuk menangani data tersebut.

### Langkah 1: Siapkan Lingkungan Pengembangan Lokal

Anda memerlukan server lokal untuk menjalankan PHP dan database. Pilihan paling umum adalah **XAMPP** atau **WAMP**.

1.  **Unduh dan instal XAMPP** dari [situs resminya](https://www.apachefriends.org/index.html).
2.  Jalankan XAMPP Control Panel dan **nyalakan (Start) modul Apache dan MySQL**.
    ![XAMPP Control Panel](https://i.imgur.com/KplA35G.png)

### Langkah 2: Buat Database dan Tabel

Backend akan menyimpan data pendaftaran pengguna ke dalam database MySQL.

1.  Buka browser dan akses `http://localhost/phpmyadmin/`.
2.  Buat database baru. Klik **New** di sidebar kiri, beri nama database `facebook_clone`, dan klik **Create**.
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

### Langkah 3: Modifikasi `register.php` untuk Terhubung ke Database

File `register.php` yang sudah ada berisi logika dasar untuk menerima data. Tugas Anda adalah mengaktifkan bagian koneksi database di dalamnya.

1.  **Buka file `register.php`**.
2.  Cari bagian yang ditandai sebagai `// --- Simulasi Penyimpanan ke Database ---`.
3.  **Hapus komentar** pada kode koneksi database dan **sesuaikan kredensialnya** jika perlu (biasanya, username default XAMPP adalah `root` tanpa password).
4.  Pastikan logika untuk **menghash password** menggunakan `password_hash()` sudah aktif. Ini sangat penting untuk keamanan!

    **Contoh Kode yang Perlu Diaktifkan di `register.php`:**
    ```php
    // Ganti bagian kode yang hanya menampilkan data
    // dengan kode koneksi dan penyimpanan database berikut:
    
    $servername = "localhost";
    $username = "root";
    $password_db = ""; // Kosongkan jika tidak ada password
    $dbname = "facebook_clone";

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash password sebelum disimpan untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Siapkan statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email_or_mobile, password, dob, gender) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $email_or_mobile, $hashed_password, $dob, $gender);

    if ($stmt->execute()) {
        echo "<h1>Registrasi Berhasil!</h1>";
        echo "<h2>Selamat datang, " . htmlspecialchars($firstname) . "! Akun Anda telah dibuat.</h2>";
    } else {
        // Cek jika error karena email/nomor hp duplikat (Error code 1062)
        if ($conn->errno == 1062) {
            echo "<h1>Error!</h1>";
            echo "<p>Email atau nomor seluler ini sudah terdaftar. Silakan gunakan yang lain.</p>";
            echo "<a href='index.html'>Kembali ke pendaftaran</a>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
    ```
    > **Catatan Keamanan:** Menggunakan `prepared statements` (`prepare` dan `bind_param`) sangat penting untuk mencegah serangan SQL Injection.

---

## ✅ Cara Menjalankan Proyek Secara Keseluruhan

1.  Pastikan **Apache** dan **MySQL** berjalan di XAMPP.
2.  Salin semua file proyek (`index.html`, `style.css`, `script.js`, `register.php`) ke dalam folder `htdocs` di direktori instalasi XAMPP Anda.
    -   Contoh lokasi di Windows: `C:\xampp\htdocs\nama-folder-proyek\`
3.  Buka browser Anda dan akses URL: `http://localhost/nama-folder-proyek/`
4.  Halaman registrasi akan muncul. Coba isi formulir dan klik "Sign Up".
5.  Jika berhasil, Anda akan melihat pesan sukses. Jika gagal, pesan error akan ditampilkan.
6.  Periksa tabel `users` di **phpMyAdmin** untuk memastikan data baru telah tersimpan dengan benar (dan password sudah di-hash!).

Jika ada pertanyaan, jangan ragu untuk bertanya! Selamat mengerjakan! 👍
