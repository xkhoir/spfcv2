<div class="container">
    <a href="<?php echo base_url('/'); ?>" class="navbar-brand">
        <span class="brand-text font-weight-light"><?php echo TITLE; ?></span>
    </a>

    <!-- <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button> -->

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?php echo base_url('konsultasi'); ?>" class="nav-link">Konsultasi</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url('perbaikan'); ?>" class="nav-link">Perbaikan</a>
            </li>
        </ul>
    </div>

    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
            <a href="#" class="keluar" url="<?php echo base_url('auth/logout'); ?>" href="#">
                <button type="button" class="btn btn-block btn-danger">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    Keluar
                </button>
            </a>
        </li>
    </ul>
</div>

<?= $this->section('script'); ?>

<script>
    $(document).on('click', '.keluar', function() {
        let _url = $(this).attr('url');
        Swal.fire({
            title: 'Apakah Anda Yakin Keluar Dari Sistem ?',
            showCancelButton: true,
            confirmButtonText: `Keluar`,
            confirmButtonColor: '#d33',
            icon: 'question'
        }).then((result) => {
            if (result.value) {
                send((data, xhr = null) => {
                    if (data.status == 200) {
                        Swal.fire({
                            type: 'success',
                            title: "Logout Sukses",
                            text: data.messages,
                            timer: 3000,
                            icon: 'success',
                            showCancelButton: false,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = data.url;
                        });
                    }
                }, _url, "json", "get");
            }
        });
    });
</script>

<?= $this->endSection(); ?>