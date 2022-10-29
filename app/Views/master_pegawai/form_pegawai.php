<?= $this->extend('app'); ?>

<?= $this->section('content'); ?>

<?php if (!empty($pegawai)) {
    $nama_pegawai = $pegawai->nama_pegawai;
    $jabatan_pegawai = $pegawai->role_id;
    $alamat_pegawai = $pegawai->alamat_pegawai;
    $nomor_telepon_pegawai = $pegawai->nomor_telepon_pegawai;
} else {
    $nama_pegawai = "";
    $jabatan_pegawai = "";
    $alamat_pegawai = "";
    $nomor_telepon_pegawai = "";
}

?>

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
                    <li class="breadcrumb-item">Pegawai</li>
                    <li class="breadcrumb-item active">Tambah Data Pegawai</li>
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
                        <h3 class="card-title">Tambah Data Pegawai</h3>
                    </div>
                    <div class="card-body">
                        <form id="pegawai" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="nama_pegawai">Nama Pegawai</label>
                                        <input type="text" class="form-control rounded-0" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" value="<?php echo $nama_pegawai; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="jabatan_pegawai">Jabatan Pegawai</label>
                                        <select class="form-control rounded-0 select2" name="jabatan_pegawai" id="jabatan_pegawai" style="width: 100%;">
                                            <option></option>
                                            <?php foreach ($role as $key => $value) {
                                                if ($value['id'] == $jabatan_pegawai) {
                                            ?>
                                                    <option value="<?php echo $value['id']; ?>" selected><?php echo $value['nama_role']; ?></option>
                                                <?php   } else {
                                                ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['nama_role']; ?></option>
                                                <?php    } ?>
                                            <?php  } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat_pegawai">Alamat Pegawai</label>
                                        <!-- <input type="text" class="form-control rounded-0" name="alamat_pegawai" id="alamat_pegawai" placeholder="Nama Pegawai"> -->
                                        <textarea class="form-control rounded-0" name="alamat_pegawai" id="alamat_pegawai" placeholder="Alamat Pegawai"><?php echo $alamat_pegawai; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="nomor_telepon_pegawai">Nomor Telepon Pegawai</label>
                                        <input type="text" class="form-control rounded-0" name="nomor_telepon_pegawai" id="nomor_telepon_pegawai" placeholder="08xxx" value="<?php echo $nomor_telepon_pegawai; ?>">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                        <button type="reset" class="btn btn-warning btn-flat"><i class="fas fa-redo"></i> Reset</button>
                                    </div>

                                </div>
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
    $('#jabatan_pegawai').select2({
        placeholder: "-- PILIH JABATAN --",
    });

    $(document).on('submit', 'form#pegawai', function() {
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