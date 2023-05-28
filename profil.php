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

if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];
    $sql = mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id_peminjaman='$id_peminjaman'");
    if ($sql) {
        echo "<script>swal('Permintaan Peminjaman Dibatalkan', '', 'success').then(function(){
            window.location.assign('profil.php');
        });</script>";
    } else {
        echo "<script>swal('Permintaan Peminjaman Gagal Dibatalkan', '', 'error').then(function(){
            window.location.assign('profil.php');
        });</script>";
    }
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="text-center">Data Profil</h4>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NIM</h6>
                        </div>
                        <div class="col-sm-9 text-secondary text-uppercase">
                            <?php echo $data['nim'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary text-capitalize">
                            <?php echo $data['nama'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $data['email'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">No HP</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $data['no_hp'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Jenis Kelamin</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php if ($data['jenis_kelamin'] == "l")
                                echo "Laki-laki";
                            else
                                echo "Perempuan" ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Alamat</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <?php echo $data['alamat'] ?>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mt-4">
                <div class="card-body text-center">
                    <img src="assets/img/<?php echo $data['pic'] ?>" alt="<?php echo $data['nama'] ?>" width="150">
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="text-center">Riwayat Peminjaman</h4>
            <table id="riwayat" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID Peminjaman</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM peminjaman JOIN buku ON peminjaman.id_buku COLLATE utf8mb4_unicode_ci = buku.id_buku WHERE nim = '$user'";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $data["id_peminjaman"] ?>
                            </td>
                            <td>
                                <?php echo $data["judul"] ?>
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
                            <td>
                                <span class="badge 
                                    <?php if ($data['status'] == 'done')
                                        echo 'bg-success';
                                    elseif ($data['status'] == 'process')
                                        echo 'bg-primary';
                                    else
                                        echo 'bg-warning'; ?> text-uppercase">
                                    <?php echo $data["status"] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($data['status'] == 'book')
                                    echo '<a href="profil.php?id=' . $data["id_peminjaman"] . '" class="btn btn-danger confirmAlert" id="btnhapus">Batal</a>' ?>
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

<?php
include "template/foot.php";
?>