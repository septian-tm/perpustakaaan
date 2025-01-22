<?php
$qry_user_register = $koneksi->query("SELECT * FROM tb_users WHERE level <> 'super_admin'");
$res_ur = $qry_user_register->num_rows;

$qry_data_buku = $koneksi->query("SELECT * FROM tb_buku");
$res_db = $qry_data_buku->num_rows;

$qry_stok_buku = $koneksi->query("SELECT SUM(jumlah_buku) as stok FROM tb_buku");
$res_sb = $qry_stok_buku->fetch_assoc();

$qry_buku_pinjam = $koneksi->query("SELECT COUNT(id_peminjaman_buku) as id_peminjaman_buku, status_id FROM tb_peminjaman_buku as pb JOIN tb_peminjaman as p ON p.id_peminjaman=pb.peminjaman_id WHERE status_id IN (2, 3)");
$res_bp = $qry_buku_pinjam->fetch_assoc();
?>



<div class="card-info">
    <div class="card">
        <h6>user register</h6>
        <p><?= $res_ur; ?> Data</p>
        <i class="fa-solid fa-users icon"></i>
    </div>
    <div class="card">
        <h6>data buku</h6>
        <p><?= $res_db; ?> Data</p>
        <i class="fa-solid fa-book icon"></i>
    </div>
    <div class="card">
        <h6>stok buku tersedia</h6>
        <p><?= $res_sb['stok']; ?> Data</p>
        <i class="fa-solid fa-swatchbook icon"></i>
    </div>
    <div class="card">
        <h6>dalam peminjaman</h6>
        <p><?= $res_bp['id_peminjaman_buku']; ?> Data</p>
        <i class="fa-regular fa-address-book icon"></i>
    </div>
</div>

<div class="row mt-4 info-chart">
    <div class="col-md-7 mb-4">
        <!-- lihat status -->
        <div class="d-flex justify-content-between">
            <label for="">Status</label>
            <a href="#" id="hide-status">Sembunyikan</a>
        </div>
        <div class="mb-3" id="lihat-status">
            <?php
            $qry_stat = $koneksi->query("SELECT * FROM tb_status");
            while ($res_stat = $qry_stat->fetch_assoc()) {
                echo '
                <form method="post" class="d-inline">
                    <div class="mb-2 d-flex gap-2">
                        ' . $res_stat['id_status'] . '.
                        <input type="text" name="status" class="form-control form-control-sm" value="' . $res_stat['status_name'] . '" autocomplete="off"> 
                        <input type="hidden" name="id-status" class="form-control form-control-sm" value="' . $res_stat['id_status'] . '" autocomplete="off"> 
                        <button type="submit" name="update-data-status" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                    </div>
                </form>
                ';
            }
            ?>
        </div>

        <!-- chart -->
        <div class="box-chart">
            <div class="my-chart-box">
                <!-- query for data chart -->
                <?php
                $qry1 = $koneksi->query("SELECT * FROM tb_status WHERE id_status IN (1,2,3)");
                while ($res1 = $qry1->fetch_assoc()) {
                    $dataSts[] = $res1['status_name'];

                    $qry2 = $koneksi->query("SELECT * FROM tb_peminjaman as p JOIN tb_status as s ON p.status_id=s.id_status WHERE status_id='" . $res1['id_status'] . "'");
                    $res2 = $qry2->num_rows;
                    $jmlData[] = $res2;
                }
                echo '
                    <p id="label" class="d-none">' . json_encode($dataSts) . '</p>
                    <p id="forChart" class="d-none">' . json_encode($jmlData) . '</p>';
                ?>
                <canvas id="myChart" class="myChart"></canvas>
            </div>
        </div>
        <!-- end chart -->
    </div>


    <!-- buku dalam peminjaman -->
    <div class="col mb-4">
        <div class="card">
            <div class="card-header">Buku Dalam Peminjaman</div>
            <div class="card-body">
                <?php
                $qry_bdp = $koneksi->query("SELECT b.judul_buku, b.cover, p.tgl_peminjaman, p.status_id, p.code_peminjaman
                FROM tb_peminjaman_buku as pb 
                JOIN tb_peminjaman as p ON p.id_peminjaman=pb.peminjaman_id 
                JOIN tb_buku as b ON b.id_buku=pb.buku_id 
                WHERE p.status_id IN (2, 3) LIMIT 6");
                $res_bdp = $qry_bdp->num_rows;
                if ($res_bdp > 0) {
                    while ($res_bdp = $qry_bdp->fetch_assoc()) { ?>
                        <div class="d-flex gap-1 mb-2">
                            <img src="../assets/book/<?= $res_bdp['cover']; ?>" alt="" style="width:40px">
                            <div >
                                <h6 class="title"><?= $res_bdp['judul_buku']; ?></h6>
                                <small class="tgl">
                                    <?= date('d/m/Y', strtotime($res_bdp['tgl_peminjaman'])); ?> -
                                    <?= date('d/m/Y', strtotime('+7 day', strtotime($res_bdp['tgl_peminjaman']))); ?>
                                    [<a href=''>#<?= $res_bdp['code_peminjaman']; ?></a>]
                                </small>
                            </div>
                        </div>
                <?php }
                } else {
                    echo "<div class='text-center'>Tidak Ada Data</div>";
                }
                ?>
            </div>
            <div class="card-footer">
                <a href="?page=buku-dipinjam" class="text-center">Lihat Semua</a>
            </div>
        </div>
    </div>
</div>