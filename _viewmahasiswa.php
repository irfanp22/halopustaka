<?php
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);
    mysqli_query($koneksi, "DELETE FROM peminjaman WHERE nim='$id'");
    $sql = "DELETE FROM anggota WHERE nim='$id'";
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil) {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
            window.location.assign('?page=viewmahasiswa');
        });</script>";
    } else {
        echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
            window.location.assign('?page=viewmahasiswa');
        });</script>";
    }
}
?>

<div class="container">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <h4 class="text-center mt-3 mb-3">Daftar Mahasiswa</h4>
            <table id="table5" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">NIM</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Foto</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hasil = mysqli_query($koneksi, "SELECT * FROM anggota");
                    while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $data["nim"] ?>
                            </td>
                            <td class="text-capitalize">
                                <?php echo $data["nama"] ?>
                            </td>
                            <td>
                                <?php if ($data['jenis_kelamin'] == "l")
                                    echo "Laki-laki";
                                else
                                    echo "Perempuan" ?>
                                </td>
                                <td><img src="assets/img/<?php echo $data["pic"] ?>" alt="<?php echo $data["nama"] ?>"
                                    width="100px"></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#detailModal"
                                    data-id="<?php echo $data['nim'] ?>" class="btn btn-success btndetailmahasiswa"
                                    data-id="<?php echo $data["nim"] ?>"><i class="fas fa-circle-info"></i></a>
                                <a href="?page=editmahasiswa&id=<?php echo $data['nim'] ?>"
                                    class="btn btn-warning text-light" id="btnedit"><i class="fas fa-pen-to-square"></i></a>
                                <a href="?page=viewmahasiswa&id=<?php echo $data['nim'] ?>"
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Mahasiswa</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">NIM</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="nim"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Nama</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="nama"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-lowercase">
                                <p class="email"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">No HP</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="nohp"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Alamat</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="alamat"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Jenis Kelamin</h6>
                            </div>
                            <div class="col-sm-9 text-secondary text-uppercase">
                                <p class="jenis_kelamin"></p>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-lg-4">
                        <img src="" alt="pic" id="pic" width="150px">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>