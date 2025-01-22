<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"><!-- bootstrap -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free-6.1.1/css/fontawesome.min.css"><!-- fontawesome -->
    <link rel="stylesheet" href="../assets/css/admin.css"><!-- mycss -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"><!-- datatable -->
    <link rel="stylesheet" href="../assets/plugins/sweetalert/dist/sweetalert2.min.css"><!-- sweetalert -->
    <script src="../assets/plugins/sweetalert/dist/sweetalert2.all.min.js"></script>
    <link href="../assets/plugins/summernote-0.8.18-dist/summernote-lite.min.css" rel="stylesheet"><!-- summernote editor -->
    <title>Administrator</title>
</head>

<body>

    <main>
        <div class="sidebar" id="sidebar">
            <header class="logo">Administrator</header>
            <!-- sidebar -->
            <div class="sidebar-body">
                <ul>
                    <a href="?page=">
                        <li class=""><i class="fa-solid fa-outdent"></i> Dashboard</li>
                    </a>
                    <a href="?page=kategori">
                        <li class=""><i class="fa-solid fa-tags"></i> Data Kategori</li>
                    </a>
                    <a href="?page=data-buku">
                        <li class=""><i class="fa-solid fa-book icon"></i> Data Buku</li>
                    </a>
                    <a href="?page=buku-dipinjam">
                        <li class=""><i class="fa-regular fa-address-book icon"></i> Data Peminjaman
                            <?php
                            $qry_dp = $koneksi->query("SELECT * FROM tb_peminjaman WHERE status_id=1");
                            $res_dp = $qry_dp->num_rows;
                            echo '<span class="badge bg-warning">' . $res_dp . '</span>';
                            ?>
                        </li>
                    </a>
                    <hr>
                    <a href="?page=data-user">
                        <li class=""><i class="fa-solid fa-users icon"></i> Data Users</li>
                    </a>
                    <hr style="margin-top: -10px">
                    <!-- 
                        jika yang login adalah level admin 
                        maka akan menampilkan data tersebut
                    -->
                    <?php if($_SESSION['admin']['level'] == "admin"){
                        echo'
                        <a href="../?p=">
                            <li class=""><i class="fa-solid fa-angles-left"></i> Lihat Web</li>
                        </a>
                        ';
                    }?>
                    
                </ul>
            </div>
            <!-- end sidebar -->
        </div>
        <!-- navbar head START -> END admin/index.php -->
        <div class="page-content" id="page">
            <nav class="navbar navbar-expand-lg">
                <a href="#" class="navbar-brand" onclick="toggle()"><i class="fa-solid fa-bars"></i></a>
                <div class="navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav  ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $_SESSION['admin']['username']; ?> <i class="fa-solid fa-user-large"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-profile" aria-labelledby="navbarDarkDropdownMenuLink">
                                <!-- hanya untuk super admin | ganti password -->
                                <?php if($_SESSION['super_admin']){
                                    echo '<li><a class="dropdown-item" href="#changePassword" data-bs-toggle="modal">Ganti Password</a></li>';
                                }
                                ?>
                                <li><a class="dropdown-item" href="../auth/keluar.php" id="logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- modal change password super admin -->
                <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ganti Password</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label for="">Password Lama</label>
                                        <input type="password" name="old" class="form-control password-input" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Password Baru</label>
                                        <input type="password" name="new" class="form-control password-input" required>
                                    </div>
                                    <div class="mb-2">
                                        <input type="checkbox" id="toggle-password"/> Show password
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="changePassword">Simpan</button>
                                </div>
                            </form>
                            <?php if(isset($_POST['changePassword'])){
                                if(changePasswordSuper($_POST) > 0){}
                            };?>
                        </div>
                    </div>
                </div>
            </nav>