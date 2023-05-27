<?php
if (isset($_POST['tambahkategori'])) {
    $nama = $_POST['namakategori'];
    $sql = mysqli_query($koneksi, "INSERT INTO kategori(nama_kategori) VALUES('$nama')");
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
if (isset($_POST['editkategori'])) {
    $id = $_POST['idkategori'];
    $nama = $_POST['namakategori'];
    $sql = mysqli_query($koneksi, "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori = '$id'");
    if ($sql) {
        echo "<script>
            swal('Data kategori berhasil diedit!', '', 'success');
        </script>";
    } else {
        echo "<script>
            swal('Data kategori gagal diedit!', '', 'error');
        </script>";
    }
}

if (isset($_POST['editrak'])) {
    $id = $_POST['idrak'];
    $nama = $_POST['namarak'];
    $sql = mysqli_query($koneksi, "UPDATE rak SET id_rak = '$id', nama_rak = '$nama' WHERE id_rak = '$id'");
    if ($sql) {
        echo "<script>
            swal('Data rak berhasil diedit!', '', 'success');
        </script>";
    } else {
        echo "<script>
            swal('Data rak gagal diedit!', '', 'error');
        </script>";
    }
}

if (isset($_GET['idkategori'])) {
    $id = $_GET['idkategori'];
    $sql = mysqli_query($koneksi, "DELETE FROM buku WHERE id_kategori='$id'");
    $sql = mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id'");
    if ($sql) {
        echo "<script>
            swal('Data kategori berhasil dihapus!', '', 'success').then(function(){
                window.location.assign('?page=viewrak');
            });
        </script>";
    } else {
        echo "<script>
            swal('Data kategori gagal dihapus!', '', 'error').then(function(){
                window.location.assign('?page=viewrak');
            });
        </script>";
    }
}

if (isset($_GET['idrak'])) {
    $id = $_GET['idrak'];
    $sql = mysqli_query($koneksi, "DELETE FROM buku WHERE id_rak='$id'");
    $sql = mysqli_query($koneksi, "DELETE FROM rak WHERE id_rak='$id'");
    if ($sql) {
        echo "<script>
            swal('Data rak berhasil dihapus!', '', 'success').then(function(){
                window.location.assign('?page=viewrak');
            });
        </script>";
    } else {
        echo "<script>
            swal('Data rak gagal dihapus!', '', 'error').then(function(){
                window.location.assign('?page=viewrak');
            });
        </script>";
    }
}
?>
<div class="container">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <div class="card border-bottom-success shadow h-100 py-2">
                <div class="row mt-3 mb-3">
                    <h5 class="text-center col-sm-8">Rak</h5>
                    <div class="col-sm-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#rakModal" class="btn btn-primary">Tambah
                            Rak</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table3" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Rak</th>
                                <th>Nama Rak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT * FROM rak");
                            while ($rak = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $rak["id_rak"] ?>
                                    </td>
                                    <td>
                                        <?php echo $rak["nama_rak"] ?>
                                    </td>
                                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#editRak"
                                            data-id="<?php echo $rak["id_rak"] ?>"
                                            data-nama="<?php echo $rak["nama_rak"] ?>"
                                            class="btn btn-warning text-light btneditrak"><i
                                                class="fas fa-pen-to-square"></i></a>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=viewrak&idrak=' . $rak['id_rak'] ?>"
                                            class="btn btn-danger confirmAlert" id="btnhapusrak"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-bottom-primary shadow h-100 py-2">
                <div class="row mt-3 mb-3">
                    <h5 class="text-center col-sm-7">Kategori</h5>
                    <div class="col-sm-5">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#kategoriModal"
                            class="btn btn-primary">Tambah Kategori</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table4" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Kategori</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($kategori = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $kategori["id_kategori"] ?>
                                    </td>
                                    <td>
                                        <?php echo $kategori["nama_kategori"] ?>
                                    </td>
                                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#editKategori"
                                            data-id="<?php echo $kategori["id_kategori"] ?>"
                                            data-nama="<?php echo $kategori["nama_kategori"] ?>"
                                            class="btn btn-warning text-light btneditkateg"><i
                                                class="fas fa-pen-to-square"></i></a>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=viewrak&idkategori=' . $kategori['id_kategori'] ?>"
                                            class="btn btn-danger confirmAlert" id="btnhapuskateg"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
            <form action="dashboard.php?page=viewrak" method="post" name="tkategori">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama Kategori</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="namakategori" class="form-control"
                                placeholder="Masukan Nama Kategori" required>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="tambahkategori" id="tambahkategori"
                        class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="dashboard.php?page=viewrak" method="post" name="ekategori">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama Kategori</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="hidden" name="idkategori" class="idkategori">
                            <input type="text" name="namakategori" class="form-control namakategori"
                                placeholder="Masukan Nama Kategori" required>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="editkategori" id="editkategori" class="btn btn-primary">Edit</button>
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
            <form action="dashboard.php?page=viewrak" method="post" name="tambahrak">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">ID Rak</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="idrak" class="form-control" placeholder="Masukan ID Rak" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama Rak</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="namarak" class="form-control" placeholder="Masukan Nama Rak"
                                required>
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

<div class="modal fade" id="editRak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Rak</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="dashboard.php?page=viewrak" method="post" name="erak">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">ID Rak</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="idrak" class="form-control idrak" placeholder="Masukan ID Rak"
                                required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama Rak</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="namarak" class="form-control namarak"
                                placeholder="Masukan Nama Rak" required>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="editrak" id="editrak" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>