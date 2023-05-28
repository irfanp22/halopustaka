<?php
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "pengurus") {
        header("Location: index.php");
    }
}
include "trigger.php";
$tahun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT YEAR(current_date()) AS thn"));

if (isset($_POST['tambahkategori'])) {
    $nama = $_POST['namakategori'];
    $id = before_insert_kategori();
    $sql = mysqli_query($koneksi, "INSERT INTO kategori(id_kategori, nama_kategori) VALUES('$id', '$nama')");
    if ($sql) {
        echo "<script>
            swal('Kategori baru berhasil ditambahkan!', '', 'success');
        </script>";
    } else {
        echo "<script>
            swal('Kategori baru gagal ditambahkan!', '', 'error');
        </script>";
    }
}

if (isset($_POST['tambahrak'])) {
    $id = $_POST['idrak'];
    $nama = $_POST['namarak'];
    $sql = mysqli_query($koneksi, "INSERT INTO rak(id_rak, nama_rak) VALUES('$id', '$nama')");
    if ($sql) {
        echo "<script>
            swal('Rak baru berhasil ditambahkan!', '', 'success');
        </script>";
    } else {
        echo "<script>
            swal('Rak baru gagal ditambahkan!', '', 'error');
        </script>";
    }
}

if (isset($_POST['tambahbuku'])) {
    $id = before_insert_buku();
    $judul = $_POST['judul'];
    $isbn = $_POST['isbn'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $thnterbit = $_POST['thnterbit'];
    $stok = $_POST['stok'];
    $keterangan = $_POST['keterangan'];
    $kategori = $_POST['kategori'];
    $rak = $_POST['rak'];
    if ($stok < 0) {
        echo "<script>
                    swal('Stok tidak boleh minus!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=tbuku');
                    })
                  </script>";
        exit;
    }
    if ($thnterbit < 1900 || $thnterbit > $tahun['thn']) {
        echo "<script>
                    swal('Masukan tahun terbit yang sesuai!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=tbuku');
                    })
                  </script>";
        exit;
    }

    if (!empty($_FILES['pic']['name'])) {
        if ($query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT id_buku FROM buku ORDER BY id_buku DESC LIMIT 1"))) {
            $idprev = $query['id_buku'];
            $awl = substr($idprev, 0, 2);
            $no = intval(end(explode('K', $idprev, 3))) + 1;
            $id = $awl . sprintf("%03d", $no);
        } else {
            $id = "BK001";
        }
        $namafoto = $id . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "assets/img/buku/" . $namafoto;
        $dir = "buku/";
        $foto = $dir . $namafoto;
        $query = "INSERT INTO buku(id_buku, judul, isbn, pengarang, penerbit, tahun_terbit, stok, keterangan, id_kategori, id_rak, pic) VALUES('$id', '$judul', '$isbn', '$pengarang', '$penerbit', '$thnterbit', '$stok', '$keterangan', '$kategori', '$rak','$foto')";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            echo "<script>
                swal('Data Buku Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewbuku');
                })
                </script>";
        } else
            echo "<script>
                swal('Data Buku Gagal Ditambahkan!', '', 'error');
                </script>";
    } else {
        $query = "INSERT INTO buku(id_buku, judul, isbn, pengarang, penerbit, tahun_terbit, stok, keterangan, id_kategori, id_rak) VALUES('$id', '$judul', '$isbn', '$pengarang', '$penerbit', '$thnterbit', '$stok', '$keterangan', '$kategori', '$rak')";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            echo "<script>
                swal('Data Buku Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewbuku');
                })
                </script>";
        } else
            echo "<script>
                swal('Data Buku Gagal Ditambahkan!', '', 'error');
                </script>";
    }
}
?>
<div class="container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <h4 class="text-center mt-3 mb-3">Tambah Buku Perpustakaan</h4>
            <form action="dashboard.php?page=tbuku" method="post" name="tambahbuku" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Judul</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Buku"
                            required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">ISBN</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Masukan ISBN"
                            required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Pengarang</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="pengarang" id="pengarang" class="form-control"
                            placeholder="Masukan Pengarang" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Penerbit</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="penerbit" id="penerbit" class="form-control"
                            placeholder="Masukan Penerbit" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tahun Terbit</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="1900" max="<?php echo $tahun['thn'] ?>" name="thnterbit"
                            id="thnterbit" class="form-control" placeholder="Masukan Tahun Terbit" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Stok</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="0" name="stok" id="stok" class="form-control"
                            placeholder="Masukan Stok" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Keterangan</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="keterangan" id="keterangan" class="form-control"
                            placeholder="Masukan Keterangan">
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
                            while ($data = mysqli_fetch_array($sql))
                                echo '
                                <option value="' . $data['id_kategori'] . '" class="form-control">' . $data['nama_kategori'] . '</option>'
                                    ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#kategoriModal"
                                class="btn btn-primary">Tambah Kategori</a>
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
                            while ($data = mysqli_fetch_array($sql))
                                echo '
                                <option value="' . $data['id_rak'] . '" class="form-control">' . $data['nama_rak'] . '</option>'
                                    ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#rakModal" class="btn btn-primary">Tambah
                                Rak</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Jilid</h6>
                        </div>
                        <div class="col-sm-9 align-items-center text-center">
                            <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png" onchange="return valid();">
                            <img src="" id="display" alt="pic" width="150" hidden>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary" name="tambahbuku">Tambah Buku</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="dashboard.php?page=tbuku" method="post" name="tambahkategori">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Nama Kategori</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="namakategori" id="namakategori" class="form-control"
                                    placeholder="Masukan Nama Kategori" required>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="tambahkategori" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rakModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Rak</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="dashboard.php?page=tbuku" method="post" name="tambahrak">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ID Rak</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="idrak" id="idrak" class="form-control" placeholder="Masukan ID Rak"
                                    required>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Nama Rak</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" name="namarak" id="namarak" class="form-control"
                                    placeholder="Masukan Nama Rak" required>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="tambahrak" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>