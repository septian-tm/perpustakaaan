<?php
session_start();
date_default_timezone_set("Asia/Jakarta"); 

include "koneksi.php";
include "alert.php";

// session user
if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    $dataUser = $koneksi->query("SELECT * FROM tb_users WHERE (id_user='" . $_SESSION['user']['id_user'] . "' OR id_user='" . $_SESSION['admin']['id_user'] . "')");
    $user = $dataUser->fetch_assoc();
}

// fungsi daftar user
function daftarUser($data)
{
    global $koneksi;

    $nama = $data['nama'];
    $uname = $data['username'];
    $nis = $data['nis'];
    $jk = $data['jk'];
    $tl = $data['tgl'];
    $no = $data['nohp'];
    $alamat = $data['alamat'];
    $pw1 = md5($data['pw1']);
    $pw2 = md5($data['pw2']);
    $created_at = date('Y-m-d H:i:s');

    $cekNis = $koneksi->query("SELECT * FROM tb_users WHERE nis='$nis'");
    $cekUname = $koneksi->query("SELECT * FROM tb_users WHERE username='$uname' ");

    // mengecek apakah nis sudah terdaftar atau belum
    if ($cekNis->num_rows > 0) {
        $icon = "error";
        $title = "Oops...";
        $text = "NIS Sudah Terdaftar!";
        $location = "";
        alert($icon, $title, $text, $location);

        // mengecek username sudah terdaftar atau belum
    } elseif ($cekUname->num_rows > 0) {
        $icon = "error";
        $title = "Oops...";
        $text = "Username Sudah Terdaftar!";
        $location = "";
        alert($icon, $title, $text, $location);

        // Mengecek apakah password 2 dengan password 1 match
    } elseif ($pw1 !== $pw2) {
        $icon = "error";
        $title = "Oops...";
        $text = "Password tidak sesuai!";
        $location = "";
        alert($icon, $title, $text, $location);

        // jika kondisi diatas terpenuhi menjalankan query dibawah
    } else {
        $koneksi->query("INSERT INTO tb_users(name, username, nis, jk, tgl_lahir, no_hp, alamat, password, level, created_at )VALUE('$nama', '$uname', '$nis', '$jk', '$tl', '$no', '$alamat', '$pw1', 'user', '$created_at')");

        $icon = "success";
        $title = "Selamat!";
        $text = "Akun Kamu Berhasil Dibuat, Silahkan Login!";
        $location = "";
        alert($icon, $title, $text, $location);
    }

    return mysqli_affected_rows($koneksi);
}


// fungsi login/masuk 
function masuk($data)
{
    global $koneksi;

    $un = $_REQUEST['un'];
    $pw = md5($data['pw']);

    $cek = $koneksi->query("SELECT * FROM tb_users WHERE (username='$un' OR nis='$un') AND password='$pw'");
    $res = $cek->num_rows;

    if ($res == 1) {
        $user = $cek->fetch_assoc();

        if ($user['level'] == "user" ) {
            $_SESSION['user'] = $user;

            $data = "login berhasil";
            $location = "?p=account";
            alert_timer($data, $location);
        } elseif($user['level'] == "admin") {
            $_SESSION['admin'] = $user;

            $data = "login berhasil";
            $location = "admin/";
            alert_timer($data, $location);
        }elseif($user['level'] == "super_admin"){
            $_SESSION['super_admin'] = $user;

            $data = "login berhasil";
            $location = "admin/";
            alert_timer($data, $location);
        }
    } else {
        $icon = "error";
        $title = "Oops...";
        $text = "Usename Atau Password Salah";
        $location = "";
        alert($icon, $title, $text, $location);
    }

    return mysqli_affected_rows($koneksi);
}

// fungsi update data user
function updateUser($data)
{
    global $koneksi;

    $id = $data['id'];
    $username = $data['username'];
    $jk = $data['jk'];
    $tgl = $data['tgl'];
    $no = $data['nohp'];
    $alamat = $data['alamat'];

    $pl = md5($data['pl']); // password lama
    $pb = md5($data['pb']); // password baru
    $pb2 = md5($data['pb2']); // ulang password baru 

    // jika form input password tidak diisi, maka akan menjalankan baris code dibawah,
    // namun jika form input diisi, maka akan menjalankan baris code 149
    if (empty($data['pl']) && empty($data['pb']) && empty($data['pb2'])) {
        $koneksi->query("UPDATE tb_users SET
            username    = '$username',
            jk          = '$jk',
            tgl_lahir   = '$tgl',
            no_hp       = '$no',
            alamat      = '$alamat',
            update_at   = NOW()
            WHERE id_user = '$id'
        ");
        $icon = "success";
        $title = "Suskses";
        $text = "Data Berhasil Diubah";
        $location = "";
        alert($icon, $title, $text, $location);
    } else {
        $qryPw = $koneksi->query("SELECT password FROM tb_users WHERE id_user='$id'");
        $resPw = $qryPw->fetch_assoc();

        // mengecek apakah password lama user tsb, sama dengan yang baru diinput,
        // jika password match, maka akan menjalankan baris coded 155 - 180
        // dan jika password tidak match menjalankan baris code 181 - 187
        if ($pl == $resPw['password']) {
            // jika form input password baru dan ulangi password null/kosong
            if(empty($data['pb']) && empty($data['pb2'])){
                $icon = "error";
                $title = "Oopss...";
                $text = "Isi Kolom Password baru";
                alert($icon, $title, $text, $location);

            // jika form input password baru dan ulangi password match
            }elseif ($pb == $pb2) {
                $koneksi->query("UPDATE tb_users SET password='$pb' WHERE id_user ='$id'");

                $icon = "success";
                $title = "Suskses";
                $text = "Password Berhasil Diubah";
                $location = "";
                alert($icon, $title, $text, $location);

            // jika tidak, maka akan mnjalankan pesan error dibawah
            } else {
                $icon = "error";
                $title = "Oopss...";
                $text = "Password Tidak Sesuai";
                $location = "";
                alert($icon, $title, $text, $location);
            }
        } else {
            $icon = "error";
            $title = "Oopss...";
            $text = "Password Salah";
            $location = "";
            alert($icon, $title, $text, $location);
        }
    }

    return mysqli_affected_rows($koneksi);
}


// fungsi peminjaman buku
// didalam fungsi ini hanya untuk mnyimpan session peminjaman buku sementara
// fungsi ini masih berhubungan dengan fungsi proses pinjam
function pinjamBuku($data)
{
    global $koneksi;

    $id = $data['id_buku'];

    $_SESSION['date'] = $data['tgl'];
    $_SESSION['pinjam'][$id] = 1;

    $data = "Tunggu Sebentar";
    $location = "?p=pinjam-buku";
    alert_timer($data, $location);

    return mysqli_affected_rows($koneksi);
}

// fungsi proses peminjaman buku
function prosesPinjam($data, $user)
{
    global $koneksi;

    $id_user = $user['id_user'];
    $tgl_pinjam = $_SESSION['date'];
    // tanggal sampai ini adalah batas pengembalian buku,
    // disini di set selama +7 atau tujuh hari,
    // jika ingin diubah, bisa disesuaikan dan baca pada file FAQ apasaja yang berubah
    $tgl_sampai = date('Y-m-d', strtotime('+7day', strtotime($tgl_pinjam)));
    $created_at = date('Y-m-d H:i:s');

    $date = date('dm');
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $substr = substr(str_shuffle($str), 0, 2);
    $code = $date . $substr;

    $koneksi->query("INSERT INTO tb_peminjaman(code_peminjaman, user_id, tgl_peminjaman, status_id, created_at) VALUE('$code', '$id_user', '$tgl_pinjam', 1, '$created_at')");

    $new_id = $koneksi->insert_id;
    foreach ($_SESSION['pinjam'] as $id => $jml) {
        $koneksi->query("INSERT INTO tb_peminjaman_buku(peminjaman_id,buku_id)VALUE('$new_id','$id')");
    }

    unset($_SESSION['pinjam']);
    unset($_SESSION['date']);

    $data = "Tunggu Sebentar";
    $location = "?p=pinjam-buku&id=$new_id";
    alert_timer($data, $location);

    return mysqli_affected_rows($koneksi);
}

// fungsi batal pinjam
function batalPinjam($data){
    unset($_SESSION['pinjam']);
    unset($_SESSION['date']);

    $data = "Tunggu Sebentar";
    $location = "?p=";
    alert_timer($data, $location);
}

// mengubah status menjadi expired ketika,
// user tidak melakukan pengambilan buku,
// di tanggal yang telah di tentukan.
function statusExpired()
{
    global $koneksi;
    $exp = $koneksi->query("UPDATE tb_peminjaman SET status_id=5 WHERE CURDATE() > tgl_peminjaman AND status_id=1");
    if ($exp == 1) {
        return $exp;
    }
}
statusExpired();

// menghitung tanggal telat dan denda pengembalian buku,
// jika user telat mengembalikan buku,
// sesuai dengan tanggal yang ditentukan.
function telat()
{
    global $koneksi;
    $sql_pengembalian = $koneksi->query("SELECT * FROM tb_peminjaman WHERE CURDATE() > tgl_sampai AND status_id!=4");
    while ($res_pengembalian = $sql_pengembalian->fetch_assoc()) {
        $tgl_kem = $res_pengembalian['tgl_sampai'];

        $tgl_now = date('Y-m-d');
        $cari_hari = abs(strtotime($tgl_kem) - strtotime($tgl_now));
        $hari = floor($cari_hari / (60 * 60 * 24));
        // denda di bawah bisa kmu ganti dengan kebutuhan,
        // yang pastinya ada beberapa bagian yang perlu diubah,
        // baca pada file FAQ
        $denda =  $hari * 1000;

        $res = $koneksi->query("UPDATE tb_peminjaman SET status_id=3, telat=$hari, denda=$denda WHERE CURDATE() > tgl_sampai AND status_id!=4");

        return $res;
    }
}
telat();

// FUNGSI MEMBUAT NAMA HARI B.INDONESIA
function nama_hari($hr)
{
    $nama_hari = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );
    return $nama_hari[$hr];
}

//******************************************* ADMIN AREA FUNCION *********************************************// ]

// FUNGSI ADD KATEGORI
function tambahKategori($data)
{
    global $koneksi;

    $nama_kat = $data['nama-kategori'];
    $created_at = date('Y-m-d H:i:s');

    $koneksi->query("INSERT INTO tb_kategori(name_kategori, created_at)VALUE('$nama_kat', '$created_at')");
    return mysqli_affected_rows($koneksi);
}
// FUNGSI EDIT KATEGORI
function editKategori($data)
{
    global $koneksi;

    $id = $data['id'];
    $nama = $data['nama-kategori'];
    $update_at = date('Y-m-d H:i:s');

    $koneksi->query("UPDATE tb_kategori SET name_kategori='$nama', update_at='$update_at' WHERE id_kategori='$id'");
    return mysqli_affected_rows($koneksi);
}

// FUNGSI TAMBAH DATA BUKU
function tambahBuku($data)
{
    global $koneksi;

    $judul = $data['judul-buku'];
    $kategori = $data['ketegori_id'];
    $penulis = $data['penulis'];
    $penerbit = $data['penerbit'];
    $tahun = $data['thn_terbit'];
    $jml = $data['jml'];
    $jml_hal = $data['jml_hal'];
    $desc = $data['deskripsi'];
    $rak = $data['rak'];
    $created_at = date('Y-m-d H:i:s');

    $cover = $_FILES['cover']['name'];
    $tmp = $_FILES['cover']['tmp_name'];
    $fileError = $_FILES['cover']['error'];

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $cover);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    $filebaru = uniqid();
    $filebaru .= '.';
    $filebaru .= $ekstensiGambar;


    if (in_array($ekstensiGambar, $ekstensiGambarValid)) {
        if ($fileError == 0) {
            move_uploaded_file($tmp, '../assets/book/' . $filebaru);
            $koneksi->query("INSERT INTO tb_buku(judul_buku, kategori, penulis, penerbit, tahun_terbit, jumlah_halaman, jumlah_buku, deskripsi, rak_buku, cover, created_at)VALUE('$judul', '$kategori', '$penulis', '$penerbit', '$tahun', '$jml_hal', '$jml', '$desc', '$rak', '$filebaru', '$created_at')");
        }
    } else {
        echo "<script>
                alert('Format gambar tidak di dukung');
            </script>";
    }

    return mysqli_affected_rows($koneksi);
}
// FUNGSI EDIT BUKU
function editBuku($data)
{
    global $koneksi;

    $id = $data['id'];
    $judul = $data['judul-buku'];
    $kategori = $data['ketegori_id'];
    $penulis = $data['penulis'];
    $penerbit = $data['penerbit'];
    $tahun = $data['thn_terbit'];
    $jml = $data['jml'];
    $jml_hal = $data['jml_hal'];
    $rak = $data['rak'];
    $desc = $data['deskripsi'];
    $update_at = date('Y-m-d H:i:s');

    $coverOld = $data['cover_lama'];
    $cover = $_FILES['cover']['name'];
    $tmp = $_FILES['cover']['tmp_name'];
    $fileError = $_FILES['cover']['error'];

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $cover);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    $filebaru = uniqid();
    $filebaru .= '.';
    $filebaru .= $ekstensiGambar;


    if (!empty($tmp)) {
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>
                    alert('Format gambar tidak di dukung');
                </script>";
        }

        move_uploaded_file($tmp, '../assets/book/' . $filebaru); // BAGIAN INI AKAN MENGUPLOAD DATA COVER BUKU DI FOLDER LOCAL [ASSETS/BOOKS/]
        unlink('../assets/book/' . $coverOld); // BAGIAN INI AKAN MENGHAPUS DATA COVER BUKU DI FOLDER LOCAL [ASSETS/BOOKS/]
        
        // MENJALANKAN QUERY DAN MENGGANTI COVER BARU
        $koneksi->query("UPDATE tb_buku SET
            judul_buku = '$judul',
            kategori = '$kategori',
            penulis = '$penulis',
            penerbit = '$penerbit',
            tahun_terbit = '$tahun',
            jumlah_halaman = '$jml_hal',
            jumlah_buku = '$jml',
            deskripsi = '$desc',
            rak_buku = '$rak',
            cover = '$filebaru',
            update_at='$update_at'
            WHERE id_buku='$id'
        ");
    } else {
        // DAN INI TIDAK MENGGANTI COVER BARU, DAN MASIH TETAP MENGGUNAKAN COVER LAMA
        $koneksi->query("UPDATE tb_buku SET
            judul_buku = '$judul',
            kategori = '$kategori',
            penulis = '$penulis',
            penerbit = '$penerbit',
            tahun_terbit = '$tahun',
            jumlah_halaman = '$jml_hal',
            jumlah_buku = '$jml',
            deskripsi = '$desc',
            rak_buku = '$rak',
            cover = '$coverOld',
            update_at='$update_at'
            WHERE id_buku='$id'
        ");
    }

    return mysqli_affected_rows($koneksi);
}

// UPDATE STATUS NAME
if (isset($_POST['update-data-status'])) {
    $id = $_POST['id-status'];
    $status = $_POST['status'];
    $update_at = date('Y-m-d H:i:s');

    $koneksi->query("UPDATE tb_status SET status_name='$status', update_at='$update_at' WHERE id_status='$id'");
    echo '<script>window.location=""</script>';
}

// FUNGSI UPDATE STATUS PEMINJAMAN BUKU
function updateStatusPeminjaman($data)
{
    global $koneksi;

    $id = $data['id_pinjam'];
    $status = $data['status'];

    $qry = $koneksi->query("SELECT * FROM tb_peminjaman as p JOIN tb_peminjaman_buku as pb ON pb.peminjaman_id=p.id_peminjaman WHERE id_peminjaman='$id'");
    $res = $qry->fetch_assoc();

    $tgl_sampai = date("Y-m-d", strtotime("+7day", strtotime($res['tgl_peminjaman'])));
    $update_at = date('Y-m-d H:i:s');

    if ($status == 2) { // DEFAULT: JIKA STATUS DALAM PEMINJAMAN
        $koneksi->query("UPDATE tb_peminjaman SET tgl_sampai='$tgl_sampai', status_id=$status, update_at='$update_at' WHERE id_peminjaman='$id'");

        // update jumlah buku dalam table buku
        $qry = $koneksi->query("SELECT * FROM tb_peminjaman as p JOIN tb_peminjaman_buku as pb ON pb.peminjaman_id=p.id_peminjaman WHERE id_peminjaman='$id'");
        while($pek = $qry->fetch_assoc()){
            $koneksi->query("UPDATE tb_buku SET jumlah_buku=jumlah_buku - 1 WHERE id_buku='" . $pek['buku_id'] . "'");
        }
        
    } elseif ($status == 4) { // DEFAULT: JIKA STATUS DIKEMBALIKAN
        $koneksi->query("UPDATE tb_peminjaman SET tgl_kembali=NOW(), status_id=$status,  update_at='$update_at' WHERE id_peminjaman='$id'");

        // update jumlah buku dalam table buku
        $qry = $koneksi->query("SELECT * FROM tb_peminjaman as p JOIN tb_peminjaman_buku as pb ON pb.peminjaman_id=p.id_peminjaman WHERE id_peminjaman='$id'");
        while($pek = $qry->fetch_assoc()){
            $koneksi->query("UPDATE tb_buku SET jumlah_buku=jumlah_buku + 1 WHERE id_buku='" . $pek['buku_id'] . "'");
        }
    } else { // DEFAULT: JIKA STATUS SELAIN DALAM PEMINJAMAN DAN DIKEMBALIKAN
        $koneksi->query("UPDATE tb_peminjaman SET status_id=$status, update_at='$update_at' WHERE id_peminjaman='$id'");
    }
    return mysqli_affected_rows($koneksi);
}


// GANTI PASSWORD SUPER ADMIN
function changePasswordSuper($data){
    global $koneksi;
    
    $id_super = $_SESSION['super_admin']['id_user'];
    $old = md5($data['old']);
    $new = md5($data['new']);

    $qry_s = $koneksi->query("SELECT password FROM tb_users WHERE id_user='$id_super'");
    $result_s = $qry_s->fetch_assoc();

    if($old == $result_s['password']){
        $koneksi->query("UPDATE tb_users SET password='$new' WHERE id_user='$id_super'");

        $icon = "success";
        $title = "Berhasil...";
        $text = "Password Berhasil Diubah";
        $location = "";
        alert($icon, $title, $text, $location);
    }else{
        $icon = "error";
        $title = "Oopss...";
        $text = "Password Salah";
        $location = "";
        alert($icon, $title, $text, $location);
    }
}



// DELETE / JADIKAN ADMIN FROM POST AJAX (#DELETE, #ADMIN)
// BAGIAN INI BISA DILIHAT PADA FILE [ASSETS/JS/ADMIN.JS]
if (isset($_POST['kategori'])) { // HAPUS DATA KATEGORI
    $koneksi->query("DELETE FROM tb_kategori WHERE id_kategori='" . $_POST['kategori'] . "'");

} elseif (isset($_POST['buku'])) { // HAPUS DATA BUKU
    $getCvr = $koneksi->query("SELECT cover FROM tb_buku WHERE id_buku='" . $_POST['buku'] . "'");
    $getCvr = $getCvr->fetch_assoc();

    unlink('../assets/book/' . $getCvr['cover']);

    $koneksi->query("DELETE FROM tb_buku WHERE id_buku='" . $_POST['buku'] . "'");

} elseif (isset($_POST['peminjaman'])) { // HPUS/UPDATE DATA PEMINJAMAN YANG SUDAH EXPIRED 
    $koneksi->query("UPDATE tb_peminjaman SET is_deleted=1 WHERE id_peminjaman='" . $_POST['peminjaman'] . "'");

} elseif (isset($_POST['id_user'])) {// UPDATE DATA USER YANG AKAN DIJADIKAN ADMIN
    $koneksi->query("UPDATE tb_users SET level='admin' WHERE id_user='" . $_POST['id_user'] . "'");

} elseif (isset($_POST['id_remove_user'])) { // UPDATE DATA USER DIKEMBALIKAN MENJADI USER BIASA
    $koneksi->query("UPDATE tb_users SET level='user' WHERE id_user='" . $_POST['id_remove_user'] . "'");
}
