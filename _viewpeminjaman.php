<?php
include "trigger.php";
if (isset($_POST['tambahpeminjaman'])) {
    $id = before_insert_peminjaman();
    $id_buku = $_POST['id_buku'];
    $nim = $_POST['nim'];
    $status = "process";
    $tgl = date('Y-m-d H:i:s');
    $query = "INSERT INTO peminjaman(id_peminjaman, id_buku, nim, tanggal_pinjam, status) VALUES('$id', '$id_buku', '$nim', '$tgl', '$status')";
    $sql = mysqli_query($koneksi, $query);
    if ($sql) {
        echo "<script>
                swal('Data Peminjaman Berhasil Ditambahkan!', '', 'success')
                </script>";
    } else
        echo "<script>
                swal('Data Peminjaman Gagal Ditambahkan!', '', 'error');
                </script>";
}

if (isset($_POST['editpeminjaman'])) {
    $id = $_POST['id_peminjaman'];
    $id_buku = $_POST['id_buku'];
    $nim = $_POST['nim'];
    $tgl = date('Y-m-d H:i:s');
    $query = "UPDATE peminjaman SET id_buku = '$id_buku', nim = '$nim', tanggal_pinjam = '$tgl' WHERE id_peminjaman = '$id'";
    $sql = mysqli_query($koneksi, $query);
    if ($sql) {
        echo "<script>
                swal('Data Peminjaman Berhasil Diedit!', '', 'success')
                </script>";
    } else
        echo "<script>
                swal('Data Peminjaman Gagal Diedit!', '', 'error');
                </script>";
}

if (isset($_GET['id_del'])) {
    $id = htmlspecialchars($_GET["id_del"]);
    $sql = "DELETE FROM peminjaman WHERE id_peminjaman='$id'";
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil) {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
            window.location.assign('?page=viewpeminjaman');
        });</script>";
    } else {
        echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
            window.location.assign('?page=viewpeminjaman');
        });</script>";
    }
}
if (isset($_GET['id_acc'])) {
    $id = htmlspecialchars($_GET["id_acc"]);
    $tgl = date('Y-m-d H:i:s');
    $sql = "UPDATE peminjaman SET tanggal_pinjam = '$tgl', status = 'process' WHERE id_peminjaman='$id'";
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil) {
        echo "<script>swal('Peminjaman Berhasil Dikonfirmasi', '', 'success').then(function(){
            window.location.assign('?page=viewpeminjaman');
        });</script>";
    } else {
        echo "<script>swal('Peminjaman Gagal Dikonfirmasi', '', 'error').then(function(){
            window.location.assign('?page=viewpeminjaman');
        });</script>";
    }
}
?>

<div class="container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <div class="row mt-3 mb-3">
                <div class="col-md-9">
                    <h4 class="text-center">Daftar Peminjaman Buku</h4>
                </div>
                <div class="col-md-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#peminjamanModal" class="btn btn-primary">Tambah
                        Peminjaman</a>
                </div>
            </div>
            <table id="table2" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">ID Peminjaman</th>
                        <th style="width: 0;">ID Buku</th>
                        <th style="width: 0;">NIM</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th style="width: 115px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hasil = mysqli_query($koneksi, "SELECT * FROM peminjaman");
                    while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $data["id_peminjaman"] ?>
                            </td>
                            <td>
                                <?php echo $data["id_buku"] ?>
                            </td>
                            <td>
                                <?php echo $data["nim"] ?>
                            </td>
                            <td>
                                <?php echo $data["tanggal_pinjam"] ?>
                            </td>
                            <td>
                                <?php echo $data["tanggal_kembali"] ?>
                            </td>
                            <td>
                                <?php echo $data["denda"] ?>
                            </td>
                            <td class="badge <?php
                            if ($data['status'] == 'done')
                                echo "bg-success";
                            elseif ($data['status'] == 'process')
                                echo "bg-primary";
                            else
                                echo "bg-warning"
                                    ?> text-light text-uppercase" style="text-align: center;">
                                <?php echo $data['status'] ?>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#detailModal"
                                    data-id="<?php echo $data['id_peminjaman'] ?>"
                                    class="btn btn-primary btndetailpeminjaman"><i class="fas fa-circle-info"></i></a>
                                <?php
                                if ($data['status'] == 'book')
                                    echo '<a href="?page=viewpeminjaman&id_acc=' . $data['id_peminjaman'] . '" class="btn btn-success confirmAcc" id="btnacc"><i class="fas fa-check"></i></a>';
                                elseif ($data['status'] == 'process')
                                    echo '<a href="#" class="btn btn-warning text-light btneditpeminjaman" data-bs-toggle="modal" data-bs-target="#editPeminjaman" data-id="' . $data["id_peminjaman"] . '"><i class="fas fa-pen-to-square"></i></a>';
                                ?>
                                <a href="?page=viewpeminjaman&id_del=<?php echo $data['id_peminjaman'] ?>"
                                    class="btn btn-danger confirmAlert" id="btnhapus"><i class="fas fa-trash"></i></a>
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


<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Peminjaman</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="mb-0">ID Peminjaman</h6>
                    </div>
                    <div class="col-sm-8 text-secondary text-uppercase">
                        <p class="id_peminjaman"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="mb-0">Buku</h6>
                    </div>
                    <div class="col-sm-8 text-secondary text-uppercase">
                        <p class="buku"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="mb-0">Anggota</h6>
                    </div>
                    <div class="col-sm-8 text-secondary text-uppercase">
                        <p class="anggota"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="mb-0">Tanggal Pinjam</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                        <p class="tanggal_pinjam"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="mb-0">Tanggal Kembali</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                        <p class="tanggal_kembali"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="mb-0">Denda</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                        <p class="denda"></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="col-sm-8 text-secondary text-uppercase">
                        <span class="badge" id="badge"></span>
                    </div>
                </div>
                <hr>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="peminjamanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Peminjaman</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="dashboard.php?page=viewpeminjaman" method="post" name="tambahpeminjaman">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Buku</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <select name="id_buku" id="id_buku" class="form-control" required>
                                <option value="">-- pilih buku --</option>
                                <?php
                                $sql = mysqli_query($koneksi, "SELECT * FROM buku");
                                while ($data = mysqli_fetch_array($sql)) {
                                    $sedia = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_buku) AS sedia FROM peminjaman WHERE id_buku='" . $data['id_buku'] . "' AND status != 'done'"));
                                    if (($data['stok'] - $sedia['sedia']) > 0) {
                                        echo '<option value="' . $data['id_buku'] . '">' . $data['id_buku'] . ' - ' . $data['judul'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Anggota</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <select name="nim" id="inpnim" class="form-control" required>
                                <option value="" class="form-control">-- pilih anggota --</option>
                                <?php
                                $sql = mysqli_query($koneksi, "SELECT * FROM anggota");
                                while ($data = mysqli_fetch_array($sql))
                                    echo '<option value="' . $data['nim'] . '" class="form-control">' . $data['nim'] . ' - ' . $data['nama'] . '</option>'
                                        ?>
                                </select>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="tambahpeminjaman">Tambah Peminjaman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPeminjaman" tabindex="-1" data-bs-focus="false" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Peminjaman</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="dashboard.php?page=viewpeminjaman" method="post" name="epeminjaman">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_peminjaman" class="id_peminjaman">
                            <div class="col-sm-4">
                                <h6 class="mb-0">Buku</h6>
                            </div>
                            <div class="col-sm-8 text-secondary">
                                <select name="id_buku" id="id_buku_edit" class="form-control" required>
                                    <option value="" class="form-control">-- pilih buku --</option>
                                    <?php
                                $sql = mysqli_query($koneksi, "SELECT * FROM buku");
                                while ($data = mysqli_fetch_array($sql)) {
                                    echo '<option value="' . $data['id_buku'] . '" class="form-control">' . $data['id_buku'] . ' - ' . $data['judul'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Anggota</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <select name="nim" id="nim_edit" class="form-control" required>
                                <option value="" class="form-control">-- pilih anggota --</option>
                                <?php
                                $sql = mysqli_query($koneksi, "SELECT * FROM anggota");
                                while ($data = mysqli_fetch_array($sql))
                                    echo '<option value="' . $data['nim'] . '" class="form-control">' . $data['nim'] . ' - ' . $data['nama'] . '</option>';
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="editpeminjaman" id="editpeminjaman"
                        class="btn btn-primary">Edit</button>
                    <a href="#" class="btn btn-success confirmKembali" id="btnkembali" data-id="">Konfirmasi
                        Pengembalian</a>
                </div>
            </form>
        </div>
    </div>
</div>