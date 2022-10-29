<?= $this->extend('app'); ?>

<?= $this->section('content'); ?>

<?php if (!empty($kerusakan)) {
    $nama_kerusakan = $kerusakan->nama_kerusakan;
    $penyebab_kerusakan = $kerusakan->penyebab_kerusakan;
    $solusi_kerusakan = $kerusakan->solusi_kerusakan;
} else {
    $nama_kerusakan = "";
    $penyebab_kerusakan = "";
    $solusi_kerusakan = "";
}

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Kerusakan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Kerusakan</a></li>
                    <li class="breadcrumb-item active">Master Kerusakan</li>
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
                        <h3 class="card-title">Master Kerusakan</h3>
                    </div>
                    <div class="card-body">
                        <form id="kerusakan" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label for="nama_kerusakan">Nama Kerusakan</label>
                                        <input type="text" class="form-control rounded-0" name="nama_kerusakan" id="nama_kerusakan" placeholder="Nama Kerusakan" value="<?php echo $nama_kerusakan; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="penyebab_kerusakan">Penyebab Kerusakan</label>
                                        <textarea class="form-control rounded-0" name="penyebab_kerusakan" id="penyebab_kerusakan" placeholder="Penyebab Kerusakan"><?php echo $penyebab_kerusakan; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="soluis_kerusakan">Solusi Kerusakan</label>
                                        <textarea class="form-control rounded-0" name="solusi_kerusakan" id="solusi_kerusakan" placeholder="Solusi Kerusakan"><?php echo $solusi_kerusakan; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                        <button type="reset" class="btn btn-warning btn-flat"><i class="fas fa-redo"></i> Reset</button>
                                    </div>

                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->section('script'); ?>
<script>

    $('#penyebab_kerusakan').summernote();
    $('#solusi_kerusakan').summernote();

    $(document).on('submit', 'form#kerusakan', function() {
        event.preventDefault();
        let _url = $(this).attr('action');
        let _data = new FormData($(this)[0]);
        send((data, xhr = null) => {
            if (data.status == 422) {
                FailedNotif(data.messages);
            } else if (data.status == 200) {
                SuccessNotif(data.messages);
                setInterval(function() {
                    window.location.href = data.url;
                }, 1000);
            }
        }, _url, 'json', 'post', _data);
    });
</script>
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>