<?php
if (isset($_POST['pinjam-buku'])) {
    if (pinjamBuku($_POST) > 0) {
    }
}
?>

<!-- modal/pop up peminjaman buku -->
<div class="modal fade" id="pinjam<?= $data['id_buku']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="">Buku Yang Dipinjam</label>
                        <input type="hidden" value="<?= $data['id_buku']; ?>" name="id_buku">
                        <input type="text" class="form-control" value="<?= $data['judul_buku']; ?>" name="" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" value="<?= $user['name']; ?>" name="" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="">NIS</label>
                        <input type="text" class="form-control" value="<?= $user['nis']; ?>" name="" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="">Tanggal Pinjam (Pengambilan buku)</label>
                        <input type="text" class="form-control" name="tgl" id="datepicker" value="<?= isset($_SESSION['date']) ? $_SESSION['date'] : ''; ?>" autocomplete="off" required >
                    </div>
                    <!-- notes -->
                    <div class="mb-2">
                        <div class="alert alert-warning" role="alert">
                            NOTES!<br>
                            Peminjaman buku paling lambat di kembalikan setelah 7hari dari tanggal peminjaman. Jika melebihi 7hari maka akan di kenakan denda sebesar 1.000 rupiah/hari, dan jika buku hilang atau rusak akan dikenakan denda!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="pinjam-buku">Pinjam</button>
                </div>
            </form>
        </div>
    </div>
</div>