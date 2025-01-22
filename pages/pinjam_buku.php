<?php

if (isset($_POST['proses-pinjam'])) {
    if (prosesPinjam($_POST, $user) > 0) {
    }
}elseif(isset($_POST['batal-pinjam'])){
    if(batalPinjam($_POST) > 0){}
}

// Jika ada session pinjam atau ada buku yang dipinjam,
// maka akan menjalankan bari code 13 > 76
// jika tidak ada menjalankan baris code 79
if (isset($_SESSION['pinjam'])) { ?>
    <div class="card card-body card-pinjam-buku col-8 m-auto">
        <div class="pinjam_buku">
            <h2>Proses Peminjaman Buku</h1><hr>
            <?php
            foreach ($_SESSION['pinjam'] as $id => $jml) :
                $qry = $koneksi->query("SELECT * FROM tb_buku WHERE id_buku='$id'");
                $xx = $qry->fetch_assoc();
            ?>
                <div class="d-flex justify-content-between gap-1">
                    <img src="assets/book/<?= $xx['cover']; ?>" alt="" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#imagePrev<?= $xx['id_buku'];?>">
                    <!-- Modal -->
                    <div class="modal fade" id="imagePrev<?= $xx['id_buku'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="assets/book/<?= $xx['cover'];?>" alt="" class="img-fluid">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative align-self-center">
                        <p> <?= $xx['judul_buku']; ?> </p>
                        <p style='' class="rak-position"><i class='fa-solid fa-box-archive'></i> <?= $xx['rak_buku']; ?></p>
                    </div>
                </div>
            <?php endforeach ?>
            <table class="table mt-5">
                <tr>
                    <th>Nama</th>
                    <td class="text-capitalize">
                        <?= $user['name']; ?>
                    </td>
                </tr>
                <tr>
                    <th>Nis</th>
                    <td>
                        <?= $user['nis']; ?>
                    </td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>
                        <?= $user['no_hp']; ?>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Pengambilan Buku</th>
                    <td>
                        <!-- #nama_hari(date('l')) menampilkan nama hari
                            bahasa indonesia, fungsi tersebut dapat dilihat,
                            di folder config/function.php -->
                        <?= nama_hari(date('l', strtotime($_SESSION['date']))); ?>, <?= date('d/m/Y', strtotime($_SESSION['date'])); ?>
                    </td>
                </tr>
            </table>
            <div class="d-flex gap-2">
                <!-- 
                    maksud/fungsi 3 button di bawah
                    1. pinjam buku lain : user akan di arahkan kehalaman utama, dan memungkinkan user memilih buku lagi
                    2. proses : jika user klik button ini maka akan menjalankan fungsi prosesPinjam() *baris 3 - 5
                    3. batalkan : semua buku yang terdapat di halaman ini / didalam session akan di hapus / membatalkan peminjaman
                -->
                <a href="?p=" class="btn btn-primary btn-sm d-inline">Pinjam Buku Lain</a>
                <form action="" method="post" >
                    <button class="btn btn-success btn-sm" name="proses-pinjam">Proses</button>
                    <button class="btn btn-danger btn-sm" name="batal-pinjam">Batalkan</button>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <!-- baris code di bawah merupakan tampilkan detail peminjaman buku  -->
    <!-- $_GET['id'] pada baris code dibawah di ambil dari halaman account tab dashboard,
        atau id dari data peminjaman.-->
    <div class="alert alert-warning alert-pinjam-buku mb-1" role="alert">
        Print atau tunjukan kepada pengawas perpustakaan
    </div>
    <div class="listings-container" id="printMe">
        <div class="card card_pinjam_buku">
            <div class="card-body card-body--front">
                <?php $qry_ref = $koneksi->query("SELECT * FROM tb_peminjaman WHERE id_peminjaman='" . $_GET['id'] . "'");
                $ref = $qry_ref->fetch_assoc();
                echo "<p class='ref'>#" . $ref['code_peminjaman'] . "  |  " . date('d/m/Y', strtotime($ref['tgl_peminjaman'])) . "</p>";
                ?>

                <?php
                $no = 1;
                $sql = $koneksi->query("SELECT * FROM tb_peminjaman_buku as pb JOIN
                    tb_peminjaman as p ON p.id_peminjaman=pb.peminjaman_id JOIN
                    tb_buku as b ON b.id_buku=pb.buku_id
                    WHERE id_peminjaman='" . $_GET['id'] . "'");
                while ($listBk = $sql->fetch_assoc()) { ?>
                    <div class="head">
                        <p>
                            <?= $no++; ?>.
                        </p>
                        <div class="head-c">
                            <p><a href="?p=detail&id=<?= $listBk['id_buku']; ?>" target="_blank" class="text-black">
                                    <?= $listBk['judul_buku']; ?>
                                </a>
                            </p>
                            <p class="rak"><i class="fa-solid fa-box-archive"></i>
                                <?= $listBk['rak_buku']; ?>
                            </p>
                        </div>

                    </div>
                <?php } ?>
                <!-- end while -->
                <?php
                $sql_usr = $koneksi->query("SELECT * FROM tb_peminjaman as p JOIN tb_status as s ON s.id_status=p.status_id JOIN tb_users as u ON u.id_user=p.user_id WHERE id_peminjaman='" . $_GET['id'] . "'");
                $usr = $sql_usr->fetch_assoc();
                ?>
                <div class="statusTgl">
                    <div class="d-flex justify-content-between ">
                        <div>
                            <p>Tanggal Pengambilan</p>
                            <!-- 
                                DEFAULT STATUS ID
                                1   : Menunggu Pengambilan      2   : Dalam Peminjaman  
                                3   : Telat Dikembalikan        4   : Dikembalikan
                                5   : Expired
                            -->
                            <!-- maksud dari kode di bawah *baris 142: Jika status id 2,3 dan 4 maka akan menampilkan bagian tag p jika tidak,
                                tidak menampilkan apa2* -->
                            <?= $usr['status_id'] == in_array($usr['status_id'], [2, 3, 4]) ? '<p>Tanggal Pengembalian</p>' : ""; ?>
                            <?= $usr['status_id'] == 4 ? '<p>Dikembalikan</p>' : ""; ?>
                            <p>Status</p>
                            <?= $usr['status_id'] == 3 ? '<p>Denda</p>' : ""; ?>
                        </div>
                        <div class="text-end">
                            <p><?= date("d/m/Y", strtotime($usr['tgl_peminjaman'])); ?></p>
                            <?= $usr['status_id'] == in_array($usr['status_id'], [2, 3, 4]) ? '<p>' . date("d/m/Y", strtotime($usr['tgl_sampai'])) . '</p>' : ""; ?>
                            <?= $usr['status_id'] == 4 ? '<p>' . date("d/m/Y", strtotime($usr['tgl_kembali'])) . '</p>' : ""; ?>
                            <p><?= $usr['status_name']; ?></p>
                            <?= $usr['status_id'] == 3 ? '<p>' . $usr['telat'] . ' Hari, Rp.' . number_format($usr['denda']) . '</p>' : ""; ?>
                        </div>
                    </div>
                </div>
                <div class="sell">
                    <div class="userInfo d-flex justify-content-between ">
                        <div>
                            <p>Nama</p>
                            <p>Nis</p>
                            <p>No Hp</p>
                        </div>
                        <div class="text-end">
                            <p class="text-capitalize">
                                <?= $usr['name']; ?>
                            </p>
                            <p>
                                <?= $usr['nis']; ?>
                            </p>
                            <p>
                                <?= $usr['no_hp']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button-pinjam-buku mt-2 d-flex justify-content-center gap-1">
        <button class="btn btn-sm btn-primary" id="printArea" <?= $usr['status_id'] == 5 ? 'disabled' : '' ?>>Print</button>
        <a href="?p=account" class="btn btn-sm btn-danger">Kembali</a>
    </div>
<?php } ?>