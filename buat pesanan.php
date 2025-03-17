<?php
include_once 'koneksi.php';
session_start();

if (!isset($_SESSION['level'])) {
    $_SESSION['info'] = "Silahkan login terlebih dahulu!";
    header("location: login.php");
    return;
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $produk_ID = $_POST['produk'];
    $kuantitas = $_POST['kuantitas'];
    $up = $_POST['up'];

    // Ambil harga produk dari database
    $sql_produk = "SELECT harga FROM produk WHERE produk_ID = ?";
    $stmt_produk = $conn->prepare($sql_produk);
    $stmt_produk->bind_param("i", $produk_ID);
    $stmt_produk->execute();
    $stmt_produk->bind_result($harga_produk);
    $stmt_produk->fetch();
    $stmt_produk->close();

    // Hitung total harga
    $total = $kuantitas * $harga_produk;

    // Simpan data ke tabel siswa
    $sql_insert = "INSERT INTO detail_penjualan (nama, produk_ID, jumlah_produk, total, up) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("siiii", $nama, $produk_ID, $kuantitas, $total, $up);
    if ($stmt_insert->execute()) {
        $_SESSION['info'] = "Berhasil menambahkan pesanan. Total harga: $total";
    } else {
        $_SESSION['info'] = "Gagal menambahkan pesanan.";
    }
    $stmt_insert->close();

    header("location: index.php");
    return;
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
        form {
            max-width: 300px;
            margin: 100px auto;
            padding: 10px 20px;
            border-radius: 8px;
        }

        h1 {
            margin: 0 0 30px 0;
            text-align: center;
        }

        input[type="text"],
        input[type="password"],
        input[type="date"],
        input[type="datetime"],
        input[type="email"],
        input[type="number"],
        input[type="search"],
        input[type="tel"],
        input[type="time"],
        input[type="url"],
        textarea,
        select {
            background: rgba(255,255,255,0.1);
            border: none;
            font-size: 16px;
            height: auto;
            margin: 0;
            outline: 0;
            padding: 15px;
            width: 100%;
            background-color: #e8eeef;
            color: #8a97a0;
            box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
            margin-bottom: 30px;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin: 0 4px 8px 0;
        }

        select {
            padding: 6px;
            height: 32px;
            border-radius: 2px;
        }

        button {
            padding: 19px 39px 18px 39px;
            color: #FFF;
            background-color: #4bc970;
            font-size: 18px;
            text-align: center;
            font-style: normal;
            border-radius: 5px;
            width: 100%;
            border: 1px solid #3ac162;
            border-width: 1px 1px 3px;
            box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
            margin-bottom: 10px;
        }

        fieldset {
            margin-bottom: 30px;
            border: none;
        }

        legend {
            font-size: 1.4em;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        label.light {
            font-weight: 300;
            display: inline;
        }

        .number {
            background-color: #5fcf80;
            color: #fff;
            height: 30px;
            width: 30px;
            display: inline-block;
            font-size: 0.8em;
            margin-right: 4px;
            line-height: 30px;
            text-align: center;
            text-shadow: 0 1px 0 rgba(255,255,255,0.2);
            border-radius: 100%;
        }

        @media screen and (min-width: 480px) {

            form {
                max-width: 480px;
            }

        }

        /* Mengatur gaya tombol submit */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            padding: 19px 39px 18px 39px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }</style>


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
                <a href="buat pesanan.php" class="active">Buat Pesanan</a>
            </li>
            <li>
                <a href="tambah menu.php">Tambah Menu</a>
            </li>
            <li>
                <a href="list%20menu.php" >List menu</a>
            </li>
            <li>
                <a href="histori.php">Histori</a>
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
<h1 style="margin-top: 100px;">Buat Pesanan</h1>

<div class="container">
    <form id="contact" action="buat pesanan.php" method="post">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <div class="container">
            <label for="produk">Paket:</label><br>
            <select name="produk" id="produk" required>
                <option value="id_spp" required>Pilih paket</option>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM produk");

                if (mysqli_num_rows($result) < 1) {
                    ?>
                    <option value="">Tidak ada paket</option>
                    <?php
                } else {
                    while ($paket = mysqli_fetch_assoc($result)) {
                        ?>
                        <option value="<?= $paket["produk_ID"] ?>"><?= $paket["nama_makanan"] ?></option>
                        <?php
                    }
                }
                ?>
            </select>

            <label for="kuantitas">Kuantitas:</label><br>
            <input type="number" id="kuantitas" name="kuantitas" min="1" value="1">

            <label for="kuantitas">Uang Pelanggan:</label><br>
            <input type="number" id="up" name="up" placeholder="contoh 100000">
        </div><br>

        <fieldset>
            <input name="submit" type="submit" id="contact-submit" value="Submit"></input>
        </fieldset>

    </form>
</div>
</body>

</html>
