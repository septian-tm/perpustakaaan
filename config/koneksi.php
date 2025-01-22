<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_perpustakaan");
if($koneksi->connect_errno){
    echo "Failed to connect to MySQL: " . $koneksi -> connect_error;
    exit();
}