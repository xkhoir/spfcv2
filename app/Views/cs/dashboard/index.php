<?= $this->extend('cs/app'); ?>

<?= $this->section('content'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">
                            <center>
                                <h3>Selamat Datang <?php echo session()->get('nama_pegawai'); ?></h3> <br>
                                <h3>Layani Pelanggan dengan Ramah</h3> <br>
                            </center>
                        </p>
                        </p>

                        <div class="row">
                            <div class="col-lg-3 col-6"></div>
                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>Konsultasi</h3>

                                        <p>Layanan Konsultasi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-stethoscope"></i>
                                    </div>
                                    <a href="<?php echo base_url('konsultasi'); ?>" class="small-box-footer">
                                        Konsultasi <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small card -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>Perbaikan</h3>

                                        <p>Layanan Perbaikan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-toolbox"></i>
                                    </div>
                                    <a href="<?php echo base_url('perbaikan'); ?>" class="small-box-footer">
                                        Perbaikan <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->section('script'); ?>
<script>

</script>
<?= $this->endSection(); ?>

<?= $this->endSection(); ?>