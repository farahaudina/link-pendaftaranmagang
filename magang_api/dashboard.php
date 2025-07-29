<?php
// koneksi database
$koneksi = new mysqli("localhost", "root", "", "db_magang");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Proses hapus jika ada ?hapus=id
$notif = '';
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $getLampiran = $koneksi->query("SELECT lampiran FROM peserta WHERE id = $id");
    if ($getLampiran && $getLampiran->num_rows > 0) {
        $row = $getLampiran->fetch_assoc();
        $filePath = "lampiran/" . $row['lampiran'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    $koneksi->query("DELETE FROM peserta WHERE id = $id");
    $notif = 'Data berhasil dihapus!';
}

// Ambil data peserta urut terbaru di atas
$sql = "SELECT * FROM peserta ORDER BY id DESC";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Data Peserta - KPPN Dumai</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
   <style>
    :root {
        --bg-main: #0b4295ff;            /* Biru muda sebagai background utama */
        --text-main: #002147;          /* Biru gelap khas Kemenkeu untuk teks */
        --bg-card: #ffffff;            /* Putih untuk kartu konten */
        --header-bg: #003366;          /* Biru tua Kemenkeu */
        --header-text: white;
        --table-head-bg: #004c99;      /* Biru tajam untuk kepala tabel */
        --table-row-alt: #f2f9ff;      /* Biru sangat muda untuk baris genap tabel */
        --footer-bg: #001f3f;          /* Biru gelap untuk footer */
    }

    body.dark-mode {
        --bg-main: #1e1e1e;
        --text-main: #eee;
        --bg-card: #2c2c2c;
        --header-bg: #111;
        --header-text: #ffc107;
        --table-head-bg: #333;
        --table-row-alt: #2a2a2a;
        --footer-bg: #000;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: var(--bg-main);
        color: var(--text-main);
        margin: 0;
        padding: 0;
    }
    .header {
        background-color: var(--header-bg);
        color: var(--header-text);
        padding: 30px 20px;
        text-align: center;
        border-bottom: 5px solid #ffc107;
    }
    .header h2 {
        margin: 0;
        font-size: 28px;
    }
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: var(--bg-card);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        padding: 12px 14px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 14px;
    }
    th {
        background-color: var(--table-head-bg);
        color: white;
    }
    tr:nth-child(even) {
        background-color: var(--table-row-alt);
    }
    tr:hover {
        background-color: #cae4ffff;
        transition: 0.2s;
    }
    a.btn {
        padding: 7px 14px;
        text-decoration: none;
        color: white;
        background-color: #d9534f;
        border-radius: 6px;
        font-size: 13px;
    }
    a.btn:hover {
        background-color: #c9302c;
    }
    a.lampiran-link {
        background-color: #28a745;
        padding: 6px 10px;
        color: white;
        border-radius: 5px;
        font-size: 13px;
        text-decoration: none;
    }
    a.lampiran-link:hover {
        background-color: #218838;
    }
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        color: white;
        font-size: 12px;
    }
    .badge.smk { background-color: #0079C2; }
    .badge.d3 { background-color: #17a2b8; }
    .badge.s1 { background-color: #6f42c1; }
    .footer {
        text-align: center;
        color: white;
        padding: 20px 0;
        font-size: 13px;
        background: var(--footer-bg);
        margin-top: 40px;
    }
    .toggle-dark {
        margin-top: 10px;
        float: right;
    }
    .notif {
        background-color: #28a745;
        color: white;
        padding: 10px 16px;
        margin-bottom: 15px;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .dt-button {
        background-color: #005bac !important;
        color: white !important;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        margin: 5px 10px 15px 0;
        font-weight: 600;
    }
    .dt-button:hover {
        background-color: #003f7f !important;
    }
</style>

</head>
<body>

    <div class="header">
        <h2>Dashboard Data Peserta Magang</h2>
        <p>KPPN Dumai - Direktorat Jenderal Perbendaharaan<br>Kementerian Keuangan Republik Indonesia</p>
        <label class="toggle-dark">
            <input type="checkbox" id="darkToggle"> Dark Mode
        </label>
    </div>

    <div class="container">
        <?php if (!empty($notif)): ?>
            <div class="notif" id="notifBox"><?php echo $notif; ?></div>
        <?php endif; ?>

        <table id="tabelData">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Siswa</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Jurusan</th>
                    <th>Asal</th>
                    <th>Jenjang</th>
                    <th>Lampiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        $badge = '';
                        if ($row['jenjang'] === 'SMK') $badge = '<span class="badge smk">SMK</span>';
                        elseif ($row['jenjang'] === 'Mahasiswa D3') $badge = '<span class="badge d3">D3</span>';
                        elseif ($row['jenjang'] === 'Mahasiswa S1') $badge = '<span class="badge s1">S1</span>';

                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['id_siswa']}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['no_hp']}</td>
                            <td>{$row['jurusan']}</td>
                            <td>{$row['asal']}</td>
                            <td>{$badge}</td>
                            <td><a class='lampiran-link' href='lampiran/{$row['lampiran']}' target='_blank'>Lihat</a></td>
                            <td><a href='#' class='btn' onclick='konfirmasiHapus({$row['id']})'>Hapus</a></td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='10'>Belum ada data peserta.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; 2025 KPPN Dumai - Direktorat Jenderal Perbendaharaan <br> Kementerian Keuangan Republik Indonesia
    </div>

    <!-- Script DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabelData').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excelHtml5', title: 'Data Peserta Magang KPPN' },
                    { extend: 'pdfHtml5', title: 'Data Peserta Magang KPPN' }
                ],
                language: {
                    search: "Cari Nama:",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ peserta",
                    infoEmpty: "Tidak ada data tersedia",
                    lengthMenu: "Tampilkan _MENU_ peserta",
                }
            });

            // Dark Mode Toggle
            const toggle = document.getElementById("darkToggle");
            const isDark = localStorage.getItem("darkMode") === "true";
            if (isDark) {
                document.body.classList.add("dark-mode");
                toggle.checked = true;
            }
            toggle.addEventListener("change", function() {
                document.body.classList.toggle("dark-mode");
                localStorage.setItem("darkMode", this.checked);
            });

            // Notif auto hide
            const notif = document.getElementById('notifBox');
            if (notif) {
                setTimeout(() => notif.style.display = 'none', 3000);
            }
        });

        function konfirmasiHapus(id) {
            if (confirm("Yakin ingin menghapus data ini?")) {
                window.location = "dashboard.php?hapus=" + id;
            }
        }
    </script>

</body>
</html>
