<?= $this->extend('app'); ?>

<?= $this->section('content'); ?>

<?php if (!empty($aturan)) {
    $kode_kerusakan = $aturan->id_kerusakan;
} else {
    $kode_kerusakan = "";
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Aturan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Aturan</li>
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
                        <h3 class="card-title">Aturan</h3>
                    </div>
                    <div class="card-body">
                        <form id="aturan" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label for="kode_kerusakan">Nama Kerusakan</label>
                                        <select class="form-control rounded-0 select2" name="kode_kerusakan" id="kode_kerusakan" style="width: 100%;">
                                            <option></option>
                                            <?php foreach ($kerusakan as $key => $value) {
                                                if ($value['id'] == $kode_kerusakan) {
                                            ?>
                                                    <option value="<?php echo $value['id']; ?>" selected><?php echo $value['kode_kerusakan'] . ' - ' . $value['nama_kerusakan']; ?></option>
                                                <?php   } else {
                                                ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['kode_kerusakan'] . ' - ' . $value['nama_kerusakan']; ?></option>
                                                <?php    } ?>
                                            <?php  } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kode_gejala">Pilih Gejala</label>
                                        <?php echo $gejala; ?>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                        <button type="reset" class="btn btn-warning btn-flat"><i class="fas fa-redo"></i> Reset</button>
                                    </div>

                                </div>
                                <div class="col-md-1"></div>
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
    $('#kode_kerusakan').select2({
        placeholder: "-- PILIH KERUSAKAN --",
    });


    $(document).on('submit', 'form#aturan', function() {
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