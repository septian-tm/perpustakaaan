<?php
// mengambil data id dari halaman home/ketika,
// user klik button detail buku
$id = $_GET['id'];

// query untuk menampilkan data buku berdasarkan id yang dipilih
$detail = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_buku.kategori=tb_kategori.id_kategori WHERE id_buku='$id'");
$data = $detail->fetch_assoc();
// query data rekomendasi
$rekomens = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_buku.kategori=tb_kategori.id_kategori WHERE kategori='" . $data['kategori'] . "'");
?>

<!-- start detail -->
<div class="section-detail">
    <!-- cover buku -->
    <div class="card-detail">
        <img src="assets/book/<?= $data['cover']; ?>" alt="" class="img-thumbnail">
    </div>
    <!-- detail buku -->
    <div class="info-detail">
        <p><?= $data['penulis']; ?></p>
        <h2><?= $data['judul_buku']; ?></h2>
        <div class="tabs">
            <?php if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
                echo '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pinjam' . $data['id_buku'] . '" id=""> Pinjam Buku</button>';
            } else {
                echo '<button type="button" class="btn btn-primary btn-sm" id="pinjam"> Pinjam Buku</button>';
            } ?>
        </div>
        <hr>
        <!-- deskripsi buku -->
        <div class="tabs-content">
            <div class="deskripsi">
                <h5>Deskripsi Buku</h5>
                <div id="deskripsis" class="deskripsis">
                    <?= $data['deskripsi']; ?>
                </div>
            </div>
            <div id="detail" class="mt-4">
                <h5>Detail Buku</h5>
                <div class="row mt-3">
                    <div class="col">
                        <div class="mb-2">
                            <h6>Jumlah Halaman</h6>
                            <p><?= $data['jumlah_halaman']; ?></p>
                        </div>
                        <div class="mb-2">
                            <h6>Tahun Terbit</h6>
                            <p><?= $data['tahun_terbit']; ?></p>
                        </div>
                        <div class="mb-2">
                            <h6>Penerbit</h6>
                            <p><?= $data['penerbit']; ?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <h6>Nama Penulis</h6>
                            <p><?= $data['penulis']; ?></p>
                        </div>
                        <div class="mb-2">
                            <h6>Lokasi Rak</h6>
                            <p><?= $data['rak_buku']; ?></p>
                        </div>
                        <div class="mb-2">
                            <h6>Buku Tersedia</h6>
                            <p><?= $data['jumlah_buku']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal PINJAM BUKU-->
    <!-- akan active ketika user,
        klik button pinjam buku
    -->
    <?php include "pages/_modal_pinjam.php"; ?>
</div>

<!-- section rekomendasi -->
<div class="section-rekomendasi mt-5">
    <h4>Rekomendasi Untuk Anda</h4>
    <hr>
    <div class="owl-carousel owl-theme">
        <?php
        foreach ($rekomens as $rekomen) {
            echo '
                <div class="card card-home ">
                    <img src="assets/book/' . $rekomen['cover'] . '" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">' . $rekomen['penulis'] . '</p>
                        <h6 class="card-title">' . substr($rekomen['judul_buku'], 0, 40) . '</h6>
                        <a href="?p=detail&id=' . $rekomen['id_buku'] . '" class="btn btn-primary btn-sm">Pinjam Buku</a>
                    </div>
                </div>
            ';
        }
        ?>
    </div> 
</div>