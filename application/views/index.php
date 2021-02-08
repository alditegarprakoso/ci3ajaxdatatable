<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/datatable/css/dataTables.bootstrap4.min.css') ?>">

    <title>CRUD - Ajax Data Table</title>
</head>

<body>

    <div class="container mt-5">
        <h4 class="mb-3">CodeIgniter 3 menggunakan Ajax DataTable Server Side</h4>

        <!-- Button tambah modal -->
        <button type="button" id="btnTambah" class="btn btn-primary mb-3">
            Tambah Data
        </button>

        <!-- Modal tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body form">
                        <form method="post" id="formTambah">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                                <small id="namaError" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3"></textarea>
                                <small id="alamatError" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" name="no_telp" id="no_telp" class="form-control" required>
                                <small id="noTelpError" class="text-danger"></small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnTutup"
                            data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="btnSimpan">Tambah Data</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir dari modal Tambah -->

        <!-- Awal Modal Edit -->
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body form">
                        <form method="post" id="formEdit">
                            <input type="hidden" name="idEdit" id="idEdit">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="namaEdit" id="namaEdit" class="form-control" required>
                                <small id="namaErrorEdit" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" name="alamatEdit" id="alamatEdit" cols="30"
                                    rows="3"></textarea>
                                <small id="alamatErrorEdit" class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" name="noTelpEdit" id="noTelpEdit" class="form-control" required>
                                <small id="noTelpErrorEdit" class="text-danger"></small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnTutup"
                            data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="btnUpdate">Edit Data</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir dari modal Tambah -->

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/jquery-3.5.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/datatable/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/datatable/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/sweetalert2.js') ?>"></script>

    <script>
    function reloadTable() {
        $('#myTable').DataTable().ajax.reload();
    }

    function clearError() {
        $('#namaError').html('')
        $('#alamatError').html('')
        $('#noTelpError').html('')
        $('#namaErrorEdit').html('')
        $('#alamatErrorEdit').html('')
        $('#noTelpErrorEdit').html('')
    }

    function pesan(icon, text) {
        Swal.fire({
            icon: icon,
            title: 'Pesan',
            text: text,
            showCloseButton: false,
            showCancelButton: false,
        })
    }

    function pesanHapus(id, nama) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data dari " + nama + " akan di hapus secara permanent!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus Data'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('home/hapus') ?>',
                    dataType: 'json',
                    data: {
                        "id": id,
                        "status": "hapusData"
                    },
                    success: function(hasil) {
                        reloadTable();
                    }
                })
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    }

    $(document).ready(function() {
        $('#myTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('home/ambilData') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "target": [-1],
                "orderable": false
            }]
        });
    });

    // Awal script untuk Tambah Data

    // Ketika tombol tambah data di klik
    $('#btnTambah').click(function() { // Ketika tombol Tambah Data di klik
        $('#formTambah')[0].reset(); // Untuk mereset atau menghapus inputan apabila form ditutup
        clearError();
        $('#modalTambah').modal('show'); // Menampilkan modal tambah
    })

    // Ketika tombol btnSimpan pada form Tambah di klik untuk menyimpan data ke database
    $('#btnSimpan').click(function() { // Ketika tombol btnSimpan pada form Tambah di klik
        $('#btnSimpan').text('Mohon tunggu...') // Mengubah text pada tombol simpan data
        $('#btnSimpan').attr('disabled', true) // Men-disable button simpan data

        let data = $("#formTambah").serialize(); // Mengambil semua value yang ada pada form Tambah Data
        $.ajax({
            type: "POST",
            url: "<?= base_url('home/tambah') ?>",
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.status == 'errorValidation') {
                    $('#btnSimpan').removeAttr('disabled', true) // Men-enable button simpan data
                    $('#btnSimpan').text('Tambah Data') // Mengubah text pada tombol simpan data
                    $('#namaError').html(result.nama)
                    $('#alamatError').html(result.alamat)
                    $('#noTelpError').html(result.no_telp)
                }
                if (result.status == 'Success') {
                    $('#modalTambah').modal('hide'); // Menutup Modal Tambah
                    $('#btnSimpan').removeAttr('disabled', true) // Men-enable button simpan data
                    $('#btnSimpan').text('Tambah Data') // Mengubah text pada tombol simpan data
                    reloadTable();
                    pesan('success', 'Data berhasil di simpan')
                }
            },
            error: function(result) {
                console.log(result);
            }

        })
    })

    // Script Edit Data
    function edit(id) {
        clearError();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('home/edit') ?>',
            dataType: 'json',
            data: {
                "id": id
            },
            success: function(result) {
                $('#modalEdit').modal('show'); // Menampilkan modal edit
                $("#idEdit").val(result.id);
                $("#namaEdit").val(result.nama);
                $("#alamatEdit").val(result.alamat);
                $("#noTelpEdit").val(result.no_telp);
            }
        })
    }

    // Ketika tombol btnUpdate pada form Edit di klik untuk mengubah data ke database
    $('#btnUpdate').click(function() { // Ketika tombol btnUpdate pada form Edit di klik
        $('#btnUpdate').text('Mohon tunggu...') // Mengubah text pada tombol simpan data
        $('#btnUpdate').attr('disabled', true) // Men-disable button simpan data

        let data = $("#formEdit").serialize(); // Mengambil semua value yang ada pada form Edit Data
        $.ajax({
            type: "POST",
            url: "<?= base_url('home/update') ?>",
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.status == 'errorValidation') {
                    $('#btnUpdate').removeAttr('disabled', true) // Men-enable button Update data
                    $('#btnUpdate').text('Edit Data') // Mengubah text pada tombol Update data
                    $('#namaErrorEdit').html(result.nama)
                    $('#alamatErrorEdit').html(result.alamat)
                    $('#noTelpErrorEdit').html(result.no_telp)
                } else if (result.status == 'Success') {
                    $('#modalEdit').modal('hide'); // Menutup Modal Edit
                    $('#btnUpdate').removeAttr('disabled', true) // Men-enable button simpan data
                    $('#btnUpdate').text('Edit Data') // Mengubah text pada tombol simpan data
                    reloadTable();
                    pesan('success', 'Data berhasil di edit')
                }
            },
            error: function(result) {
                console.log(result);
            }

        })
    })

    function hapus(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('home/hapus') ?>',
            dataType: 'json',
            data: {
                "id": id,
                "status": "ambilData"
            },
            success: function(result) {
                pesanHapus(result.id, result.nama)
            }
        })
    }
    </script>
</body>

</html>