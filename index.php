<?php
include_once 'koneksi.php';

session_start();

if (!isset($_SESSION['level'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Variabel untuk menyimpan pesan notifikasi
$notification = "";
if (isset($_POST['delete']) || isset($_POST['complete'])) {
    $id = $_POST['id'];

    // Ambil nama berdasarkan ID
    $sql = "SELECT nama FROM detail_penjualan WHERE Detail_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nama);
    $stmt->fetch();
    $stmt->close();

    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM detail_penjualan WHERE Detail_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $notification = "Data dengan Nama $nama berhasil dihapus.";
        } else {
            $notification = "Terjadi kesalahan saat menghapus data.";
        }

        $stmt->close();
    }

    if (isset($_POST['complete'])) {
        $sql = "UPDATE detail_penjualan SET status = 'Selesai' WHERE Detail_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $notification = "Pesanan dengan Nama $nama berhasil diselesaikan.";
        } else {
            $notification = "Terjadi kesalahan saat menyelesaikan pesanan.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Responsive Navbar using HTML & CSS</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-left: auto;
            margin-right: auto;
            margin-top: 100px;
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

        @media screen and (max-width: 600px) {
            table {
                border-collapse: collapse;
                width: 90%;
            }

            th {
                background-color: #4CAF50;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:nth-child(odd) {
                background-color: #f2f2f2;
            }
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 4px;
        }

        .btn-delete {
            background-color: #ff4c4c;
            color: white;
        }

        .btn-delete:hover {
            background-color: #ff1c1c;
        }

        .btn-complete {
            background-color: #4caf50;
            color: white;
        }

        .btn-complete:hover {
            background-color: #45a049;
        }

        .popup-notification {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .popup-notification.success {
            border-color: #4caf50;
        }

        .popup-notification.error {
            border-color: #ff4c4c;
        }

        .popup-notification button {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .popup-notification button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body class="container">
<?php include_once 'navbar.php' ?>
<header>
    <a href="index.php" class="logo">Kasir Tidak Aman</a>
    <input type="checkbox" id="nav_check" hidden>
    <nav>
        <ul>
            <li>
                <a href="index.php" class="active">Home</a>
            </li>
            <li>
                <a href="buat%20pesanan.php">Buat Pesanan</a>
            </li>
            <li>
                <a href="tambah menu.php">tambah menu</a>
            </li>
            <li>
                <a href="list%20menu.php">List menu</a>
            </li>
            <li>
                <a href="histori.php">histori</a>
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
<h1 style="text-align: center; margin-top: 100px;">Pesanan Hari Ini</h1>

<?php if ($notification) : ?>
    <div id="popup-notification" class="popup-notification <?= strpos($notification, 'berhasil') !== false ? 'success' : 'error' ?>">
        <p><?= $notification ?></p>
    </div>
    <script>
        function showPopup() {
            var popup = document.getElementById('popup-notification');
            popup.style.display = 'block';
            setTimeout(function() {
                popup.style.display = 'none';
            }, 2000);
        }
        showPopup();
    </script>
<?php endif; ?>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Tanggal Pemesanan</th>
        <th>Pesanan</th>
        <th>Harga Satuan</th>
        <th>Banyak</th>
        <th>Total</th>
        <th>Uang Pelanggan</th>
        <th>Kembalian</th>
        <th>Status</th>
    </tr>
    <?php
    $date = date("Y-m-d"); // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD

    $result = mysqli_query($conn, "SELECT * FROM detail_penjualan d INNER JOIN produk p ON d.produk_ID = p.produk_ID WHERE DATE(d.tanggal) = '$date' ORDER BY d.tanggal ASC");

    if (mysqli_num_rows($result) < 1) {
        ?>
        <tr>
            <td colspan="7" align="center">Tidak Ada Data</td>
        </tr>
        <?php
    } else {
        $no = 1;
        while ($penjualan = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $penjualan['nama'] ?></td>
                <td><?= $penjualan['tanggal'] ?></td>
                <td><?= $penjualan['nama_makanan'] ?></td>
                <td><?= formatrupiah($penjualan['harga']) ?></td>
                <td><?= $penjualan['jumlah_produk'] ?></td>
                <td><?= formatrupiah($penjualan['Total']) ?></td>
                <td><?= formatrupiah($penjualan['up']) ?></td>
                <td><?= formatrupiah($penjualan['up'] - $penjualan['Total']) ?></td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='id' value='<?= $penjualan['Detail_ID'] ?>'>
                        <?php if ($penjualan['status'] != 'Selesai') : ?>
                            <input type='submit' name='delete' value='Hapus' class='btn btn-delete'>
                            <input type='submit' name='complete' value='Selesai' class='btn btn-complete'>
                        <?php else : ?>
                            Selesai
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
            <?php
            $no++;
        }
    }
    ?>
</table>
</body>

</html>
