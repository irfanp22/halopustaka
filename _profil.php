<?php
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengurus WHERE id_pengurus = '" . $_SESSION['username'] . "'"));

if (isset($_POST['editprofil'])) {
    $password = $_POST['password'];
    if (!password_verify($password, $data['password'])) {
        echo "<script>
                swal('Password Salah!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
            </script>";
        exit;
    }
    $nama = $_POST['nama'];
    if (!empty($_FILES['pic']['name'])) {
        $namafoto = $data['id_pengurus'] . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/pengurus/" . $namafoto;
        $dir = "pengurus/";
        $foto = $dir . $namafoto;
        $query = "UPDATE pengurus SET nama = '$nama', pic='$foto' WHERE id_pengurus = '" . $data['id_pengurus'] . "'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            $_SESSION['nama'] = $nama;
            echo "<script>
                swal('Data Profil Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Profil Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
                </script>";
            exit;
        }
    } else {
        $query = "UPDATE pengurus SET nama = '$nama' WHERE id_pengurus = '" . $data['id_pengurus'] . "'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            $_SESSION['nama'] = $nama;
            echo "<script>
                swal('Data Profil Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Profil Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
                </script>";
            exit;
        }
    }
}

if (isset($_POST['gantipass'])) {
    $passlama = $_POST['passlama'];
    $passbaru = password_hash($_POST['passbaru'], PASSWORD_DEFAULT);
    $passbarukonf = $_POST['passbarukonf'];
    if (!password_verify($passlama, $data['password'])) {
        echo "<script>
                swal('Password Salah!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
            </script>";
        exit;
    } else if (!password_verify($passbarukonf, $passbaru)) {
        echo "<script>
                swal('Password Baru Tidak Sama!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
            </script>";
        exit;
    }
    $sql = mysqli_query($koneksi, "UPDATE pengurus SET password='$passbaru' WHERE id_pengurus = '" . $data['id_pengurus'] . "'");
    if ($sql) {
        echo "<script>
                swal('Password Berhasil Diganti!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
                </script>";
        exit;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="card border-left-primary shadow col-md-4">
            <div class="card-body text-center">
                <img src="assets/img/<?php echo $data['pic'] ?>" alt="<?php echo $data['nama'] ?>" width="150px"
                    id="ppic">
                <h6>
                    <?php echo $data['nama'] ?>
                </h6>
                <a href="#" data-bs-toggle="modal" data-bs-target="#passModal" class="btn btn-primary">Ganti
                    Password</a>
            </div>
        </div>
        <div class="card shadow col-md-7 ml-3">
            <div class="card-header text-center">
                <h6>Edit Profil</h6>
            </div>
            <div class="card-body">
                <form action="?page=profil" method="post" name="editprofil" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="<?php echo $data['nama'] ?>" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Foto</h6>
                        </div>
                        <div class="col-sm-9 align-items-center text-center">
                            <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png"
                                onchange="return valid();">
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
                    <button type="submit" name="editprofil" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=profil" method="post" name="gpass">
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="passlama" class="col-sm-3 col-form-label">Password Lama</label>
                        <div class="col-sm-9">
                            <input type="password" name="passlama" id="passlama" class="form-control"
                                placeholder="Masukan Password Lama" required>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 row">
                        <label for="passbaru" class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" name="passbaru" id="passbaru" class="form-control"
                                placeholder="Masukan Password Baru" required>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 row">
                        <label for="passbarukonf" class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" name="passbarukonf" id="passbarukonf" class="form-control"
                                placeholder="Konfirmasi Password Baru" required>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="gantipass" id="gantipass" class="btn btn-primary">Ganti</button>
                </div>
            </form>
        </div>
    </div>
</div>