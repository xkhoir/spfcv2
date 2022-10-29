<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('partial/meta'); ?>
</head>

<body>

    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <h3 style="text-align: center;">Toko Akbar Parabola</h3>
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <small style="font-size:  ;" class="float-right">Tanggal Perbaikan : <?php echo $perbaikan->tanggal_mulai_perbaikan; ?></small>
                        <br>
                        <small style="font-size:  ;" class="float-right">Tanggal Selesai : <?php echo $perbaikan->tanggal_selesai_perbaikan; ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        Nama Pelanggan : <?php echo $perbaikan->nama_customer; ?><br>
                        Alamat Pelanggan : <?php echo $perbaikan->alamat_customer; ?><br>
                        No Telepon Pelanggan : <?php echo $perbaikan->no_telepon_customer; ?><br>
                    </address>
                </div>
                <!-- /.col -->
                <!-- /.col -->
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <h5>Gejala yang disampaikan Pelanggan :</h5>
            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Gejala</th>
                                <th>Nama Gejala</th>
                                <th>Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gejala as $key => $value) {
                            ?>
                                <tr>
                                    <td><?php echo $value['kode_gejala']; ?></td>
                                    <td><?php echo $value['nama_gejala']; ?></td>
                                    <td><?php echo $value['answer']; ?></td>
                                </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <h5>Berdasarkan Pengolahan Data Gejala di Atas Bahwa :
                <!-- Table row -->
                <?php if (is_array($kerusakan)) {
                    if ($total_kerusakan > 1) {
                ?>
                        Sistem Telah Menemukan Kemungkinan Kerusakan Sebagai Berikut : 
                        <i style="color: orange;" class="fas fa-info-circle"></i>
                    <?php    } else if ($total_kerusakan == 1) {
                    ?>
                        Sistem Telah Menemukan Kerusakan :
                        <i style="color: green;" class="fas fa-check-circle"></i>
                    <?php   }
                    ?>

            </h5> <br>
            <h5>Dengan Data di Berikut Ini</h5>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-hover text-nowrap table-bordered text-nowrap">
                        <?php foreach ($kerusakan as $key => $value) {
                        ?>
                            <tr>
                                <th>Nama Kerusakan</th>
                                <td> (<?php echo $value['kode_kerusakan']; ?>) <?php echo $value['nama_kerusakan']; ?></td>
                            </tr>
                            <tr>
                                <th>Penyebab Kerusakan</th>
                                <td><?php echo $value['penyebab_kerusakan']; ?></td>
                            </tr>
                            <tr>
                                <th>Solusi Kerusakan</th>
                                <td><?php echo $value['solusi_kerusakan']; ?></td>
                            </tr>
                        <?php     } ?>

                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        <?php } else {
        ?>
            <div class="row">
                <div class="col-12 table-responsive">
                    <p>
                    <h5 style="text-align: center;">Sistem Tidak Menemukan Kerusakan
                        <i style="color: red;" class="fas fa-times-circle"></i>
                    </h5>
                    </p>
                    Catatan Tambahan :
                    <br> <br>
                    <p>
                    <h3><?php echo $kerusakan; ?></h3>
                    </p>
                </div>
            </div>
            <!-- /.row -->
        <?php  } ?>


        <div class="row">
            <!-- accepted payments column -->
            <!-- /.col -->
            <div class="col-12" style="text-align: center;">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="col-3" style="width:50%">Customer Service :</th>
                            <th class="col-3" style="width:50%">Teknisi yang Bertugas :</th>
                            <th class="col-3" style="width:50%">Pelanggan :</th>

                        </tr>

                        <tr>
                            <td><?php echo $pegawai['cs']; ?></td>
                            <td><?php echo $pegawai['teknisi']; ?></td>
                            <td><?php echo $perbaikan->nama_customer; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>