<?php
include 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Peserta_Magang.xls");

echo "<table border='1'>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Jurusan</th>
        </tr>";

$result = mysqli_query($conn, "SELECT * FROM peserta");
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".$no++."</td>
            <td>".$row['nama']."</td>
            <td>".$row['email']."</td>
            <td>".$row['no_hp']."</td>
            <td>".$row['jurusan']."</td>
          </tr>";
}
echo "</table>";
?>
