<?php
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "pengurus") {
        header("Location: index.php");
    }
}
$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id'"));
$tahun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT YEAR(current_date()) AS thn"));

if (isset($_POST['editbuku'])) {
    $id = $_GET['id'];
    $judul = $_POST['judul'];
    $isbn = $_POST['isbn'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $thnterbit = $_POST['thnterbit'];
    $stok = $_POST['stok'];
    $keterangan = $_POST['keterangan'];
    $kategori = $_POST['kategori'];
    $rak = $_POST['rak'];
    $onprocess = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_buku) AS stok FROM peminjaman WHERE id_buku = '$id' AND status !='done'"));
    $cek = $stok - $onprocess['stok'];
    if ($cek < 0) {
        echo "<script>
                    swal('Stok tidak boleh minus!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=viewbuku');
                    })
                  </script>";
        exit;
    }
    if ($thnterbit < 1900 || $thnterbit >= $tahun['thn']) {
        echo "<script>
                    swal('Masukan tahun terbit yang sesuai!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=viewbuku');
                    })
                  </script>";
        exit;
    }

    if (!empty($_FILES['pic']['name'])) {
        $namafoto = $id . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/buku/" . $namafoto;
        $dir = "buku/";
        $foto = $dir . $namafoto;
        $query = "UPDATE buku SET judul = '$judul', isbn = '$isbn', pengarang = '$pengarang', penerbit = '$penerbit', tahun_terbit = '$thnterbit', stok = '$stok', keterangan = '$keterangan', id_kategori = '$kategori', id_rak = '$rak', pic = '$foto' WHERE id_buku = '$id'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            echo "<script>
                swal('Data Buku Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewbuku');
                })
                </script>";
        } else
            echo "<script>
                swal('Data Buku Gagal Diedit!', '', 'error');
                </script>";
    } else {
        $query = "UPDATE buku SET judul = '$judul', isbn = '$isbn', pengarang = '$pengarang', penerbit = '$penerbit', tahun_terbit = '$thnterbit', stok = '$stok', keterangan = '$keterangan', id_kategori = '$kategori', id_rak = '$rak' WHERE id_buku = '$id'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            echo "<script>
                swal('Data Buku Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewbuku');
                })
                </script>";
        } else
            echo "<script>
                swal('Data Buku Gagal Diedit!', '', 'error');
                </script>";
    }
}
?>
<div class="container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <h4 class="text-center mt-3 mb-3">Edit Buku Perpustakaan</h4>
            <form action="dashboard.php?page=editbuku&id=<?php echo $_GET['id'] ?>" method="post" name="editbuku"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Judul</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Buku"
                            value="<?php echo $data['judul'] ?>" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">ISBN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Masukan ISBN"
                            value="<?php echo $data['isbn'] ?>" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Pengarang</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="pengarang" id="pengarang" class="form-control"
                            placeholder="Masukan Pengarang" value="<?php echo $data['pengarang'] ?>" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Penerbit</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="penerbit" id="penerbit" class="form-control"
                            placeholder="Masukan Penerbit" value="<?php echo $data['penerbit'] ?>" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tahun Terbit</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="1900" max="<?php echo $tahun['thn'] ?>" name="thnterbit"
                            id="thnterbit" class="form-control" placeholder="Masukan Tahun Terbit"
                            value="<?php echo $data['tahun_terbit'] ?>" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Stok</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="0" name="stok" id="stok" class="form-control"
                            placeholder="Masukan Stok" value="<?php echo $data['stok'] ?>" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Keterangan</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="keterangan" id="keterangan" class="form-control"
                            placeholder="Masukan Keterangan" value="<?php echo $data['keterangan'] ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Kategori</h6>
                    </div>
                    <div class="col-sm-5 text-secondary">
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="" class="form-control">-- pilih kategori --</option>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($kategori = mysqli_fetch_array($sql)) {
                                if ($data['id_kategori'] == $kategori['id_kategori'])
                                    echo '
                                <option value="' . $kategori['id_kategori'] . '" class="form-control" selected>' . $kategori['nama_kategori'] . '</option>';
                                else
                                    echo '<option value="' . $kategori['id_kategori'] . '" class="form-control">' . $kategori['nama_kategori'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Rak</h6>
                    </div>
                    <div class="col-sm-5 text-secondary">
                        <select name="rak" id="rak" class="form-control" required>
                            <option value="" class="form-control">-- pilih rak --</option>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT * FROM rak");
                            while ($rak = mysqli_fetch_array($sql)) {
                                if ($data['id_rak'] == $rak['id_rak'])
                                    echo '
                                <option value="' . $rak['id_rak'] . '" class="form-control" selected>' . $rak['nama_rak'] . '</option>';
                                else
                                    echo '<option value="' . $rak['id_rak'] . '" class="form-control">' . $rak['nama_rak'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Jilid</h6>
                    </div>
                    <div class="col-sm-9 align-items-center text-center">
                        <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png" onchange="return valid();">
                        <img src="assets/img/<?php echo $data['pic'] ?>" id="display" alt="pic" width="150" <?php if (!isset($data['pic']))
                               echo "hidden" ?>>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary" name="editbuku">Edit Buku</button>
                </form>
            </div>
        </div>
    </div>