<?php
if(isset($_POST['cari'])){
    $keyword = $_POST['key'];
    
    $result = array();
    $s = $koneksi->query("SELECT * FROM tb_buku WHERE judul_buku LIKE '%$keyword%' OR penulis LIKE '%$keyword%' OR penerbit LIKE '%$keyword%'");
    while($search = $s->fetch_assoc()){
        $result[] = $search;
    }

    echo'
    <h4 class="text-capitalize">Hasil Pencarian '.$keyword.'</h4>
    <div class="content">
    ';
    foreach($result as $results){
        echo'
            <div class="card card-home">
                <img src="assets/book/'.$results['cover'].'" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">' . $results['penulis'] . '</p>
                    <h6 class="card-title">' . substr($results['judul_buku'], 0, 40) . '</h6>
                    <a href="?p=detail&id='.$results['id_buku'].'" class="btn btn-primary btn-sm">Pinjam Buku</a>
                </div>
            </div>
        ';
    }
    echo '</div>';  // end div content
}
?>

<?php 

