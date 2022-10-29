<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
</ul>

<!-- Right navbar links -->
<!-- <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown">
        <a class="keluar nav-link" data-toggle="dropdown" url="<?php echo base_url('auth/logout'); ?>" href="#">
            <i class="fas fa-sign-out-alt"></i>
            Keluar
        </a>
    </li>
</ul> -->

<?= $this->section('script'); ?>

<!-- <script>
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
</script> -->

<?= $this->endSection(); ?>