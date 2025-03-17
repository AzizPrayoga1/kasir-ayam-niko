<?php
include_once 'koneksi.php';

session_start();

if (!isset($_SESSION['level'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Mendapatkan tanggal hari ini dan tanggal 7 hari yang lalu sebagai default
$tanggal_awal_default = date('Y-m-d', strtotime('-7 days'));
$tanggal_akhir_default = date('Y-m-d');

// Mengambil nilai tanggal dari form atau menggunakan default jika tidak ada
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : $tanggal_awal_default;
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : $tanggal_akhir_default;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Histori Laporan</title>
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

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        label {
            margin-right: 10px;
        }

        .container>div {
            margin-right: 20px;
        }

        .container>div:last-child {
            margin-right: 0;
        }

        input[type="date"],
        input[type="submit"] {
            padding: 5px;
            font-size: 16px;
        }

        /* Mengatur gaya teks */
        label {
            font-weight: bold;
        }

        /* Mengatur gaya tombol submit */
        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            text-decoration: none;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }

            th,
            td {
                font-size: 14px;
                padding: 6px;
            }

            .container {
                flex-direction: column;
            }

            .container>div {
                margin-bottom: 10px;
            }

            .container>div:last-child {
                margin-bottom: 0;
            }
        }
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 10vh;
        }

        .btn-edit {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>

<body>
<header>
    <a href="index.php" class="logo">Kasir Tidak Aman</a>
    <input type="checkbox" id="nav_check" hidden>
    <nav>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="buat%20pesanan.php">Buat Pesanan</a>
            </li>
            <li>
                <a href="tambah menu.php">Tambah Menu</a>
            </li>
            <li>
                <a href="list%20menu.php">List Menu</a>
            </li>
            <li>
                <a href="histori.php" class="active">Histori</a>
            </li>
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <label for="nav_check" class="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </label>
</header>
<h1 style="text-align: center; margin-top: 100px;">Histori</h1>
<form action="histori.php" method="get" class="container" id="dateForm">
    <div>
        <label for="tanggal_awal">Dari Tanggal:</label><br>
        <input type="date" id="tanggal_awal" name="tanggal_awal" value="<?= $tanggal_awal ?>" onchange="document.getElementById('dateForm').submit();"><br><br>
    </div>
    <div>
        <label for="tanggal_akhir">Hingga Tanggal:</label><br>
        <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="<?= $tanggal_akhir ?>" onchange="document.getElementById('dateForm').submit();"><br><br>
    </div>
</form>
<div class = "button-container">
    <a href="print.php?tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>" target="_blank" class="btn btn-edit">Cetak Laporan</a>
</div>
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
