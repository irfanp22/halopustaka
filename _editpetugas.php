<?php
if ($_SESSION['level'] == "petugas") {
    header("Location: dashboard.php");
}
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "pengurus") {
        header("Location: index.php");
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
    $data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengurus WHERE id_pengurus = '$id'"));
}

if (isset($_POST['editpetugas'])) {
    $id = $_SESSION['id'];
    $nama = $_POST['nama'];
    $lvl = $_POST['lvl'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $konpass = $_POST['konpass'];
        if (!password_verify($konpass, $password)) {
            echo "<script>
                    swal('Password Baru Tidak Sama!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=editpetugas&id=" . $id . "');
                    })
                </script>";
            exit;
        }
    }

    if (!empty($_FILES['pic']['name'])) {
        $namafoto = $id . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/pengurus/" . $namafoto;
        $dir = "pengurus/";
        $foto = $dir . $namafoto;
        if (!empty($password))
            $query = "UPDATE pengurus SET nama = '$nama', password = '$password', level = '$lvl', pic = '$foto' WHERE id_pengurus='$id'";
        else
            $query = "UPDATE pengurus SET nama = '$nama', level = '$lvl', pic = '$foto' WHERE id_pengurus='$id'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            echo "<script>
                swal('Data Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewpetugas');
                });
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=editpetugas&id=" . $id . "');
                });
                </script>";
            exit;
        }
    } else {
        if (!empty($password))
            $query = "UPDATE pengurus SET nama = '$nama', password = '$password', level = '$lvl' WHERE id_pengurus='$id'";
        else
            $query = "UPDATE pengurus SET nama = '$nama', level = '$lvl' WHERE id_pengurus='$id'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            echo "<script>
                swal('Data Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewpetugas');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=editpetugas&id=" . $id . "');
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
            <h4 class="text-center mt-3 mb-3">Edit Petugas</h4>
            <form action="dashboard.php?page=editpetugas" method="post" name="editpetugas"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nama</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama"
                            value="<?php echo $data['nama'] ?>" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Level</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="radio" name="lvl" id="owner" value="owner" <?php if ($data['level'] == "owner")
                            echo "checked" ?> required>
                            <label for="owner">Owner</label><br>
                            <input type="radio" name="lvl" id="petugas" value="petugas" <?php if ($data['level'] == "petugas")
                            echo "checked" ?> required>
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
                            <img src="assets/img/<?php echo $data['pic'] ?>" id="display" alt="pic" width="150">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Password Baru</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukan Password Baru">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Konfirmasi Password Baru</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="password" name="konpass" id="konpass" class="form-control"
                            placeholder="Konfirmasi Password Baru">
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary" name="editpetugas">Edit</button>
            </form>
        </div>
    </div>
</div>