<?php
include 'koneksi.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM peserta WHERE id=$id");
}
header("Location: dashboard.php");
exit;
?>
