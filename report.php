<?php
$buku = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(judul) AS jmlbuku FROM buku"));
$anggota = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(nama) AS jmlanggota FROM anggota"));
$pinjam = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamprocess FROM peminjaman WHERE MONTH(tanggal_pinjam) = MONTH(current_date()) AND YEAR(tanggal_pinjam) = YEAR(current_date()) AND status != 'done'"));
$balik = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamdone FROM peminjaman WHERE MONTH(tanggal_kembali) = MONTH(current_date()) AND YEAR(tanggal_kembali) = YEAR(current_date()) AND status = 'done'"));
$skrg = mysqli_fetch_array(mysqli_query($koneksi, "SELECT MONTH(current_date()) AS mon, YEAR(current_date()) as thn"));
$mon = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$tanggal = mysqli_query($koneksi, "SELECT tanggal_pinjam, tanggal_kembali FROM peminjaman WHERE MONTH(tanggal_kembali) = MONTH(current_date()) AND YEAR(tanggal_kembali) = YEAR(current_date()) AND status = 'done'");
$tanggal2 = mysqli_query($koneksi, "SELECT tanggal_pinjam, tanggal_kembali FROM peminjaman WHERE MONTH(tanggal_kembali) = MONTH(current_date()) AND YEAR(tanggal_kembali) = YEAR(current_date()) AND status = 'done'");
$denda = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(denda) AS denda FROM peminjaman WHERE MONTH(tanggal_kembali) = MONTH(current_date()) AND YEAR(tanggal_kembali) = YEAR(current_date()) AND status = 'done'"));

if (isset($_POST['thnbtn'])) {
  $bulan = $_POST['bulan'];
  $tahun = $_POST['tahun'];
  $pinjam = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamprocess FROM peminjaman WHERE MONTH(tanggal_pinjam) = $bulan AND YEAR(tanggal_pinjam) = $tahun AND status != 'done'"));
  $balik = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_peminjaman) AS pinjamdone FROM peminjaman WHERE MONTH(tanggal_kembali) = $bulan AND YEAR(tanggal_kembali) = $tahun AND status = 'done'"));
  $mon = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
  $tanggal = mysqli_query($koneksi, "SELECT tanggal_pinjam, tanggal_kembali FROM peminjaman WHERE MONTH(tanggal_kembali) = $bulan AND YEAR(tanggal_kembali) = $tahun AND status = 'done'");
  $tanggal2 = mysqli_query($koneksi, "SELECT tanggal_pinjam, tanggal_kembali FROM peminjaman WHERE MONTH(tanggal_kembali) = $bulan AND YEAR(tanggal_kembali) = $tahun AND status = 'done'");
  $denda = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(denda) AS denda FROM peminjaman WHERE MONTH(tanggal_kembali) = $bulan AND YEAR(tanggal_kembali) = $tahun AND status = 'done'"));
}
?>
<div class="row" style="margin-bottom: 20px;">
  <div class="col-xl-12 mt-2 mb-2">
    <form name="tahun" action="dashboard.php" method="post" class="form-inline my-2 my-lg-0" id="repbln">
      <div class="row">
        <div class="col-2">
          <div class="form-group mr-4">
            <label for="bulan" class="mr-2">Bulan:</label>
            <select name="bulan" class="form-control mr-2" id="bulan">
              <option value="">-- pilih bulan --</option>
              <?php
              for ($i = 1; $i <= 12; $i++) {
                if ($skrg['mon'] == $i && empty($_POST['thnbtn'])) {
                  echo '<option value="' . $i . '" selected>' . $mon[$i - 1] . '</option>';
                } elseif ($bulan == $i && isset($_POST['thnbtn'])) {
                  echo '<option value="' . $i . '" selected>' . $mon[$i - 1] . '</option>';
                } else {
                  echo '<option value="' . $i . '">' . $mon[$i - 1] . '</option>';
                }
              }
              ?>
            </select>
          </div>
        </div>
        <div class="col-3">
          <div class="form-group mr-4">
            <label for="tahun" class="mr-2">Tahun:</label>
            <input class="form-control mr-2" name="tahun" id="tahunrep" type="text" placeholder="Tahun"
              aria-label="Tahun" value="<?php
              if (empty($_POST['thnbtn'])) {
                echo $skrg['thn'];
              } elseif (isset($_POST['thnbtn'])) {
                echo $tahun;
              }
              ?>">
          </div>
        </div>
        <div class="col-3 mt-4">
          <button class="btn btn-success" name="thnbtn" type="submit" value="Process">Process</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-xl-3 col-md-6 mb-3">
    <a href="?page=viewbuku" class="text-decoration-none">
      <div class="card info-card sales-card d-flex flex-column h-100">
        <div class="card-body d-flex flex-column justify-content-between">
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

  <div class="col-xl-3 col-md-6 mb-3">
    <a href="?page=viewmahasiswa" class="text-decoration-none">
      <div class="card info-card sales-card d-flex flex-column h-100">
        <div class="card-body d-flex flex-column justify-content-between">
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

  <div class="col-xl-3 col-md-6 mb-3">
    <a href="?page=viewpeminjaman" class="text-decoration-none">
      <div class="card info-card sales-card d-flex flex-column h-100">
        <div class="card-body d-flex flex-column justify-content-between">
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

  <div class="col-xl-3 col-md-6 mb-3">
    <a href="?page=viewpeminjaman" class="text-decoration-none">
      <div class="card info-card sales-card d-flex flex-column h-100">
        <div class="card-body d-flex flex-column justify-content-between">
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
</div>

<div class="row justify-content-center">
  <div class="col-xl-4 col-md-6 mb-3">
    <a href="?page=viewpeminjaman" class="text-decoration-none">
      <div class="card info-card sales-card d-flex flex-column h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <h5 class="card-title">Rata-rata Waktu Pengembalian</h5>
          <?php
          if (empty(mysqli_fetch_array($tanggal2))) {
            $total = 0;
            $jml = 1;
          }
          while ($row = mysqli_fetch_array($tanggal)) {
            $pinjam = date_create($row['tanggal_pinjam']);
            $balik = date_create($row['tanggal_kembali']);
            $waktu = date_diff($balik, $pinjam);
            $jml++;
            $total = ($total + $waktu->format('%a'));
          }
          $total /= $jml;
          ?>
          <div class="d-flex align-items-center">
            <div
              class="card-icon rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
              <i class="text-info bi bi-alarm"></i>
            </div>
            <div class="ps-3">
              <h6 class="text-info">
                <?php echo number_format($total); ?> Hari
              </h6>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-4 col-md-6 mb-3">
    <a href="?page=viewpeminjaman" class="text-decoration-none">
      <div class="card info-card sales-card d-flex flex-column h-100">
        <div class="card-body d-flex flex-column justify-content-between">
          <h5 class="card-title">Jumlah Denda</h5>
          <div class="d-flex align-items-center">
            <div
              class="card-icon rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
              <i class="text-success bi bi-cash-stack"></i>
            </div>
            <div class="ps-3">
              <h6 class="text-success">
                Rp
                <?php echo number_format($denda['denda']); ?>
              </h6>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>


<div class="container" style="margin-bottom: 20px;">
  <h5 class="text-center">Peminjaman Buku Tahun
    <?php
    if (empty($_POST['thnbtn']))
      echo $skrg['thn'];
    elseif (isset($_POST['thnbtn']))
      echo $tahun;
    ?>
  </h5>
  <div id="report"></div>
</div>