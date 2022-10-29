<?= $this->extend('app'); ?>

<?= $this->section('content'); ?>

<?php if (!empty($user)) {
    $username = $user->username;
} else {
    $username = "";
}

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Master Data User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item active">Ubah Data User</li>
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
                        <h3 class="card-title">Ubah Data User</h3>
                    </div>
                    <div class="card-body">
                        <form id="user" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control rounded-0" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password_1">Password</label>
                                        <input type="text" class="form-control rounded-0" name="password_1" id="password_1" placeholder="Password">
                                    </div>

                                    <div class="form-group">
                                        <label for="password_2">Konfirmasi Password</label>
                                        <input type="text" class="form-control rounded-0" name="password_2" id="password_2" placeholder="Konfirmasi Password">
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
    $(document).on('submit', 'form#user', function() {
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