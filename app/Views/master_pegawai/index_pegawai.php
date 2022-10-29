<?= $this->extend('app'); ?>

<?= $this->section('content'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data Pegawai</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Pegawai</li>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Master Data Pegawai</h3>
                        <button action="<?php echo $url_add; ?>" class="btn btn-sm btn-primary float-right btn-add">
                            <i class="fa fa-plus"></i>
                            Tambah Pegawai
                        </button>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="pegawai" class="table table-hover table-head-fixed text-nowrap table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Kode Pegawai</th>
                                <th>Nama Pegawai</th>
                                <th>Jabatan Pegawai</th>
                                <th>Alamat Pegawai</th>
                                <th>No Telepon Pegawai</th>
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
    let _table = $('#pegawai');
    let _url = "<?php echo base_url('master_user/pegawai/datatables'); ?>";

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

    $(document).on('click', '.btn-add', function() {
        let _url = $(this).attr('action');
        window.location.href = _url;
    });

    $(document).on('click', '.edit', function() {
        let _url = $(this).attr('url');
        window.location.href = _url;
    });

    $(document).on('click', '.delete', function() {
        let _url = $(this).attr('url');
        Swal.fire({
            title: 'Apakah Anda Yakin Menghapus Data Ini ?',
            showCancelButton: true,
            confirmButtonText: `Hapus`,
            confirmButtonColor: '#d33',
            icon: 'question'
        }).then((result) => {
            if (result.value) {
                send((data, xhr = null) => {
                    if (data.status == 200) {
                        Swal.fire("Sukses", data.messages, 'success');
                        _table.DataTable().ajax.reload();
                    }
                }, _url, "json", "delete");
            }
        });
    });
</script>
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>