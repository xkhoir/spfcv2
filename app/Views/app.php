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

<body class="hold-transition control-sidebar-slide-open layout-footer-fixed sidebar-mini layout-fixed ">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?= $this->include('include/navbar'); ?>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?= $this->include('include/sidebar'); ?>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content'); ?>
        </div>

        <?= $this->include('include/footer'); ?>

    </div>

    <?= $this->include('partial/script'); ?>

</body>

</html>