<?= $this->extend('master/index'); ?>

<?= $this->section('title'); ?>
<title>Music</title>
<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<style>
    .table td {
        border: none !important;
    }

    .audio {
        max-height: 1.59rem;
    }

    tbody td {
        padding: 0;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('navSearchButton'); ?>
<!-- Navbar Search -->
<li class="nav-item">
    <a class="nav-link" data-widget="navbar-search" data-target="#main-header-search" href="#" role="button">
        <i class="fas fa-search"></i>
    </a>
    <div class="navbar-search-block" id="main-header-search">
        <form id="navbar-form" class="form-inline">
            <?= csrf_field() ?>
            <div class="input-group input-group-sm">
                <input name="param" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div id="button-container-navbar" class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</li>
<?= $this->endSection(); ?>
<?= $this->section('content'); ?>
<section>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pl-3 pr-2">
        <!-- TABLE: LATEST ORDERS -->
        <div class="row mr-0">
            <div class="col-12 px-0">
                <div class="card mb-0">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 84vh;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th class="font-weight-light"><i class="font-weight-bold">T</i>RACK</th>
                                    <th class="font-weight-light" style="width: 8rem;"><i class="font-weight-bold">A</i>RTIST</th>
                                    <th class="font-weight-light" style="width: 8rem;"><i class="font-weight-bold">A</i>LBUM</th>
                                    <th class="font-weight-light text-center" style="width: 0;"><i class="font-weight-bold">P</i>REVIEW</th>
                                    <th class="font-weight-light text-center"><i class="font-weight-bold">L</i>IKE</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>
                    </div>
                    <div class=" card-footer text-center bg-white border-top border-muted">
                        <button id="btn-prev" role="button" class="btn btn-primary uppercase badge px-4 py-1 rounded-0"><i class="font-weight-bold text-white lead">p</i><span class="text-light lead">rev</span></button>
                        <button id="btn-next" role="button" class="btn btn-dark uppercase badge px-4 py-1 rounded-0"><i class="font-weight-bold text-white lead">n</i><span class="text-light lead">ext</span></button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->


        <!-- /.card -->
    </div>
    <!-- /.content-wrapper -->
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<?php if (auth()->loggedIn()) : ?>
    <script src="<?= base_url('js\music_list_section_auth.js') ?>"></script>
<?php else : ?>
    <script src="<?= base_url('js\music_list_section_default.js') ?>"></script>
<?php endif; ?>
<?= $this->endSection() ?>















<div class="card rounded-0 shadow-none">
    <!-- /.card-header -->
    <!-- <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0" style="height: 100%;">
                <thead>
                    <tr>
                        <th class="font-weight-light"><i class="font-weight-bold">T</i>RACK</th>
                        <th class="font-weight-light" style="width: 8rem;"><i class="font-weight-bold">A</i>RTIST</th>
                        <th class="font-weight-light" style="width: 8rem;"><i class="font-weight-bold">A</i>LBUM</th>
                        <th class="font-weight-light text-center" style="width: 0;"><i class="font-weight-bold">P</i>REVIEW</th>
                        <th class="font-weight-light text-center"><i class="font-weight-bold">L</i>IKE</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>
    </div> -->
    <!-- /.table-responsive -->

    <!-- /.card-body -->
    <!-- <div class=" card-footer text-center bg-white border-top border-muted">
        <button id="btn-prev" role="button" class="btn btn-primary uppercase badge px-4 py-1 rounded-0"><i class="font-weight-bold text-white lead">p</i><span class="text-light lead">rev</span></button>
        <button id="btn-next" role="button" class="btn btn-dark uppercase badge px-4 py-1 rounded-0"><i class="font-weight-bold text-white lead">n</i><span class="text-light lead">ext</span></button>
    </div> -->
    <!-- /.card-footer -->
</div>