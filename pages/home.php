<!-- halaman home/utama -->
<div class="section-card">
    <div class="header-text">
        <h1>Buku Terbaru</h1>
        <a href="?p=view-all&s=buku">Lihat Semua</a>
    </div>
    <div class="content">
        <?php
        // query untuk menampilkan data buku,
        // yang dimana id kategori selain 4(komik)
        // dan ditampilkan secara berurutan dari id buku yang terbaru,
        // dan juga data buku yang ditampilkan hanya 5 data
        $books = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_kategori.id_kategori=tb_buku.kategori WHERE kategori <> 4 ORDER BY id_buku DESC LIMIT 5 ");
        while ($data = $books->fetch_assoc()) {
            echo '
            <div class="card card-home">
                <img src="assets/book/' . $data['cover'] . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">' . $data['penulis'] . '</p>
                    <h6 class="card-title">' . substr($data['judul_buku'], 0, 40) . '</h6>
                    <a href="?p=detail&id=' . $data['id_buku'] . '" class="btn btn-primary btn-sm">Detail Buku</a>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>

<div class="section-card">
    <div class="header-text">
        <h1>Komik</h1>
        <a href="?p=view-all&s=komik">Lihat Semua</a>
    </div>
    <div class="content">
        <?php
        $komiks = $koneksi->query("SELECT * FROM tb_buku JOIN tb_kategori ON tb_kategori.id_kategori=tb_buku.kategori WHERE kategori=4 LIMIT 5");
        while ($data = $komiks->fetch_assoc()) {
            echo '
            <div class="card card-home">
                <img src="assets/book/' . $data['cover'] . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">' . $data['penulis'] . '</p>
                    <h6 class="card-title">' . substr($data['judul_buku'], 0, 40) . '</h6>
                    <a href="?p=detail&id=' . $data['id_buku'] . '" class="btn btn-primary btn-sm">Detail Buku</a>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>