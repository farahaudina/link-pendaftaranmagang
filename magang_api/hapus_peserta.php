<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data peserta
    $query = mysqli_query($conn, "SELECT lampiran FROM peserta WHERE id = $id");
    $row = mysqli_fetch_assoc($query);

    // Hapus file lampiran jika ada
    if ($row && $row['lampiran']) {
        $filePath = "uploads/" . $row['lampiran'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM peserta WHERE id = $id");
}

header("Location: dashboard.php");
exit;
?>
