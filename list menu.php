<?php
include_once 'koneksi.php';
session_start();

if (!isset($_SESSION['level'])) {
    $_SESSION['info'] = "anda belum login!";
    header("Location: login.php");
    return;
}

// Variabel untuk menyimpan pesan notifikasi


    // Ambil nama berdasarkan ID
    $sql = "SELECT nama_makanan FROM produk WHERE produk_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nama);
    $stmt->fetch();
    $stmt->close();

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
        .btn-edit {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
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
                <a href="index.php" >Home</a>
            </li>
            <li>
                <a href="buat%20pesanan.php">Buat Pesanan</a>
            </li>
            <li>
                <a href="tambah menu.php">tambah menu</a>
            </li>
            <li>
                <a href="list%20menu.php" class="active">List menu</a>
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
<h1 style="text-align: center; margin-top: 100px;">List Menu</h1>

<table>
    <tr>
        <th>No</th>
        <th>Nama Makanan</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>
    <?php

    $result = mysqli_query($conn, "SELECT * FROM produk where produk_ID");

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
                <td><?= $penjualan['nama_makanan'] ?></td>
                <td><?= $penjualan['harga'] ?></td>
                <td>
                    <a href="edit_produk.php?id=<?= $penjualan['produk_ID'] ?>" class="btn btn-edit">Edit</a>
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
