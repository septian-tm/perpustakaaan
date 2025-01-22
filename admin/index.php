<?php
error_reporting(0);
$page = $_GET['page'];
$crd = $_GET['crd'];

include "../config/koneksi.php";
include "../config/function.php";
include "../template/adminHeader.php";

// JIKA USER ATAU BELUM LOGIN
// TIDAK BISA AKSES HALAMAN INI
if($_SESSION['user'] || empty($_SESSION)){
    header("location:../?p=account");
}


?>

<!-- html sebelumnya di template/headerPanel.php -->
<div class="content-body">
    <div class="container">
        <!-- BREADCRUMB -->
        <div class="breadcrumb">
            <?php
            if ($page == "") {
                echo 'Dashboard';
            } elseif ($page == "data-buku") {
                if ($crd == "") {
                    echo "Data Buku/";
                } elseif ($crd == "tambah-data-buku") {
                    echo "Data Buku/Tambah Data Buku";
                } elseif ($crd == "detail-buku") {
                    echo "Data Buku/Detail Buku";
                } elseif ($crd == "edit-buku") {
                    echo "Data Buku/Edit Data Buku";
                }
            } elseif ($page == "kategori") {
                echo "Data Kategori";
            } elseif ($page == "buku-dipinjam") {
                echo "Data Peminjaman Buku";
            } elseif ($page == "data-user") {
                echo "Data Users";
            }
            ?>
        </div>
        <!-- END BREADCRUMB -->
        <!-- content blank -->
        <?php
        if ($page == "") {
            include "pages/dashboard.php";
        } elseif ($page == "data-buku") {
            if ($crd == "") {
                include "pages/data-buku.php";
            } elseif ($crd == "tambah-data-buku") {
                include "pages/crud/tambah-data-buku.php";
            } elseif ($crd == "detail-buku") {
                include "pages/crud/detail-buku.php";
            } elseif ($crd == "edit-buku") {
                include "pages/crud/edit-buku.php";
            }
        } elseif ($page == "kategori") {
            if ($crd == "") {
                include "pages/data-kategori.php";
            }
        } elseif ($page == "buku-dipinjam") {
            include "pages/buku-dipinjam.php";
        } elseif ($page == "data-user") {
            include "pages/data-users.php";
        }
        ?>
    </div>
<!-- [TEMPLATE/ADMINHEADER.PHP] -->
</div>
</div>
</main>



<?php include "../template/adminFooter.php"; ?>