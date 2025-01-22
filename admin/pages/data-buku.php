<a href="?page=data-buku&crd=tambah-data-buku" class="btn btn-primary btn-sm mb-5">Tambah Data Buku</a>
<div class="table-responsive">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_kategori.id_kategori=tb_buku.kategori ORDER BY id_buku DESC");
            while ($data = $sql->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?= $no; ?>
                    </td>
                    <td class="text-capitalize">
                        <?= substr($data['judul_buku'], 0, 20) . '...'; ?>
                    </td>
                    <td>
                        <?= $data['name_kategori']; ?>
                    </td>
                    <td>
                        <?= $data['penulis']; ?>
                    </td>
                    <td>
                        <?= date('d/m/Y', strtotime($data['tahun_terbit'])) ?>
                    </td>
                    <td>
                        <a href="?page=data-buku&crd=detail-buku&id=<?= $data['id_buku']; ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-info"></i></a>
                        <a href="?page=data-buku&crd=edit-buku&id=<?= $data['id_buku']; ?>" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form action="" method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?= $data['id_buku']; ?>">
                        </form>
                        <button class="btn btn-danger btn-sm" name="delete-buku" id="delete" data-buku='<?= $data['id_buku']; ?>'><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            <?php $no++;
            } ?>
        </tbody>
    </table>
</div>