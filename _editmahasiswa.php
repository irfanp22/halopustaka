<?php
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "pengurus") {
        header("Location: index.php");
    }
}

if (isset($_GET['id'])) {
    $nim = $_GET['id'];
    $_SESSION['nim'] = $nim;
    $data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM anggota WHERE nim = '$nim'"));
}

if (isset($_POST['editmahasiswa'])) {
    $nimlama = $_SESSION['nim'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nohp = $_POST['nohp'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $konpass = $_POST['konpass'];
        if (!password_verify($konpass, $password)) {
            echo "<script>
                    swal('Password Baru Tidak Sama!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=editmahasiswa&id=" . $_SESSION['nim'] . "');
                    })
                </script>";
            exit;
        }
    }
    if ($nimlama != $nim) {
        $result = mysqli_query($koneksi, "SELECT nim FROM anggota WHERE nim = '$nim'");
        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                    swal('NIM Sudah Terdaftar!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=viewmahasiswa');
                    })
                  </script>";
            exit;
        }
    }

    if (!empty($_FILES['pic']['name'])) {
        $namafoto = $_POST['nim'] . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/anggota/" . $namafoto;
        $dir = "anggota/";
        $foto = $dir . $namafoto;
        if (!empty($password)) {
            $query = "UPDATE anggota SET nim='$nim', nama='$nama', password='$password', email='$email', no_hp='$nohp', alamat='$alamat', jenis_kelamin='$jk', pic='$foto' WHERE nim = '$nimlama'";
        } else
            $query = "UPDATE anggota SET nim='$nim', nama='$nama', email='$email', no_hp='$nohp', alamat='$alamat', jenis_kelamin='$jk', pic='$foto' WHERE nim = '$nimlama'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            echo "<script>
                swal('Data Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewmahasiswa');
                });
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=editmahasiswa&id=" . $_SESSION['nim'] . "');
                });
                </script>";
            exit;
        }
    } else {
        if (!empty($password)) {
            $query = "UPDATE anggota SET nim='$nim', nama='$nama', password='$password', email='$email', no_hp='$nohp', alamat='$alamat', jenis_kelamin='$jk' WHERE nim = '$nimlama'";
        } else
            $query = "UPDATE anggota SET nim='$nim', nama='$nama', email='$email', no_hp='$nohp', alamat='$alamat', jenis_kelamin='$jk' WHERE nim = '$nimlama'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            echo "<script>
                swal('Data Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewmahasiswa');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=editmahasiswa&id=" . $_SESSION['nim'] . "');
                });
                </script>";
            exit;
        }
    }
}
?>
<div class="container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <h4 class="text-center mt-3 mb-3">Edit Data Mahasiswa</h4>
            <form action="dashboard.php?page=editmahasiswa" method="post" name="editmahasiswa"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">NIM</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="nim" id="nim" class="form-control" value="<?php echo $data['nim'] ?>"
                            required>
                    </div>
                </div>
                <hr>
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
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email"
                            value="<?php echo $data['email'] ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">No HP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="nohp" id="nohp" class="form-control" placeholder="Masukan No HP"
                            value="<?php echo $data['no_hp'] ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Jenis Kelamin</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="radio" name="jk" id="lakilaki" value="l" <?php if ($data['jenis_kelamin'] == 'l')
                            echo "checked" ?> required>
                            <label for="lakilaki">Laki-laki</label><br>
                            <input type="radio" name="jk" id="perempuan" value="p" <?php if ($data['jenis_kelamin'] == 'p')
                            echo "checked" ?> required>
                            <label for="perempuan">Perempuan</label>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Alamat</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"
                                placeholder="Masukan Alamat"><?php echo $data['alamat'] ?></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Foto</h6>
                    </div>
                    <div class="col-sm-9 align-items-center text-center">
                        <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png" onchange="return valid();">
                        <img src="assets/img/<?php echo $data['pic'] ?>" id="display" alt="<?php echo $data['nama'] ?>"
                            width="150">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Password Baru</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukan Password">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Konfirmasi Password Baru</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" name="konpass" id="konpass" class="form-control"
                            placeholder="Konfirmasi Password">
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary" name="editmahasiswa">Edit</button>
            </form>
        </div>
    </div>
</div>