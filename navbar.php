<?php
if (isset($_SESSION['info'])) {
    ?>
    <script>
        alert('<?= $_SESSION['info'] ?>')
    </script>
    <?php
    unset($_SESSION['info']);
}
$baseurl = "http://localhost/kasir/";
?>