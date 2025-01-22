<?php
$id = $_GET['id'];
$qry = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_buku.kategori=tb_kategori.id_kategori WHERE id_buku='$id'");
$edit = $qry->fetch_assoc();



if (isset($_POST['edit-buku'])) {
    if (editBuku($_POST) > 0) {
        echo "<script>alert('Data Berhasil Diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=data-buku'>";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-9">
            <div class="card p-4 rounded-4">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <div class="mb-2">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" name="judul-buku" value="<?= $edit['judul_buku']; ?>">
                </div>
                <div class="mb-2">
                    <label class="form-label">Kategori</label>
                    <select name="ketegori_id" class="form-control">
                        <option>-Pilih Kategori-</option>
                        <?php
                        $sql = $koneksi->query("SELECT * FROM tb_kategori");
                        while ($data = $sql->fetch_assoc()) {
                            echo "<option value='" . $data['id_kategori'] . "'";
                            if ($edit['kategori'] == $data['id_kategori']) {
                                echo "selected";
                            }
                            echo ">" . $data['name_kategori'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" value="<?= $edit['penulis']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <label class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" value="<?= $edit['penerbit']; ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="date" class="form-control" name="thn_terbit" value="<?= $edit['tahun_terbit']; ?>">
                </div>
                <div class="mb-2">
                    <label class="form-label">Lokasi Rak Buku</label>
                    <select name="rak" id="" class="form-control">
                        <option>- Pilih Rak -</option>
                        <?php
                        $abc = ['A', 'B', 'C'];
                        for ($rak = 0; $rak < count($abc); $rak++) {
                            for ($no = 1; $no <= 5; $no++) {
                                echo "<option value='$abc[$rak]$no'";
                                if ($edit['rak_buku'] == "$abc[$rak]$no") {
                                    echo 'selected';
                                }
                                echo ">$abc[$rak]$no</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Jumlah Halaman</label>
                    <input type="number" class="form-control" name="jml_hal" value="<?= $edit['jumlah_halaman']; ?>">
                </div>
                <div class="mb-2">
                    <label class="form-label">Jumlah Buku</label>
                    <input type="number" class="form-control" name="jml" value="<?= $edit['jumlah_buku']; ?>">
                </div>
                <div class="mb-2">
                    <label class="form-label">Deskripsi Buku</label>
                    <textarea name="deskripsi" id="summernote"><?= $edit['deskripsi']; ?></textarea>
                    <!-- <div id="summernote"></div> -->
                </div>
                <div class="mb-2">
                    <button class="btn btn-primary" type="submit" name="edit-buku">Simpan</button>
                    <a href="?page=data-buku" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card p-2 rounded-4">
                <div class="card-header mb-3">Cover</div>
                <?php
                if ($edit['cover'] != null) {
                    echo '<img src="../assets/book/' . $edit['cover'] . '" alt="" class="img-thumbnail" id="uploadPreviewDB">';
                } else {
                    echo '<img src="../assets/img/no image.jpg" alt="" class="img-thumbnail" id="uploadPreviewDB">';
                }
                ?>
                <input type="hidden" value="<?= $edit['cover']; ?>" name="cover_lama">
                <input type="file" class="form-control form-control-sm mt-3" name="cover" id="uploadImageDB" onchange="PreviewImageDB()">
            </div>
        </div>
    </div>
</form>