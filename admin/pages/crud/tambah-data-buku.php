<?php
if (isset($_POST['simpan-buku'])) {
    if (tambahBuku($_POST) > 0) {
        echo "<script>alert('Data Berhasil Ditambahkan!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=data-buku'>";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-9">
            <div class="card p-4 rounded-4">
                <div class="mb-2">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" name="judul-buku" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Kategori</label>
                    <select name="ketegori_id" class="form-control" required>
                        <option value="">-Pilih Kategori-</option>
                        <?php
                        $sql = $koneksi->query("SELECT * FROM tb_kategori");
                        while ($data = $sql->fetch_assoc()) {
                            echo "<option value='" . $data['id_kategori'] . "'>" . $data['name_kategori'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <label class="form-label">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" required>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label" for="rak">Lokasi Rak Buku</label>
                    <select name="rak" id="rak" class="form-control" required>
                        <option value="">- Pilih Rak -</option>
                        <?php
                        $abc = ['A', 'B', 'C'];
                        for ($rak = 0; $rak < count($abc); $rak++) {
                            for ($no = 1; $no <= 3; $no++) {
                                echo "<option value='$abc[$rak]$no'>$abc[$rak]$no</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label" for="thnTerbit">Tahun Terbit</label>
                    <input type="date" class="form-control" name="thn_terbit" id="thnTerbit" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Jumlah Halaman</label>
                    <input type="number" class="form-control" name="jml_hal" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Jumlah Buku</label>
                    <input type="number" class="form-control" name="jml" required> 
                </div>
                <div class="mb-2">
                    <label class="form-label">Deskripsi Buku</label>
                    <textarea name="deskripsi" id="summernote" required></textarea>
                </div>
                <div class="mb-2">
                    <button class="btn btn-primary" type="submit" name="simpan-buku">Simpan</button>
                    <a href="?page=data-buku" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card p-2 rounded-4">
                <img src="../assets/img/no image.jpg" alt="" class="img-thumbnail" id="uploadPreviewDB">
                <input type="file" class="form-control form-control-sm mt-3" name="cover" id="uploadImageDB" onchange="PreviewImageDB()" required>
            </div>
        </div>
    </div>
</form>