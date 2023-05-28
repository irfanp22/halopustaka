<?php
if ($_SESSION['level'] == "petugas") {
    header("Location: dashboard.php");
}
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "pengurus") {
        header("Location: index.php");
    }
}
include "trigger.php";

if (isset($_POST['tambahpetugas'])) {
    $id = before_insert_pengurus();
    $nama = $_POST['nama'];
    $lvl = $_POST['lvl'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $konpass = $_POST['konpass'];

    if (!password_verify($konpass, $password)) {
        echo "<script>
                swal('Password Tidak Sama!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=tpetugas');
                })
            </script>";
        exit;
    }

    if (!empty($_FILES['pic']['name'])) {
        $query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT id_pengurus FROM pengurus ORDER BY id_pengurus DESC LIMIT 1"));
        $idprev = $query['id_pengurus'];
        $awl = substr($idprev, 0, 2);
        $no = intval(end(explode('G', $idprev, 3))) + 1;
        $id = $awl . sprintf("%03d", $no);
        $namafoto = $id . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/pengurus/" . $namafoto;
        $dir = "pengurus/";
        $foto = $dir . $namafoto;
        $query = "INSERT INTO pengurus(id_pengurus, nama, password, level, pic) VALUES('$id', '$nama', '$password', '$lvl', '$foto')";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            echo "<script>
                swal('Petugas Baru Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewpetugas');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Petugas Baru Gagal Ditambahkan!', '', 'error');
                </script>";
            exit;
        }
    } else {
        $query = "INSERT INTO pengurus(id_pengurus, nama, password, level) VALUES('$id', '$nama', '$password', '$lvl')";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            echo "<script>
                swal('Petugas Baru Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewpetugas');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Petugas Baru Gagal Ditambahkan!', '', 'error');
                </script>";
            exit;
        }
    }
}
?>
<div class="container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <h4 class="text-center mt-3 mb-3">Tambah Petugas Perpustakaan</h4>
            <form action="dashboard.php?page=tpetugas" method="post" name="tambahpetugas" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nama</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama"
                            required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Level</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="radio" name="lvl" id="owner" value="owner" required>
                        <label for="owner">Owner</label><br>
                        <input type="radio" name="lvl" id="petugas" value="petugas" required>
                        <label for="petugas">Petugas</label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Foto</h6>
                    </div>
                    <div class="col-sm-9 align-items-center text-center">
                        <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png" onchange="return valid();">
                        <img src="" id="display" alt="pic" width="150" hidden>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Password</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukan Password" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Konfirmasi Password</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" name="konpass" id="konpass" class="form-control"
                            placeholder="Konfirmasi Password" required>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary" name="tambahpetugas">Tambah Petugas</button>
            </form>
        </div>
    </div>
</div>