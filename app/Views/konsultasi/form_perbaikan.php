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
                        <h3 class="card-title">Hasil Konsultasi</h3>
                    </div>
                    <div class="card-body">
                        <form id="perbaikan" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                            <h5>Gejala yang disampaikan Pelanggan : </h5>
                            <div class="form-group">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Kode Gejala</th>
                                                <th>Nama Gejala</th>
                                                <th>Jawaban</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($konsultasi as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $value['kode_gejala']; ?></td>
                                                    <td><?php echo $value['nama_gejala']; ?></td>
                                                    <td><?php echo $value['answer']; ?></td>
                                                </tr>
                                            <?php   } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <h5>Hasil Dari Sistem : </h5>
                            <div class="form-group">
                                <?php if (!$kemungkinan) {
                                    if ($kerusakan != null) {
                                ?>
                                        <!-- Jika Kemungkinan Tidak Ditemukan -->
                                        <h3 style="text-align: center;">Ditemukan Kerusakan !!
                                            <i style="color: green;" class="fas fa-check-circle"></i>
                                        </h3>
                                        <input type="hidden" name="id_kerusakan" id="id_kerusakan" value="<?php echo $kerusakan['id_kerusakan']; ?>">
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap table-bordered text-nowrap">
                                                <tr>
                                                    <th>Nama Kerusakan</th>
                                                    <td> (<?php echo $kerusakan['kode_kerusakan']; ?>) <?php echo $kerusakan['nama_kerusakan']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Penyebab Kerusakan</th>
                                                    <td><?php echo $kerusakan['penyebab_kerusakan']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Solusi Kerusakan</th>
                                                    <td><?php echo $kerusakan['solusi_kerusakan']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php } else {
                                    ?>
                                        <!-- Jika Kemungkinan Tidak Ditemukan dan tidak ada kerusakan -->
                                        <div class="form-group">
                                            <p>
                                            <h5 style="text-align: center;">Kerusakan Tidak Ditemukan Silahkan Untuk Memilih Beberapa Gejala
                                                <i style="color: red;" class="fas fa-times-circle"></i>
                                            </h5>
                                            </p>
                                        </div>
                                    <?php    }
                                } else if ($kemungkinan) {
                                    ?>
                                    <!-- Jika Kemungkinan ditemukan -->
                                    <h3 style="text-align: center;">Kemungkinan Ditemukan Kerusakan Sebagai Berikut !!
                                        <i style="color: orange;" class="fas fa-info-circle"></i>
                                    </h3>
                                    <?php foreach ($kerusakan as $key => $value) {
                                        foreach ($value as $key2 => $value2) {
                                    ?>
                                            <input type="hidden" name="id_kerusakan[]" id="id_kerusakan" value="<?php echo $value2['id_kerusakan']; ?>">
                                    <?php }
                                    }
                                    ?>
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap table-bordered text-nowrap">
                                            <?php foreach ($kerusakan as $key => $value) {
                                                foreach ($value as $key2 => $value2) {
                                            ?>
                                                    <tr>
                                                        <th>Nama Kerusakan</th>
                                                        <td> (<?php echo $value2['kode_kerusakan']; ?>) <?php echo $value2['nama_kerusakan']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Penyebab Kerusakan</th>
                                                        <td><?php echo $value2['penyebab_kerusakan']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Solusi Kerusakan</th>
                                                        <td><?php echo $value2['solusi_kerusakan']; ?></td>
                                                    </tr>
                                            <?php    }
                                            } ?>
                                        </table>
                                    </div>

                                <?php    } ?>

                            </div> <br>

                            <?php if ($form) {
                            ?>
                                <h5 style="text-align: center;">Tanyakan Dulu Kepada Pelanggan Apakah Ingin Melakukan Perbaikan !!</h5>
                                <h5 style="text-align: center;">Kalau Setuju Melakukan Perbaikan Lanjut Isi Form di Bawah</h5> <br>
                                <div class="form-group">
                                    <label for="nama_customer">Nama Pelanggan</label>
                                    <input type="text" class="form-control rounded-0" name="nama_customer" id="nama_customer" placeholder="Nama Customer">
                                </div>

                                <div class="form-group">
                                    <label for="no_telepon_customer">No Telepon Pelanggan</label>
                                    <input type="text" class="form-control rounded-0" name="no_telepon_customer" id="no_telepon_customer" placeholder="No Telepon Customer">
                                </div>

                                <div class="form-group">
                                    <label for="alamat_customer">Alamat Pelanggan</label>
                                    <textarea class="form-control rounded-0" name="alamat_customer" id="alamat_customer" placeholder="Alamat Customer"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="nama_teknisi">Nama Teknisi</label>
                                    <select class="form-control rounded-0 select2" name="nama_teknisi" id="nama_teknisi" style="width: 100%;">
                                        <option></option>
                                        <?php foreach ($teknisi as $key => $value) {
                                        ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['kode_pegawai'] . ' - ' . $value['nama_pegawai']; ?></option>

                                        <?php  } ?>
                                    </select>
                                </div>
                            <?php   } ?>


                            <div class="form-group">
                                <?php if ($form) {
                                ?>
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                <?php  } ?>
                                <button type="button" class="btn btn-warning btn-flat back"><i class="fas fa-redo"></i> Kembali Konsultasi</button>
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

    $('#nama_teknisi').select2({
        placeholder: "-- PILIH TEKNISI --",
    });

    $(document).on('click', '.back', function() {
        Swal.fire({
            title: 'Apakah Anda Yakin Kembali Ke Awal Konsultasi ?',
            showCancelButton: true,
            confirmButtonText: `Kembali`,
            confirmButtonColor: '#d33',
            icon: 'question'
        }).then((result) => {
            if (result.value) {
                window.location.href = "<?php echo base_url('konsultasi'); ?>"
            }
        });
    });

    $(document).on('submit', 'form#perbaikan', function() {
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