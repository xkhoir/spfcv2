<?= $this->extend('app'); ?>

<?= $this->section('content'); ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Konsultasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Konsultasi</li>
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
                        <h3 class="card-title">Konsultasi</h3>
                    </div>
                    <div class="card-body">
                        <form id="konsultasi" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <p style="text-align: center;">
                                <h3>[ <?php echo $gejala->kode_gejala; ?> ] - Apakah <?php echo $gejala->nama_gejala; ?> ?</h3>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answer" id="answer" value="0">
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answer" id="answer" value="1">
                                    <label class="form-check-label">Tidak</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                <!-- <button type="reset" class="btn btn-warning btn-flat"><i class="fas fa-redo"></i> Reset</button> -->
                            </div>

                            <input type="hidden" name="child_gejala" id="child_gejala" value="<?php echo $gejala->id; ?>">
                            <input type="hidden" name="parent_gejala" id="parent_gejala" value="<?php echo $parent_gejala; ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>