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

if(isset($_POST['thnbtn'])){
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
<div class="row">
    <div class="col-xl-12 mt-2 mb-2">
        <form name="tahun" action="dashboard.php" method="post" class="form-inline my-2 my-lg-0" id="repbln">
            <div class="form-group mr-4">
                <label for="bulan">Bulan: </label>
                <select name="bulan" class="form-control" id="bulan">
                    <option value="">-- pilih bulan --</option>
                    <?php
                        for($i=1; $i<=12; $i++){
                            if($skrg['mon']==$i && empty($_POST['thnbtn'])) echo '<option value="'.$i.'" selected>'.$mon[$i-1].'</option>';
                            elseif($bulan==$i && isset($_POST['thnbtn'])) echo '<option value="'.$i.'" selected>'.$mon[$i-1].'</option>';
                            else echo '<option value="'.$i.'">'.$mon[$i-1].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group mr-4">
                <label for="tahun">Tahun: </label>
                <input class="form-control mr-lg-2" name="tahun" id="tahunrep" type="text" placeholder="Tahun" aria-label="Tahun" value="<?php 
                    if(empty($_POST['thnbtn'])) echo $skrg['thn'];
                    elseif(isset($_POST['thnbtn'])) echo $tahun;
                  ?>">
            </div>
            <button class="btn btn-success my-2 my-sm-0 col-lg-0" name="thnbtn" type="submit" value="Process">Process</button>
        </form>
    </div>
</div>
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

<div class="row justify-content-md-center">
  <div class="col-xl-4 col-md-6 mb-4">
    <a href="?page=viewpeminjaman">
      <div class="card border-left-success shadow h-100 py-2 zoom">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Rata-Rata Waktu Pengembalian</div>
              <?php
              if(empty(mysqli_fetch_array($tanggal2))){
                $total = 0;
                $jml = 1;
              }
              while ($row = mysqli_fetch_array($tanggal)){
                $pinjam = date_create($row['tanggal_pinjam']);
                $balik = date_create($row['tanggal_kembali']);
                $waktu = date_diff($balik, $pinjam);
                $jml++;
                $total = ($total + $waktu->format('%a'));
              }
              $total /= $jml;
              ?>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total); ?> Hari</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-list-alt fa-2x text-gray-300 ml-1"></i>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-xl-4 col-md-6 mb-4">
    <a href="?page=viewpeminjaman">
      <div class="card border-left-warning shadow h-100 py-2 zoom">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Denda</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?php echo number_format($denda['denda']); ?></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
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

<div class="container">
  <h5 class="text-center">Jumlah Peminjaman Buku</h5>
  <canvas id="report"></canvas>
</div>