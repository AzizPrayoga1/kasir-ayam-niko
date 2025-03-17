
<?php
include_once 'koneksi.php';
session_start();

if (!isset($_SESSION['level'])) {
    $_SESSION['info'] = "Silahkan login terlebih dahulu!";
    header("location: login.php");
    return;
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_makanan'];
    $harga = $_POST['harga'];

    // Simpan data ke tabel siswa
    $sql_insert = "INSERT INTO produk (nama_makanan, harga) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("si", $nama, $harga);
    $stmt_insert->execute();
    $stmt_insert->close();
    $_SESSION['info'] = "Produk berhasil ditambahkan!";
    header("location: list%20menu.php");
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
                <a href="buat%20pesanan.php" >Buat Pesanan</a>
            </li>
            <li>
                <a href="tambah%20menu.php" class="active">tambah menu</a>
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
    </nav> <label for="nav_check" class="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </label>
</header>
<h1 style="margin-top: 100px;"> Tambah Menu</h1>

<div class="container">
    <form id="contact" action="" method="post">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama_makanan" name="nama_makanan"><br><br>
        <label for="Harga">Harga:</label><br>
        <input type="number" id="harga" name="harga"><br><br>
        <fieldset>
            <input name="submit" type="submit" id="contact-submit" value="submit"></input>
        </fieldset>

    </form>
</div>


</body>

</html>