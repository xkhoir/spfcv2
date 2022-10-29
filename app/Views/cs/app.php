<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('partial/meta'); ?>
    <script>
        $(document).ajaxStart(function() {
            Pace.restart();
        });
    </script>
</head>

<body class="hold-transition layout-top-nav layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-dark navbar-lightblue">
            <?= $this->include('cs/include/navbar'); ?>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content'); ?>
        </div>

        <?= $this->include('include/footer'); ?>

    </div>

    <?= $this->include('partial/script'); ?>

</body>

</html>