    <?php
    if($title=="Daftar Buku" || $title=="Profil"){
        ?>
        <div class="card mb-3 w-100 mt-4">
            <div class="card-header text-center font-weight-bold">Halo Pustaka</div>
            <div class="card-body text-dark">
                <p class="card-text text-center">Copyright &copy; 2022 | Sistem Informasi Perpustakaan Halo Pustaka</p>
            </div>
        </div>
        <?php
    }
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="assets/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/DataTables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="assets/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="assets/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.print.min.js"></script>
    <script src="assets/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                search: {
                    search: "<?php if (isset($_POST['searchbtn'])) echo $_POST['searchkey']  ?>"
                },
            });
            var table1 = $('#table2').DataTable({
                buttons: ['copy', 'csv', 'print', 'excel', 'pdf', 'colvis'],
                dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
            });
            var table2 = $('#riwayat').DataTable();

            var table3 = $('#table3').DataTable();
            var table4 = $('#table4').DataTable();
            var table5 = $('#table5').DataTable({
                buttons: ['copy', 'csv', 'print', 'excel', 'pdf', 'colvis'],
                dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
            });
            var table6 = $('#table6').DataTable({
                buttons: ['copy', 'csv', 'print', 'excel', 'pdf', 'colvis'],
                dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
            });

            table1.buttons().container()
                .appendTo('#table_wrapper .col-md-5:eq(0)');

            var $buku = $('#id_buku').selectize({
                sortField: 'text'
            });

            var $nim = $('#inpnim').selectize({
                sortField: 'text'
            });

            var $buku = $('#id_buku_edit').selectize({
                sortField: 'text'
            });

            var $nim = $('#nim_edit').selectize({
                sortField: 'text'
            });

            var $bulan = $('#bulan').selectize();

            var thn = document.getElementById('tahunrep').value;
            $.ajax({
                url: "data.php",
                method: "GET",
                data: {
                    "tahun": thn
                },
                dataType: "JSON",
                success: function(data){
                    var denda = [data.denda1, data.denda2, data.denda3, data.denda4, data.denda5, data.denda6, data.denda7, data.denda8, data.denda9, data.denda10, data.denda11, data.denda12];
                    var pinjam = [data.bulan1, data.bulan2, data.bulan3, data.bulan4, data.bulan5, data.bulan6, data.bulan7, data.bulan8, data.bulan9, data.bulan10, data.bulan11, data.bulan12];
                    for(var i=0; i<12; i++){
                        if(denda[i]==null) denda[i]=0;
                    }
                    var chartdata = {
                            datasets: [{
                                data: pinjam,
                                label: 'Peminjaman Buku',
        
                                // This binds the dataset to the left y axis
                                yAxisID: 'left-y-axis'
                            }, {
                                data: denda,
                                label: 'Denda',
        
                                // This binds the dataset to the right y axis
                                yAxisID: 'right-y-axis'
                            }],
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des']
                        }
                    const repchart = document.getElementById('report');
                    const myChart = new Chart(repchart, {
                        type: 'line',
                        data: chartdata,
                        options: {
                            responsive: true,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            stacked: false,
                            scales: {
                                'left-y-axis': {
                                    type: 'linear',
                                    position: 'left'
                                },
                                'right-y-axis': {
                                    type: 'linear',
                                    position: 'right'
                                }
                            }
                        }
                    });
                },
                error: function(data){
                    console.log("ERROR".concat(data));
                }
            })
        });

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        $(".confirmAlert").on("click", function() {
            var getLink = $(this).attr('href');
            Swal.fire({
                title: "Yakin hapus data?<?php if ($_GET['page'] == "viewrak") echo " Data buku juga akan terhapus!" ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal",
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = getLink;
                }
            });
            return false;
        });

        $(".confirmAcc").on("click", function() {
            var getLink = $(this).attr('href');
            Swal.fire({
                title: "Yakin Konfirmasi Peminjaman?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal",
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = getLink;
                }
            });
            return false;
        });

        $(".confirmPinjam").on("click", function() {
            var judul = $(this).data('judul');
            Swal.fire({
                title: "Apakah anda ingin melakukan permintaan peminjaman terhadap buku \"".concat(judul).concat("\"?"),
                icon: 'warning',
                text: "Permintaan akan expire dalam 24 jam jika tidak diproses!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal",
            }).then(result => {
                if (result.isConfirmed) {
                    var sedia = $(this).data('sedia');
                    if (sedia <= 0) {
                        Swal.fire('Buku tidak tersedia', '', 'error');
                        return false;
                    }
                    var id_buku = $(this).data('id_buku');
                    var nim = $(this).data('nim');
                    $.ajax({
                        url: "booking-buku.php",
                        method: "POST",
                        data: {
                            id_buku: id_buku,
                            nim: nim
                        },
                        success: function() {
                            Swal.fire('Peminjaman Buku Berhasil Diajukan', '', 'success').then(function() {
                                window.location.assign("profil.php");
                            });
                        },
                        error: function() {
                            Swal.fire('ERROR', '', 'error');
                        }
                    });
                }
            });
            return false;
        });

        $(".confirmKembali").on("click", function() {
            var id = $(this).data('id');
            Swal.fire({
                title: "Yakin Konfirmasi Pengembalian?",
                icon: 'warning',
                input: "text",
                inputLabel: "Denda tambahan",
                inputPlaceholder: "Masukan denda tambahan",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal",
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "pengembalian.php",
                        method: "POST",
                        data: {
                            'dendaplus': result.value,
                            'id_kem': id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.msg == 1) Swal.fire("Pengembalian Berhasil Dikonfirmasi", "", "success").then(function() {
                                window.location.assign('?page=viewpeminjaman')
                            });
                            else Swal.fire("Pengembalian Gagal Dikonfirmasi", "", "error");
                        },
                        error: function() {
                            Swal.fire("JSON ERROR", "", "error");
                        }
                    })
                }
            });
            return false;
        });

        $('.btneditkateg').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            $('.idkategori').val(id);
            $('.namakategori').val(nama);
        });

        $('.btneditrak').click(function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            $('.idrak').val(id);
            $('.namarak').val(nama);
        });

        $('.btndetailbuku').click(function() {
            var id_buku = $(this).data('id');
            $.ajax({
                url: "detailbuku.php",
                method: "POST",
                data: {
                    id_buku: id_buku
                },
                dataType: "JSON",
                success: function(data) {
                    $('.id_buku').text(data.id_buku);
                    $('.isbn').text(data.isbn);
                    $('.judul').text(data.judul);
                    $('.rak').text(data.rak);
                    $('.kategori').text(data.kategori);
                    $('.pengarang').text(data.pengarang);
                    $('.penerbit').text(data.penerbit);
                    $('.thnterbit').text(data.thnterbit);
                    $('.stok').text(data.stok);
                    $('.sedia').text(data.sedia);
                    $('.keterangan').text(data.keterangan);
                    document.getElementById('jilid').src = "assets/img/".concat(data.jilid);
                }
            })
        });

        $('.btndetailpeminjaman').click(function() {
            var id_peminjaman = $(this).data('id');
            $.ajax({
                url: "detailpeminjaman.php",
                method: "POST",
                data: {
                    id_peminjaman: id_peminjaman
                },
                dataType: "JSON",
                success: function(data) {
                    $('.id_peminjaman').text(data.id_peminjaman);
                    $('.buku').text(data.buku);
                    $('.anggota').text(data.anggota);
                    $('.tanggal_pinjam').text(data.tanggal_pinjam);
                    $('.tanggal_kembali').text(data.tanggal_kembali);
                    $('.denda').text(data.denda);
                    $('#badge').html(data.status);
                    document.getElementById('badge').className = data.badge;
                }
            })
        });

        $('.btneditpeminjaman').click(function() {
            var id_peminjaman = $(this).data('id');
            $('.id_peminjaman').val(id_peminjaman);
            $.ajax({
                url: "detaileditpeminjaman.php",
                method: "POST",
                data: {
                    id_peminjaman: id_peminjaman
                },
                dataType: "JSON",
                success: function(data) {
                    $('#id_buku_edit').data('selectize').setValue(data.id_buku);
                    $('#nim_edit').data('selectize').setValue(data.nim);
                    if (data.status == "process") {
                        $('#btnkembali').attr('data-id', data.id_peminjaman);
                    } else {
                        document.getElementById('btnkembali').remove();
                    }
                }
            })
        });

        $('.btndetailmahasiswa').click(function() {
            var nim = $(this).data('id');
            $.ajax({
                url: "detailmahasiswa.php",
                method: "POST",
                data: {
                    nim: nim
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data.nim);
                    $('.nim').text(data.nim);
                    $('.nama').text(data.nama);
                    $('.email').text(data.email);
                    $('.nohp').text(data.nohp);
                    $('.alamat').text(data.alamat);
                    $('.jenis_kelamin').text(data.jenis_kelamin);
                    document.getElementById('pic').src = "assets/img/".concat(data.pic);
                }
            })
        });

        function valid() {
            var file = document.getElementById('pic');
            var filePath = file.value;
            var [pic] = file.files;

            var ekstensi = /(\.jpg|\.jpeg|\.png)$/i;

            if (!ekstensi.exec(filePath)) {
                Swal.fire('Masukan file gambar', '', 'error');
                file.value = '';
                document.getElementById('display').hidden = true;
                document.getElementById('display').src = "";
                return false;
            }
            var src = document.getElementById('display').src;
            if (pic) {
                document.getElementById('display').src = URL.createObjectURL(pic);
                document.getElementById('display').hidden = false;
            }
        }
    </script>
    </body>

    </html>