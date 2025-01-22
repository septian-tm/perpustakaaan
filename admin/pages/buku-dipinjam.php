<?php
if (isset($_POST['updateStatus'])) {
    if (updateStatusPeminjaman($_POST) > 0) {
        $icon = 'success';
        $title = 'Sukses';
        $text = 'Status Peminjaman Berhasil Diubah';
        $location = '';
        alert($icon, $title, $text, $location);
    }
}
?>

<div class="table-responsive">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Code Peminjaman</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $qry_pinjam = $koneksi->query("SELECT * FROM tb_peminjaman as p JOIN tb_users as b ON p.user_id=b.id_user JOIN tb_status as s ON s.id_status=p.status_id WHERE p.is_deleted != 1 ORDER BY id_peminjaman DESC");
            while ($res_pinjam = $qry_pinjam->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?= $no++; ?>
                    </td>
                    <td>#<?= $res_pinjam['code_peminjaman']; ?>
                    </td>
                    <td>
                        <?= $res_pinjam['name']; ?>
                    </td>
                    <td>
                        <?= date('d/m/Y', strtotime($res_pinjam['tgl_peminjaman'])) ?>
                    </td>
                    <td>
                        <?php
                        if ($res_pinjam['status_id'] == 1) {
                            echo '<span class="badge text-bg-warning">' . $res_pinjam['status_name'] . '</span>';
                        } elseif ($res_pinjam['status_id'] == 2) {
                            echo '<span class="badge text-bg-primary">' . $res_pinjam['status_name'] . '</span>';
                        } elseif ($res_pinjam['status_id'] == in_array($res_pinjam['status_id'], [3, 5])) {
                            echo '<span class="badge text-bg-danger">' . $res_pinjam['status_name'] . '</span>';
                        } else {
                            echo '<span class="badge text-bg-success">' . $res_pinjam['status_name'] . '</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#prosesPinjam<?= $res_pinjam['id_peminjaman']; ?>"><i class="fa-solid fa-info"></i></button>
                        <?php
                        if ($res_pinjam['status_id'] == 5) {
                            echo "<button class='btn btn-danger btn-sm' id='delete' data-peminjaman='" . $res_pinjam['id_peminjaman'] . "'><i class='fa-solid fa-trash'></i></button>";
                        }
                        ?>
                    </td>
                </tr>
    
    
                <!-- Modal -->
                <div class="modal fade" id="prosesPinjam<?= $res_pinjam['id_peminjaman']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">#<?= $res_pinjam['code_peminjaman']; ?> | <?= date('d/m/Y', strtotime($res_pinjam['tgl_peminjaman'])); ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php $qry_proses = $koneksi->query("SELECT * FROM tb_peminjaman as p JOIN tb_peminjaman_buku as pb ON pb.peminjaman_id=p.id_peminjaman JOIN tb_buku as b ON b.id_buku=pb.buku_id WHERE id_peminjaman='" . $res_pinjam['id_peminjaman'] . "'");
                                while ($resFrch = $qry_proses->fetch_assoc()) {
                                    echo "
                                    <div class='d-flex justify-content-between mb-2'>
                                        <img src='../assets/book/" . $resFrch['cover'] . "' alt='' style='width:40px; height:60px'>
                                        <div>
                                            <p>" . $resFrch['judul_buku'] . "</p>
                                            <p style='float:right;margin-top:-15px'><i class='fa-solid fa-box-archive'></i> " . $resFrch['rak_buku'] . "</p>
                                        </div>
                                    </div>
                                ";
                                } ?>
                                <hr>
                                <div class="d-flex justify-content-between ">
                                    <div>
                                        <p>Tanggal Pengambilan</p>
                                        <?= $res_pinjam['status_id'] == in_array($res_pinjam['status_id'], [2, 3, 4]) ? '<p>Tanggal Pengembalian</p>' : ""; ?>
                                        <p>Status</p>
                                        <?= $res_pinjam['status_id'] == 3 ? '<p>Denda</p>' : ""; ?>
                                    </div>
                                    <div class="text-end">
                                        <p><?= date('d/m/Y', strtotime($res_pinjam['tgl_peminjaman'])); ?></p>
                                        <?= $res_pinjam['status_id'] == in_array($res_pinjam['status_id'], [2, 3, 4]) ? '<p>' . date('d/m/Y', strtotime($res_pinjam['tgl_sampai'])) . '</p>' : ""; ?>
                                        <p><?= $res_pinjam['status_name']; ?></p>
                                        <?= $res_pinjam['status_id'] == 3 ? '<p>' . $res_pinjam['telat'] . ' Hari, Rp.' . number_format($res_pinjam['denda']) . '</p>' : ""; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>Code Peminjaman</p>
                                        <p>Nama</p>
                                        <p>NIS</p>
                                        <p>No Telepon</p>
                                    </div>
                                    <div class="text-end">
                                        <p>#<?= $res_pinjam['code_peminjaman']; ?>
                                        </p>
                                        <p>
                                            <?= $res_pinjam['name']; ?>
                                        </p>
                                        <p>
                                            <?= $res_pinjam['nis']; ?>
                                        </p>
                                        <p>
                                            <?= $res_pinjam['no_hp']; ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <form action="" method="post">
                                    <label for="">Update Status</label>
                                    <input type="hidden" value="<?= $res_pinjam['id_peminjaman']; ?>" name="id_pinjam">
                                    <select name="status" class="form-control" required <?= in_array($res_pinjam['status_id'], [4,5])? 'disabled' : ''; ?>>
                                        <option value="">-Pilih Status-</option>
                                        <?php
                                        $qry_status = $koneksi->query("SELECT * FROM tb_status WHERE id_status != 1");
                                        while ($res_stat = $qry_status->fetch_assoc()) {
                                            echo "<option value='" . $res_stat['id_status'] . "'";
                                            if ($res_pinjam['status_id'] == $res_stat['id_status']) {
                                                echo "selected";
                                            }
                                            echo ">" . $res_stat['status_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="updateStatus" <?= in_array($res_pinjam['status_id'], [4,5]) ? 'disabled' : ''; ?>>Proses</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </tbody>
    </table>
</div>