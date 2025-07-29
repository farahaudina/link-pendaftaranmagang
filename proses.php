<?php
$koneksi = new mysqli("localhost", "root", "", "db_magang");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama       = $_POST['nama'];
    $id_siswa   = $_POST['id_siswa'];
    $email      = $_POST['email'];
    $asal       = $_POST['asal'];
    $jenjang    = $_POST['jenjang'];
    $jurusan    = $_POST['jurusan'];
    $no_hp      = $_POST['no_hp'];

    $lampiran = $_FILES['lampiran']['name'];
    $tmp = $_FILES['lampiran']['tmp_name'];
    $folder = "uploads/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $path_simpan = $folder . basename($lampiran);

    if (move_uploaded_file($tmp, $path_simpan)) {
        $sql = "INSERT INTO peserta (nama, id_siswa, email, asal, jenjang, jurusan, no_hp, lampiran)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssssssss", $nama, $id_siswa, $email, $asal, $jenjang, $jurusan, $no_hp, $lampiran);

        if ($stmt->execute()) {
            header("Location: sukses.php");
            exit();
        } else {
            echo "Gagal menyimpan data.";
        }

        $stmt->close();
    } else {
        echo "Gagal mengunggah lampiran.";
    }

    $koneksi->close();
}
?>
