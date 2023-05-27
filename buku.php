<?php
$title = "Daftar Buku";
$css = "style.css";
session_start();
include "template/head.php";
include "template/nav.php";
include "koneksi.php";
if (isset($_SESSION['username']) && $_SESSION['role'] == "pengurus")
    header('location: dashboard.php');

?>

<div class="container">
    <div class="card mt-3">
        <div class="card-body">
            <h4 class="text-center mt-3">Daftar Buku</h4>
            <table id="table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">ID Buku</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Tahun Terbit</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Tersedia</th>
                        <th style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT buku.id_buku, buku.isbn, buku.judul, buku.pengarang, buku.tahun_terbit, buku.stok, kategori.nama_kategori, rak.nama_rak FROM buku JOIN kategori ON buku.id_kategori COLLATE utf8mb4_unicode_ci = kategori.id_kategori JOIN rak ON buku.id_rak COLLATE utf8mb4_unicode_ci = rak.id_rak";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $data["id_buku"] ?>
                            </td>
                            <td>
                                <?php echo $data["judul"] ?>
                            </td>
                            <td>
                                <?php echo $data["pengarang"] ?>
                            </td>
                            <td>
                                <?php echo $data["tahun_terbit"] ?>
                            </td>
                            <td>
                                <?php echo $data["nama_kategori"] ?>
                            </td>
                            <td>
                                <?php echo $data["stok"] ?>
                            </td>
                            <?php
                            $id = $data['id_buku'];
                            $sedia = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_buku) AS sedia FROM peminjaman WHERE id_buku = '$id' AND status != 'done'"));
                            ?>
                            <td>
                                <?php echo $data['stok'] - $sedia['sedia'] ?>
                            </td>
                            <td>
                                <button type="buttton" class="btn btn-success btndetailbuku" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" data-id="<?php echo $data['id_buku'] ?>"><i
                                        class="fas fa-circle-info"></i></button>
                                <?php if (isset($_SESSION['username'])) {
                                    $buku = $data['id'];
                                    echo '<a href="#" class="btn btn-primary confirmPinjam" data-id_buku="' . $data["id_buku"] . '" data-nim="' . $_SESSION['username'] . '" data-judul="' . $data['judul'] . '" data-sedia="' . ($data['stok'] - $sedia['sedia']) . '" id="btnbook">Pinjam</a>';
                                } ?>
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

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ID Buku</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="id_buku"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">ISBN</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="isbn"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Judul</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="judul"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Kategori</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="kategori"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Lokasi</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="rak"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Pengarang</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="pengarang"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Penerbit</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="penerbit"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Tahun Terbit</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="thnterbit"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Stok Buku</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="stok"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Buku Tersedia</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="sedia"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Keterangan</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="keterangan"></p>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-lg-4">
                        <img src="" alt="jilid" id="jilid" width="150px">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php
include("template/foot.php");
?>