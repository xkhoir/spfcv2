<!-- Brand Logo -->
<a href="#" class="brand-link">
    <!-- <img src="<?php echo base_url('assets/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
    <center>
        <span class="brand-text font-weight-light"><?= TITLE; ?></span>
    </center>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?= base_url('default.png'); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?php echo session()->get('nama_pegawai'); ?></a>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Master Data
                        <i class="fas fa-angle-left right"></i>
                        <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url('master_user/pegawai'); ?>" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            <p>Pegawai</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('master_user/user'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('master_kerusakan/gejala'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Gejala</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('master_kerusakan/kerusakan'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Kerusakan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('aturan'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>
                                Rule / Aturan
                                <!-- <i class="right fas fa-angle-left"></i> -->
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('perbaikan'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-toolbox"></i>
                            <p>
                                Perbaikan
                            </p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url('konsultasi'); ?>" class="nav-link">
                    <i class="nav-icon fas fa-stethoscope"></i>
                    <p>
                        Konsultasi
                        <!-- <i class="fas fa-angle-left right"></i> -->
                    </p>
                </a>
            </li>

            <!-- logout -->
            <div class="user-panel" style="text-align: center;">
                <div class="info mt-0">
                    <a href="#" class="keluar" url="<?php echo base_url('auth/logout'); ?>" href="#">
                        <button type="button" class="btn btn-block btn-danger">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            Keluar
                        </button>
                    </a>
                </div>
            </div>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<?= $this->section('script'); ?>
<script>
    let menu = $('.nav.nav-pills.nav-sidebar.flex-column').find('a');
    let _url_string = window.location.href;
    // let _split_url = _url_string.split('/');
    // let _fix_url;

    // console.log(_split_url);

    // if (_split_url.length > 5) {
    //     let _url_array = [];
    //     _url_array = [
    //         _split_url[0],
    //         _split_url[1],
    //         _split_url[2],
    //         _split_url[3],
    //         _split_url[4]
    //     ];
    //     _fix_url = _url_array.join('/');
    // } else {
    //     _fix_url = window.location.href;
    // }

    for (var i = 0; i < menu.length; i++) {
        href = menu.eq(i).attr('href');
        if (_url_string == href) {
            menu.eq(i).addClass('active');
            menu.eq(i).parents('li')
                .parents('li')
                .addClass('menu-open')
                .children('a')
                .addClass('active');
        }
    }

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