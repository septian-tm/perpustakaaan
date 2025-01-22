<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="?p=">PERPUSTAKAAN</a>
        
        <!-- kategori -->
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="kategori_name">Kategori</span>
                    <i class="fa-solid fa-tags icon_kategori text-black "></i>
                </a>
                <ul class="dropdown-menu">
                    <?php
                    // query menampilkan data kategori
                    $kategories = $koneksi->query("SELECT * FROM tb_kategori ORDER BY name_kategori ASC");
                        while($kategori = $kategories->fetch_assoc()){
                            echo '
                                <li><a class="dropdown-item text-capitalize" href="?p=kategori&s='.$kategori['id_kategori'].'">'.$kategori['name_kategori'].'</a></li>
                            ';
                        }
                    ?>
                </ul>
            </li>
        </ul>
        <!-- kategori end -->
        <!-- Form Search  -->
        <form method="post" action="?p=search" role="search" class="search-form me-auto">
            <input class="form-control me-2" type="text" name="key" placeholder="Cara nama buku, penulis, atau penerbit..." aria-label="Search">
            <button type="submit" name="cari"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <!-- form search end -->

        <!-- icon right -->
        <div class="d-flex gap-5 user_show">
            <!-- icon show form search | mobile -->
            <a href="#" class="text-black showForm">
                <i class="fa-solid fa-magnifying-glass" id="iconShowForm"></i>
            </a>
            
            <!-- icon user -->
            <a href="?p=account" class="text-black user-icon" type="button" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
            </a>
        </div>
    </div>
</nav>