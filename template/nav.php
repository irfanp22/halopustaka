<!-- ======= Top Bar ======= -->
<section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
            <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
    </div>
</section>

<header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="index.php"><i class="fas fa-solid fa-book-open"></i></a></h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="./index.php">Home</a></li>
                <li><a class="nav-link scrollto" href="./buku.php">Lihat Buku</a></li>
                <li class="dropdown"><a href="#"><span>
                            <?php
                            $nama = $_SESSION['nama'];
                            if (!isset($_SESSION['username'])) {
                                echo 'Masuk
                </span> <i class="bi bi-chevron-down"></i></a>
                <ul>
                <li><a href="masuk.php?sebagai=pengurus">Sebagai Admin</a></li>
                <li><a href="masuk.php?sebagai=anggota">Sebagai Mahasiswa</a></li>
                </ul>';
                            } else {
                                echo $nama .
                                    '</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                    <li><a href="profil.php">Profile</a></li>
                    <li><a href="pengaturan.php">Pengaturan</a></li>
                    <div class="dropdown-divider"></div>
                    <li><a href="keluar.php">Logout</a></li>
                    </ul>';
                            }
                            ?>
                </li>
                <li><?php if ($title != "Daftar Buku") echo '<form name="search" action="buku.php" method="post" class="form-group form-inline my-2 my-lg-0">
                <input class="form-control mr-lg-2" name="searchkey" type="text" placeholder="Search" aria-label="Search">
                </li><li>
                <button class="btn btn-outline-success my-2 my-sm-0 col-lg-0" name="searchbtn" type="submit" value="Search">Search</button>
            </form>' ?></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->