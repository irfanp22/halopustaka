<?php
$title = "Dashboard";
$css = "admin.css";
session_start();
include "template/head.php";
include "koneksi.php";
if (isset($_SESSION['username']) && $_SESSION['role'] == "anggota")
    header('location: index.php');
?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="dashboard.php" class="logo d-flex align-items-center">
            <img src="assets/img/favicon.png" alt="">
            <span class="d-none d-lg-block">Halo Pustaka</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">
                <?php
                $sql = mysqli_query($koneksi, "SELECT pic FROM " . $_SESSION['role'] . " WHERE id_pengurus = '" . $_SESSION['username'] . "'");
                $data = mysqli_fetch_array($sql);
                ?>
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="assets/img/<?php echo $data['pic'] ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        <?php echo $_SESSION['nama'] ?>
                    </span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="?page=profil">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Manajemen Anggota</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=tmahasiswa">
                        <i class="bi bi-circle"></i><span>Tambah Anggota</span>
                    </a>
                </li>
                <li>
                <li>
                    <a href="?page=viewmahasiswa">
                        <i class="bi bi-circle"></i><span>Daftar Anggota</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Manajemen Buku</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=tbuku">
                        <i class="bi bi-circle"></i><span>Tambah Buku</span>
                    </a>
                </li>
                <li>
                    <a href="?page=viewbuku">
                        <i class="bi bi-circle"></i><span>Daftar Buku</span>
                    </a>
                </li>
                <li>
                    <a href="?page=viewrak">
                        <i class="bi bi-circle"></i><span>Rak dan Kategori</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-arrow-down-up"></i><span>Transaksi Buku</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=viewpeminjaman">
                        <i class="bi bi-circle"></i><span>Daftar Peminjaman Buku</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav -->

        <?php
        if ($_SESSION['level'] == 'owner') { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-kanban"></i><span>Manajemen Pengurus</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="?page=tpetugas">
                            <i class="bi bi-circle"></i><span>Tambah Pengurus</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=viewpetugas">
                            <i class="bi bi-circle"></i><span>Daftar Pengurus</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->
        <?php } ?>
    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <?php
    if (isset($_GET['page'])) {
        $act = $_GET['page'];
    }

    switch ($act) {
        case "":
            $halaman = "_home.php";
            $judul = "Dashboard";
            break;
        case "profil":
            $halaman = "_profil.php";
            $judul = "Profil";
            break;
        case "tmahasiswa":
            $halaman = "_tmahasiswa.php";
            $judul = "Tambah Mahasiswa";
            break;
        case "editmahasiswa":
            $halaman = "_editmahasiswa.php";
            $judul = "Edit Mahasiswa";
            break;
        case "viewmahasiswa":
            $halaman = "_viewmahasiswa.php";
            $judul = "Daftar Mahasiswa";
            break;
        case "tbuku":
            $halaman = "_tbuku.php";
            $judul = "Tambah Buku";
            break;
        case "editbuku":
            $halaman = "_editbuku.php";
            $judul = "Edit Buku";
            break;
        case "viewbuku":
            $halaman = "_viewbuku.php";
            $judul = "Daftar Buku";
            break;
        case "viewrak":
            $halaman = "_viewrak.php";
            $judul = "Rak dan Kategori";
            break;
        case "viewpeminjaman":
            $halaman = "_viewpeminjaman.php";
            $judul = "Daftar Peminjaman";
            break;
        case "tpetugas":
            $halaman = "_tpetugas.php";
            $judul = "Tambah Petugas";
            break;
        case "viewpetugas":
            $halaman = "_viewpetugas.php";
            $judul = "Daftar Petugas";
            break;
        case "editpetugas":
            $halaman = "_editpetugas.php";
            $judul = "Edit Petugas";
            break;
        default:
            echo '<script>swal("Maaf halaman tidak ada", "", "error").then(function(){
                                window.location.assign("?page=");
                                });</script>';
    }
    ?>
    <div class="pagetitle">
        <h1>
            <?php echo $judul; ?>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">
                    <?php echo $judul; ?>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <?php
            include $halaman;
            ?>
        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        Copyright &copy; 2023 <strong><span>HaloPustaka</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin Mau Keluar?</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Pilih Option "Logout" Untuk Keluar Dan Pilih Option "Cancel" Untuk Membatalkan</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="keluar.php">Logout</a>
            </div>
        </div>
    </div>
</div>


<?php
include "template/foot.php";
?>