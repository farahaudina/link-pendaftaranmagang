<?php
// Koneksi database InfinityFree
$host = "sqlXXX.epizy.com"; // Ganti XXX dengan angka server dari InfinityFree
$user = "epiz_12345678";    // Ganti dengan username hosting kamu
$pass = "passwordkamu";     // Ganti dengan password database kamu
$db   = "epiz_12345678_db_magang"; // Ganti nama databasenya

$koneksi = new mysqli($host, $user, $pass, $db);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data peserta
$sql = "SELECT * FROM peserta";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Peserta Magang KPPN</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f1f1f1;
        }
        h2 {
            text-align: center;
            color: #004085;
        }
        table {
            width: 80%;
            margin: auto;
            background: white;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<h2>Data Peserta Magang KPPN Dumai</h2>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Asal</th>
        <th>Jenjang</th>
        <th>Lampiran</th>
    </tr>
    <?php
    $no = 1;
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$row['nama']."</td>
                    <td>".$row['asal']."</td>
                    <td>".$row['jenjang']."</td>
                    <td><a href='lampiran/".$row['lampiran']."' target='_blank'>Lihat</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Belum ada data peserta.</td></tr>";
    }
    ?>
</table>

</body>
</html>
