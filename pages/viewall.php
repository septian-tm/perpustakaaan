<?php
if ($_GET['s'] == "buku") {
    echo '<div class="viewAll">';
    $qry_books = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_kategori.id_kategori=tb_buku.kategori WHERE kategori <> 4 ");
    while ($res_books = $qry_books->fetch_assoc()) {
        echo '
            <div class="card card-home">
                <img src="assets/book/' . $res_books['cover'] . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">' . $res_books['penulis'] . '</p>
                    <h6 class="card-title">' . substr($res_books['judul_buku'], 0, 40) . '</h6>
                    <a href="?p=detail&id=' . $res_books['id_buku'] . '" class="btn btn-primary btn-sm">Pinjam Buku</a>
                </div>
            </div>
        
        ';
    }
    echo '</div>';
} else {
    echo '<div class="viewAll">';
    $komiks = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_kategori.id_kategori=tb_buku.kategori WHERE kategori= 4");
    while ($komik = $komiks->fetch_assoc()) {
        echo '
            <div class="card card-home">
                <img src="assets/book/' . $komik['cover'] . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">' . $komik['penulis'] . '</p>
                    <h6 class="card-title">' . substr($komik['judul_buku'], 0, 40) . '</h6>
                    <a href="?p=detail&id=' . $komik['id_buku'] . '" class="btn btn-primary btn-sm">Pinjam Buku</a>
                </div>
            </div>
        ';
    }
    echo '</div>';
}
