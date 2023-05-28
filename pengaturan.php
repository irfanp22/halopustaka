<?php
$title = "Profil";
$css = "";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}
include "koneksi.php";
include "template/head.php";
include "template/nav.php";

if (isset($_SESSION['username']) && $_SESSION['role'] == 'anggota') {
    $tabel = $_SESSION['role'];
    $user = $_SESSION['username'];
    $sql = mysqli_query($koneksi, "SELECT * FROM $tabel WHERE nim = '$user'");
    $data = mysqli_fetch_array($sql);
}

if(isset($_POST['edit'])){
    $tabel = $_SESSION['role'];
    $nim = $_SESSION['username'];
    $pass = mysqli_fetch_array(mysqli_query($koneksi, "SELECT password FROM $tabel WHERE nim = '$nim'"));
    if (!password_verify($_POST['password'], $pass['password'])){
        echo '<script> swal("Password salah! Data gagal diedit!", "", "error").then(function(){
            window.location.assign("pengaturan.php")
            }) </script>';
        exit;
    }
    if (($_POST['passwordbaru'] !== $_POST['passwordbarukonf'])){
        echo '<script> swal("Password baru berbeda! Data gagal diedit!", "", "error").then(function(){
            window.location.assign("pengaturan.php")
            }) </script>';
    }
    $email = $_POST['email'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];
    if(isset($_POST['passwordbaru'])){
        $password = password_hash($_POST['passwordbaru'], PASSWORD_DEFAULT);
    }
    if(!empty($_FILES['pic']['name'])){
        $namafoto = $_SESSION['username'].".".strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/anggota/".$namafoto;
        $dir = "anggota/";
        $foto = $dir.$namafoto;
        if(!empty($_POST['passwordbaru'])) $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat', password = '$password', pic = '$foto' WHERE nim = '$nim'";
        else $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat', pic = '$foto' WHERE nim = '$nim'";
        $sql = mysqli_query($koneksi, $query);
        if($sql){
            move_uploaded_file($lokasifoto, $fulldir);
            echo '<script> swal("Data berhasil diperbarui!", "", "success").then(function(){
                window.location.assign("profil.php")
                }) </script>';
        }else echo 'swal("Data gagal diperbarui!", "", "error").then(function(){
            window.location.assign("pengaturan.php")
            }) </script>';
    }else{
        if(!empty($_POST['passwordbaru'])) $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat', password = '$password' WHERE nim = '$nim'";
        else $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat' WHERE nim = '$nim'";
        $sql = mysqli_query($koneksi, $query);
        if($sql){
            echo '<script> swal("Data berhasil diperbarui!", "", "success").then(function(){
                window.location.assign("profil.php")
                }) </script>';
        }else echo 'swal("Data gagal diperbarui!", "", "error").then(function(){
            window.location.assign("pengaturan.php")
            }) </script>';
    }
}
?>
<div class="container">
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="text-center mt-3 mb-3">Edit Data Profil</h4>
                <form action="pengaturan.php" method="post" name="edit" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NIM</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="nim" id="nim" value="<?php echo $data['nim'] ?>" class="form-control text-uppercase" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="nama" id="nama" value="<?php echo $data['nama'] ?>" class="form-control text-capitalize" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="email" name="email" id="email" value="<?php echo $data['email'] ?>" class="form-control" placeholder="Masukan Email">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">No HP</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="nohp" id="nohp" value="<?php echo $data['no_hp'] ?>" class="form-control" placeholder="Masukan No HP">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Jenis Kelamin</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="jk" id="jk" value="<?php if ($data['jenis_kelamin'] == "l") echo "Laki-laki";
                                                                        else echo "Perempuan" ?>" class="form-control" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Alamat</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" placeholder="MasukanAlamat"><?php echo $data['alamat'] ?></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Foto</h6>
                        </div>
                        <div class="col-sm-9 align-items-center text-center">
                            <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png" onchange="return valid();">
                            <img src="assets/img/<?php echo $data['pic'] ?>" id="display" alt="<?php echo $data['nama'] ?>" width="150">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password</h6>
                            <p><strong>*required</strong></p>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password Lama" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password Baru</h6>
                            <p><strong>*isi jika ingin mengganti password</strong></p>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="passwordbaru" id="passwordbaru" class="form-control" placeholder="Masukan Password Baru">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Konfirmasi Password Baru</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="passwordbarukonf" id="passwordbarukonf" class="form-control" placeholder="Konfirmasi Password Baru">
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary" name="edit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include "template/foot.php";
?>