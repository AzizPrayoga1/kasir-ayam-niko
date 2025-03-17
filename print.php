<?php
include_once 'koneksi.php';

session_start();

if (!isset($_SESSION['level'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Mendapatkan tanggal dari parameter GET
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d', strtotime('-7 days'));
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
<h1 style="text-align: center; margin-top: 20px;">Laporan Keuangan Kasir</h1>
<p style="text-align: center;">Dari Tanggal: <?= $tanggal_awal ?> Hingga Tanggal: <?= $tanggal_akhir ?></p>
<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Tanggal Pemesanan</th>
        <th>Pesanan</th>
        <th>Banyak</th>
        <th>Total</th>
        <th>Status</th>
    </tr>
    <?php
    // Mengambil data berdasarkan rentang tanggal
    $sql = "SELECT * FROM detail_penjualan d 
                INNER JOIN produk p ON d.produk_ID = p.produk_ID 
                WHERE d.tanggal BETWEEN ? AND ? 
                ORDER BY d.tanggal ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tanggal_awal, $tanggal_akhir);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        ?>
        <tr>
            <td colspan="7" align="center">Tidak Ada Data</td>
        </tr>
        <?php
    } else {
        $no = 1;
        $totalKeseluruhan = 0;
        while ($penjualan = $result->fetch_assoc()) {
            $totalKeseluruhan += $penjualan['Total'];
            ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $penjualan['nama'] ?></td>
                <td><?= $penjualan['tanggal'] ?></td>
                <td><?= $penjualan['nama_makanan'] ?></td>
                <td><?= $penjualan['jumlah_produk'] ?></td>
                <td><?= formatrupiah($penjualan['Total']) ?></td>
                <td><?= $penjualan['status'] ?></td>
            </tr>
            <?php
            $no++;
        }
        echo "<tr>
                <td colspan='5' align='right'><strong>Total Keseluruhan:</strong></td>
                <td><strong>" . formatrupiah($totalKeseluruhan) . "</strong></td>
                <td></td>
            </tr>";
    }
    ?>
</table>
</body>

</html>
