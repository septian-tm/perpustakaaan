<?php
error_reporting(0);
$page = $_GET['p'];

include "config/function.php";
include "template/header.php";
include "template/navbar.php";

?>

<section>
    <!-- <div class="alert alert-warning text-capitalize text-center" role="alert">
        <strong>semua data pada website ini mengambil referensi dari website gramedia</strong>
    </div> -->
    <div class="container">
        <?php
        if ($page == "") {
            include "pages/home.php";
        } elseif ($page == "view-all") {
            include "pages/viewall.php";
        } elseif($page == "kategori"){
            include "pages/kategori.php";
        }
        elseif ($page == "detail") {
            include "pages/detail.php";
        } elseif ($page == "search") {
            include "pages/search.php";
        } elseif ($page == "account") {
            include "pages/account.php";
        } elseif ($page == "pinjam-buku") {
            include "pages/pinjam_buku.php";
        }
        ?>
    </div>
</section>


<?php include "template/footer.php"; ?>
