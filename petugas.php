<?php
$buku = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(judul) AS jmlbuku FROM buku"));
$anggota = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(nama) AS jmlanggota FROM anggota"));
$pinjam = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamprocess FROM peminjaman WHERE MONTH(tanggal_pinjam) = MONTH(current_date()) AND YEAR(tanggal_pinjam) = YEAR(current_date()) AND status != 'done'"));
$balik = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamdone FROM peminjaman WHERE MONTH(tanggal_kembali) = MONTH(current_date()) AND YEAR(tanggal_kembali) = YEAR(current_date()) AND status = 'done'"));

?>
<!-- Content Row -->
<div class="row">
  <div class="col-xxl-4 col-md-6">
    <a href="?page=viewbuku">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Jumlah Buku</h5>

          <div class="d-flex align-items-center">
            <div
              class="card-icon rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
              <i class="text-success bi bi-book-half"></i>
            </div>
            <div class="ps-3">
              <h6 class="text-success">
                <?php echo number_format($buku['jmlbuku']); ?>
              </h6>
            </div>
          </div>
        </div>

      </div>
    </a>
  </div>

  <div class="col-xxl-4 col-md-6">
    <a href="?page=viewmahasiswa">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Jumlah Anggota</h5>

          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-people"></i>
            </div>
            <div class="ps-3">
              <h6 class="text-primary">
                <?php echo number_format($anggota['jmlanggota']); ?>
              </h6>
            </div>
          </div>
        </div>

      </div>
    </a>
  </div>

  <div class="col-xxl-4 col-md-6">
    <a href="?page=viewpeminjaman">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Jumlah Peminjaman dalam Proses</h5>

          <div class="d-flex align-items-center">
            <div
              class="card-icon rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center">
              <i class="text-danger bi bi-arrow-repeat"></i>
            </div>
            <div class="ps-3">
              <h6 class="text-danger">
                <?php echo number_format($pinjam['pinjamprocess']); ?>
              </h6>
            </div>
          </div>
        </div>

      </div>
    </a>
  </div>

  <div class="col-xxl-4 col-md-6">
    <a href="?page=viewpeminjaman">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Jumlah Peminjaman Selesai</h5>

          <div class="d-flex align-items-center">
            <div
              class="card-icon rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center">
              <i class="text-warning bi bi-check2-circle"></i>
            </div>
            <div class="ps-3">
              <h6 class="text-warning">
                <?php echo number_format($balik['pinjamdone']); ?>
              </h6>
            </div>
          </div>
        </div>

      </div>
    </a>
  </div>