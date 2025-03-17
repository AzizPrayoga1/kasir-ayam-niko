<?php

$conn = mysqli_connect('localhost', 'root', '', 'kasir_tidak_aman');

date_default_timezone_set('Asia/Jakarta');
function formatrupiah($nominal){
    return "Rp " . number_format($nominal,2,',','.');
}