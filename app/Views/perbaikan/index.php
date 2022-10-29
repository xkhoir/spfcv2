<?= $this->extend('app'); ?>

<?= $this->section('content'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Perbaikan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Perbaikan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Master Data Perbaikan</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="perbaikan" class="table table-hover table-head-fixed text-nowrap table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat Pelanggan</th>
                                <th>No Telepon Pelanggan</th>
                                <th>Nama Customer Service</th>
                                <th>Nama Teknisi</th>
                                <th>Tanggal Konsultasi</th>
                                <th>Status Perbaikan</th>
                                <th>Tanggal Selesai</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->section('script'); ?>
<script>
    let _table = $('#perbaikan');
    let _url = "<?php echo base_url('perbaikan/datatables'); ?>";

    $(_table).DataTable({
        language: {
            "decimal": "",
            "emptyTable": "Data kosong",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
            "infoFiltered": "(hasil dari _MAX_ total data)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Menampilkan _MENU_ data",
            "loadingRecords": "Memuat...",
            "processing": "Memproses...",
            "search": "Cari:",
            "zeroRecords": "Tidak ada data yang sesuai",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "aria": {
                "sortAscending": ": mengurutkan dari terkecil",
                "sortDescending": ": mengurutkan dari terbesar"
            }
        },
        autoWidth: false,
        scrollX: true,
        processing: true,
        serverSide: false,
        order: [],
        ajax: {
            url: _url,
            type: "GET",
        },
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        columnDefs: [{
            targets: [0],
            orderable: false
        }, ],
        paging: true,
    });

    $(document).on('click', '.print', function() {
        let _url = $(this).attr('url');
        window.open(_url);
    });

    $(document).on('click', '.edit', function() {
        let _url = $(this).attr('url');
        Swal.fire({
            title: 'Apakah Anda Yakin Menyelesaikan Perbaikan Ini ?',
            showCancelButton: true,
            confirmButtonText: `Selesai`,
            confirmButtonColor: '#d33',
            icon: 'question'
        }).then((result) => {
            if (result.value) {
                send((data, xhr = null) => {
                    if (data.status == 200) {
                        Swal.fire("Sukses", data.messages, 'success');
                        _table.DataTable().ajax.reload();
                    }
                }, _url, "json", "get");
            }
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>