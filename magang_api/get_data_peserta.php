<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM peserta ORDER BY id DESC");
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
  $data[] = $row;
}

echo json_encode($data);
?>
