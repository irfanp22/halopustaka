<?php
if ($_SESSION['level'] != "owner") {
    header("Location: dashboard.php");
}

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);
    $hasil = mysqli_query($koneksi, "DELETE FROM pengurus WHERE id_pengurus='$id'");
    if ($hasil) {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
            window.location.assign('?page=viewpetugas');
        });</script>";
    } else {
        echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
            window.location.assign('?page=viewpetugas');
        });</script>";
    }
}
?>

<div class="container">
    <div class="card mt-3">
        <div class="card-body">
            <h4 class="text-center mt-3 mb-3">Daftar Petugas</h4>
            <table id="table6" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">ID_Petugas</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th>Foto</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = $_SESSION['username'];
                    $hasil = mysqli_query($koneksi, "SELECT * FROM pengurus WHERE id_pengurus!='$id'");
                    while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $data["id_pengurus"] ?>
                            </td>
                            <td class="text-capitalize">
                                <?php echo $data["nama"] ?>
                            </td>
                            <td class="text-capitalize">
                                <?php echo $data["level"] ?>
                            </td>
                            <td><img src="assets/img/<?php echo $data["pic"] ?>" alt="<?php echo $data["nama"] ?>"
                                    width="100px"></td>
                            <td><a href="?page=editpetugas&id=<?php echo $data['id_pengurus'] ?>"
                                    class="btn btn-warning text-light" id="btnedit"><i class="fas fa-pen-to-square"></i></a>
                                <a href="?page=viewpetugas&id=<?php echo $data['id_pengurus'] ?>"
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