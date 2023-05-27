<?php
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "pengurus") {
        header("Location: index.php");
    }
}

if (isset($_POST['tambahmahasiswa'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nohp = $_POST['nohp'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $konpass = $_POST['konpass'];

    if (!password_verify($konpass, $password)) {
        echo "<script>
                swal('Password Tidak Sama!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=tmahasiswa');
                })
            </script>";
        exit;
    }
    $result = mysqli_query($koneksi, "SELECT nim FROM anggota WHERE nim = '$nim'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                swal('NIM Sudah Terdaftar!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=tmahasiswa');
                })
		      </script>";
        exit;
    }

    if (!empty($_FILES['pic']['name'])) {
        $namafoto = $nim . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/anggota/" . $namafoto;
        $dir = "anggota/";
        $foto = $dir . $namafoto;
        $query = "INSERT INTO anggota VALUES('$nim', '$nama', '$password', '$email', '$nohp', '$alamat', '$jk','$foto')";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            echo "<script>
                swal('User Baru Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewmahasiswa');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('User Baru Gagal Ditambahkan!', '', 'error');
                </script>";
            exit;
        }
    } else {
        $query = "INSERT INTO anggota(nim, nama, password, email, no_hp, alamat, jenis_kelamin) VALUES('$nim', '$nama', '$password', '$email', '$nohp', '$alamat', '$jk')";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            echo "<script>
                swal('User Baru Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewmahasiswa');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('User Baru Gagal Ditambahkan!', '', 'error');
                </script>";
            exit;
        }
    }
}
?>
<div class="container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <h4 class="text-center mt-3 mb-3">Pendaftaran Anggota Perpustakaan</h4>
            <form action="dashboard.php?page=tmahasiswa" method="post" name="tambahmahasiswa"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">NIM</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="nim" id="nim" class="form-control" placeholder="Masukan NIM" required>
                    </div>
                </div>
                <hr>
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
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">No HP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="nohp" id="nohp" class="form-control" placeholder="Masukan No HP">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Jenis Kelamin</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="radio" name="jk" id="lakilaki" value="l" required>
                        <label for="lakilaki">Laki-laki</label><br>
                        <input type="radio" name="jk" id="perempuan" value="p" required>
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
                            placeholder="Masukan Alamat"></textarea>
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
                <button type="submit" class="btn btn-primary" name="tambahmahasiswa">Tambah Mahasiswa</button>
            </form>
        </div>
    </div>
</div>