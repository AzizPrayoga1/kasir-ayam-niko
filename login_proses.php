<?php
include_once 'koneksi.php';
session_start();

if (isset($_SESSION['level'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    $stmt = $conn->prepare("SELECT user_id, username, password, level FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $username, $hashed_password, $level);
        $stmt->fetch();

        session_regenerate_id(true);
        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $level;
        $_SESSION['info'] = "Berhasil login!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['info'] = "Username atau password salah!";
        header("Location: login.php");
        exit;
    }
    $stmt->close();
}
?>
