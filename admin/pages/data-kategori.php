<?php
if (isset($_POST['simpan-ktgr'])) {
    if (tambahKategori($_POST) > 0) {
        echo "<script>alert('Data Berhasil Ditambahkan!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=kategori'>";
    }
}
if (isset($_POST['edit-ktgr'])) {
    if (editKategori($_POST) > 0) {
        echo "<script>alert('Data Berhasil Diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=kategori'>";
    }
}
?>

<!-- Button trigger modal tambah data-->
<button type="button" class="btn btn-primary btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Tambah Data Kategori
</button>

<!-- Modal Tambah Data-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Data Kategori</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" name="nama-kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="simpan-ktgr">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Dibuat</th>
            <th>Terakhir Diupdate</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = $koneksi->query("SELECT * FROM tb_kategori");
        while ($data = $query->fetch_assoc()) { ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $data['name_kategori']; ?></td>
                <td><?= date("d/m/Y H:i", strtotime($data['created_at']));?></td>
                <td><?php if($data['update_at'] == null){ echo date("d/m/Y H:i", strtotime($data['created_at']));}else{ echo date("d/m/Y H:i", strtotime($data['update_at']));} ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $data['id_kategori']; ?>"><i class="fa-regular fa-pen-to-square">></i></button>
                    <button class="btn btn-danger btn-sm" name="delete" id="delete" data-kategori="<?= $data['id_kategori']; ?>"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>


            <!-- Modal Edit-->
            <div class="modal fade" id="edit<?= $data['id_kategori']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Data Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label>Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama-kategori" value="<?= $data['name_kategori']; ?>">
                                    <input type="hidden" class="form-control" name="id" value="<?= $data['id_kategori']; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="edit-ktgr">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php $no++;
        } ?>
    </tbody>

</table>