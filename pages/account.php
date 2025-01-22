<?php
// kondisi dimana jika ada button name ubah-user
// akan menjalakan baris kode di bawah
// untuk mengubah detail user
if (isset($_POST['ubah-user'])) {
    $username = $_POST['username'];
    $id = $_SESSION['user']['id_user'];

    // query untuk mengecek apakah username sudah terdaftar
    $qey_user = $koneksi->query("SELECT * FROM tb_users WHERE username='$username' AND id_user!='$id'");
    $check = $qey_user->num_rows;

    // jika username sudah terdaftar
    // akan muncul notif error,
    // jika belum, akan menjalankan function updateUser(*config/function*)
    if($check > 0){
        $icon = "error";
        $title = "Opps...";
        $text = "Username Sudah Digunakan!";
        $location = "";
        alert($icon, $title, $text, $location);
    }elseif (updateUser($_POST) > 0) {
    }
}


// mengecek apakah yang login,
// user atau admin,
// jika kedua diatas, maka akan menampilkan baris code 31 > 163
// jika super admin yang login, maka akan menjalankan baris code 165,
// dan jika belum login, maka akan menjalankan baris code 167
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) { ?>
    <ul class="nav justify-content-center">
        <li class="nav-item nav-tabs">
            <button class="nav-link active" id="buku-tab" data-bs-toggle="tab" data-bs-target="#buku-tab-pane" type="button" role="tab" aria-controls="buku-tab-pane" aria-selected="true">Dashboard</button>
        </li>
        <li class="nav-item nav-tabs">
            <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-tab-pane" type="button" role="tab" aria-controls="detail-tab-pane" aria-selected="false">Detail Akun</button>
        </li>
        <li class="nav-item nav-tabs">
            <?php
            if (isset($_SESSION['admin'])) {
                echo '<a href="admin/" class="nav-link">Dashboard Admin</a>';
            } else {
                echo '<a href="auth/keluar.php" class="nav-link">Keluar</a>';
            }
            ?>
        </li>
    </ul>
    <div class="tab-content">
        <!-- tab pane dashboard/peminjaman buku -->
        <div class="tab-pane fade show active" id="buku-tab-pane" role="tabpanel" aria-labelledby="buku-tab" tabindex="0">
            <div class="table-responsive py-5">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Code Peminjaman</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $idU = $_SESSION["user"]["id_user"];
                        $idA = $_SESSION["admin"]["id_user"];
                        $sql = $koneksi->query("SELECT DISTINCT p.user_id, p.id_peminjaman, pb.peminjaman_id, u.id_user, p.tgl_peminjaman, p.code_peminjaman, s.status_name, p.status_id FROM 
                        tb_peminjaman as p JOIN
                        tb_status as s ON s.id_status=p.status_id JOIN
                        tb_peminjaman_buku as pb ON p.id_peminjaman=pb.peminjaman_id JOIN
                        tb_users as u ON u.id_user=p.user_id
                        WHERE (p.user_id='$idU' OR p.user_id='$idA') ORDER BY id_peminjaman DESC");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>#<?= $data['code_peminjaman']; ?></td>
                                <td><?= date('d/m/Y', strtotime($data['tgl_peminjaman'])); ?></td>
                                <td><?php
                                    if ($data['status_id'] == 5 || $data['status_name'] == 'Expired') {
                                        echo "<span class='text-danger'>" . $data['status_name'] . "</span>";
                                    } else {
                                        echo $data['status_name'];
                                    }; ?>
                                </td>
                                <td><a href="?p=pinjam-buku&id=<?= $data['id_peminjaman']; ?>" class="btn btn-sm btn-primary">Detail</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- tab pane account detail/update  -->
        <div class="tab-pane fade" id="detail-tab-pane" role="tabpanel" aria-labelledby="detail-tab" tabindex="0">
            <form action="" method="post">
                <?php
                $idU = $_SESSION["user"]["id_user"];
                $idA = $_SESSION["admin"]["id_user"];
                $qry_detail_user = $koneksi->query("SELECT * FROM tb_users WHERE (id_user='$idU' OR id_user='$idA')");
                $res_du = $qry_detail_user->fetch_assoc();
                ?>
                <div class="row mt-4">
                    <div class="col">
                        <h5>Detail Akun</h5>
                        <div class="input-box ">
                            <input type="hidden" value="<?= $res_du['id_user']; ?>" name="id">
                            <input type="text" id="registerName" placeholder=" " class="form-control" name="nama" value="<?= $res_du['name']; ?>" readonly />
                            <label class="form-label" for="registerName">Name</label>
                        </div>
                        <div class="input-box ">
                            <input type="text" id="nis" placeholder=" " class="form-control" name="nis" value="<?= $res_du['nis']; ?>" readonly />
                            <label class="form-label" for="nis">Nis</label>
                        </div>
                        <div class="input-box ">
                            <input type="text" id="Username" placeholder=" " class="form-control" name="username" value="<?= $res_du['username']; ?>" />
                            <label class="form-label" for="Username">Username</label>
                        </div>
                        <div class="input-box mb-4">
                            <select name="jk" id="jk" class="form-control" required>
                                <option value="">-Pilih-</option>
                                <option value="Laki-laki" <?= $res_du['jk'] == "Laki-laki" ? 'selected' : ''; ?>>L</option>
                                <option value="Perempuan" <?= $res_du['jk'] == "Perempuan" ? 'selected' : ''; ?>>P</option>
                            </select>
                            <label class="form-label" for="jk">Jenis Kelamin</label>
                        </div>
                        <div class="input-box mb-4">
                            <input type="date" id="tgl" placeholder=" " class="form-control" name="tgl" value="<?= $res_du['tgl_lahir']; ?>" />
                            <label class="form-label" for="tgl">Tanggal Lahir</label>
                        </div>
                        <div class="input-box mb-4">
                            <input type="number" id="hp" placeholder=" " class="form-control" name="nohp" value="<?= $res_du['no_hp']; ?>" />
                            <label class="form-label" for="hp">No Hp</label>
                        </div>
                        <div class="input-box mb-4">
                            <textarea id="alamat" placeholder=" " class="form-control" rows="3" name="alamat"><?= $res_du['alamat']; ?></textarea>
                            <label class="form-label" for="alamat">Alamat</label>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h5>Ganti Password</h5>
                        <div class="input-box mb-4">
                            <input type="password" id="pl" placeholder=" " class="form-control password-input" name="pl" />
                            <label class="form-label" for="pl">Password Lama</label>
                        </div>
                        <div class="input-box mb-4">
                            <input type="password" id="ads" placeholder=" " class="form-control password-input" name="pb" />
                            <label class="form-label" for="ads">Password Baru</label>
                        </div>
                        <div class="input-box mb-4">
                            <input type="password" id="pw2" placeholder=" " class="form-control password-input" name="pb2" />
                            <label class="form-label" for="pw2">Ulangi Password</label>
                        </div>
                        <div class="input-box mb-3">
                            <input type="checkbox"  onclick="togglePassword()"/> Show password
                        </div>
                        <button class="btn btn-primary" name="ubah-user" type="submit">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } elseif (isset($_SESSION['super_admin'])) {
    header("location:admin/");
} else {
    include "auth/masuk.php";
} ?>