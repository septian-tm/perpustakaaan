<?php
// name ini di dapat dari halaman home bagian 'lihat semua'
$name = $_GET['s'];

// query untuk menampilkan data buku sesuai dengan $name
// jika user mimilih bagian buku, maka data yang akan ditampilkan,
// adalah data buku/selain komik,
// begitu sebaliknya
$qry = $koneksi->query("SELECT * FROM tb_buku as b JOIN tb_kategori as k ON k.id_kategori=b.kategori WHERE k.id_kategori='$name'");
if(mysqli_num_rows($qry) > 0){
    echo '<div class="viewAll">';
    while($kategori = $qry->fetch_assoc()){
        echo '
            <div class="card card-home">
                <img src="assets/book/' . $kategori['cover'] . '" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">' . $kategori['penulis'] . '</p>
                    <h6 class="card-title">' . substr($kategori['judul_buku'], 0, 40) . '</h6>
                    <a href="?p=detail&id=' . $kategori['id_buku'] . '" class="btn btn-primary btn-sm">Pinjam Buku</a>
                </div>
            </div>
            ';
        }
    echo '</div>';
}else{
    echo "data tidak ada";
}