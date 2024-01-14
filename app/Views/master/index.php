<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->renderSection('title'); ?>
    <?= $this->renderSection('css'); ?>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light m-0">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/music" class="nav-link"><i class="font-weight-bold">M</i>usica</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <?= $this->renderSection('navSearchButton') ?>
                <?php if (auth()->loggedIn()) : ?>

                    <!-- Notifications Dropdown Menu -->

                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fa fa-solid fa-bars"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header">Options</span>
                            <div class="dropdown-divider"></div>
                            <a href="/likelist" class="dropdown-item">
                                <i class="far fa-heart mr-2"></i> Likelist
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/playlist" class="dropdown-item">
                                <i class="fa fa-table mr-2"></i> Playlist
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/profile" class="dropdown-item">
                                <i class="far fa-user mr-2"></i> <?= auth()->user()->username ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a type="button" href="/logout" id="logout-button" class="dropdown-item dropdown-footer font-weight-bold">Logout<i class="fa fa-sm fa-arrow-right ml-2"></i></a>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/login" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <i class="nav-link px-0">|</i>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/register" class="nav-link">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.navbar -->

        <?= $this->renderSection('content'); ?>
        <!-- <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer> -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>

    <!-- Select2 -->
    <script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <!-- Custom Javascript -->
    <script>
        let tempSave = false;
        let internet = false;
    </script>
    <?= $this->renderSection('js') ?>
    <script>
        if (!tempSave) {
            sessionStorage.removeItem('tempData');
            sessionStorage.removeItem('tempUserIds');
        }

        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>

</body>

<?= $this->renderSection('modal') ?>

</html>