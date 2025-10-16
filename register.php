<?php

// Pastikan skrip ini hanya berjalan jika ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil semua data dari form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email_or_mobile = $_POST['email_or_mobile'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    // Gabungkan tanggal, bulan, dan tahun lahir menjadi format YYYY-MM-DD
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $dob = $year . "-" . $month . "-" . $day;

    // --- Bagian Koneksi dan Penyimpanan Database ---
    $servername = "localhost";
    $username = "root";
    $password_db = ""; // Kosongkan jika XAMPP Anda tidak menggunakan password
    $dbname = "facebook_clone";

    // Mengaktifkan pelaporan error sebagai exception agar bisa ditangkap oleh blok catch
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Buat koneksi ke database
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Hash password sebelum disimpan untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Siapkan statement untuk mencegah SQL Injection
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email_or_mobile, password, dob, gender) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Bind parameter ke statement
        $stmt->bind_param("ssssss", $firstname, $lastname, $email_or_mobile, $hashed_password, $dob, $gender);

        // Coba eksekusi statement
        $stmt->execute();

        // Jika berhasil, tampilkan pesan sukses
        echo "<h1>Registrasi Berhasil!</h1>";
        echo "<h2>Selamat datang, " . htmlspecialchars($firstname) . "! Akun Anda telah dibuat.</h2>";
        echo "<a href='index.html'>Kembali ke halaman utama</a>";

        // Tutup statement dan koneksi
        $stmt->close();
        $conn->close();

    } catch (mysqli_sql_exception $e) {
        // Tangkap error jika terjadi
        // Cek jika kode error adalah 1062 (artinya data duplikat)
        if ($e->getCode() == 1062) {
            echo "<h1>Registrasi Gagal!</h1>";
            echo "<p>Email atau nomor seluler yang Anda masukkan sudah terdaftar. Silakan gunakan yang lain.</p>";
            echo "<a href='index.html'>Kembali ke pendaftaran</a>";
        } else {
            // Untuk error database lainnya, tampilkan pesan error umum
            echo "<h1>Terjadi Kesalahan pada Database</h1>";
            // Baris di bawah ini bisa diaktifkan untuk debugging, tapi jangan ditampilkan ke user di production
            // echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }

} else {
    // Jika file PHP ini diakses langsung tanpa mengirim data (bukan dari form),
    // alihkan kembali ke halaman pendaftaran.
    header("Location: index.html");
    exit();
}
?>