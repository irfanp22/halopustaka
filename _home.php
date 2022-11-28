<?php
$buku = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(judul) AS jmlbuku FROM buku"));
$anggota = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(nama) AS jmlanggota FROM anggota"));
$pinjam = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamprocess FROM peminjaman WHERE MONTH(tanggal_pinjam) = MONTH(current_date())  AND status != 'done'"));
$balik = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamdone FROM peminjaman WHERE MONTH(tanggal_kembali) = MONTH(current_date())  AND status = 'done'"));
?>
<!-- Content Row -->
<div class="row">
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <a href="?page=viewbuku">
      <div class="card border-left-primary shadow h-100 py-2 zoom">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Buku</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($buku['jmlbuku']); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-solid fa-book fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <a href="?page=viewmahasiswa">
      <div class="card border-left-success shadow h-100 py-2 zoom">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Anggota</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($anggota['jmlanggota']); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-laugh-wink fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <a href="?page=viewpeminjaman">
      <div class="card border-left-info shadow h-100 py-2 zoom">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Peminjaman dalam Proses</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($pinjam['pinjamprocess']); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-list-alt fa-2x text-gray-300 ml-1"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <a href="?page=viewpeminjaman">
      <div class="card border-left-warning shadow h-100 py-2 zoom">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Peminjaman Selesai</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($balik['pinjamdone']); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-list-alt fa-2x text-gray-300 ml-1"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>