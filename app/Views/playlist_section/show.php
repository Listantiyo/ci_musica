<?= $this->extend('master/index') ?>

<?= $this->section('css'); ?>
<style>
    /* .table td {
        border: none !important;
    } */
    body {
        padding: 0 !important;
    }

    .audio {
        max-height: 1.59rem;
    }

    .album {
        cursor: pointer;
        transition: 1s;
    }

    .back-button {
        cursor: pointer;
    }

    .back-button:hover {
        cursor: pointer;
        color: blue;
    }

    tbody td {
        padding: 0;
    }

    .card-footer.bg-white.border-top.border-muted nav ul li {
        margin-right: 10px;
        margin-left: 10px;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('title'); ?>
<title>Likelist</title>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section data-playlist="<?= esc($playlist['id']) ?>">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mx-0 pl-2 pr-2 py-2 row" style="height: 84vh;">
        <div id="column-detail" class="col-sm-12 col-md-4 col-xl-3 ml-0">
            <div class="card" style="height: 100%;">
                <div class="card-header"><span class="font-weight-light"> <i class="back-button fa fa-arrow-left p-1 mr-2"></i> <i class="font-weight-bold">P</i>LAYLIST <i class="font-weight-bold">D</i>ETAIL</span></div>
                <div class="card-body">
                    <div class="card my-0">
                        <div id="playlist-name" class="card-header">
                            <h5><?= esc($playlist['name']) ?></h5>
                        </div>
                        <div class="card-body row">
                            <div id="playlist-image" class="col d-flex justify-content-center"><img src="<?= esc($playlist['image']) ?>" alt="" srcset=""></div>
                            <div id="playlist-description" class="col pt-3 text-center">
                                <sub><?= esc($playlist['description']) ?></sub>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-danger" id="deletePlaylistButton"><i class="fa fa-trash"></i></button>
                            <button class="btn btn-warning" id="editDetailPlaylistButton"><i class="fa fa-edit"></i> Edit Detail</button>
                            <button class="btn btn-success" id="addSongButton"><i class="fa fa-plus"></i> Add Song</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- TABLE: LATEST ORDERS -->
        <div id="column-item" class="col-sm-12 col-md-8 col-xl-9 row mx-0">
            <div class="col-12 px-0">
                <div class="card mb-0" style="height: 100%;">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 84vh;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th class="font-weight-light"><i class="font-weight-bold">T</i>RACK</th>
                                    <th class="font-weight-light" style="width: 8rem;"><i class="font-weight-bold">A</i>RTIST</th>
                                    <th class="font-weight-light" style="width: 8rem;"><i class="font-weight-bold">A</i>LBUM</th>
                                    <th class="font-weight-light text-center" style="width: 0;"><i class="font-weight-bold">P</i>REVIEW</th>
                                    <th class="font-weight-light text-center"><i class="font-weight-bold">D</i>ELETE</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php foreach ($data as $value) : ?>
                                    <tr>
                                        <td class="py-2 align-middle">
                                            <a href="<?= esc($value['full_link']) ?>" target="_blank"><span title="<?= esc($value['title']) ?>"><?= esc($value['title']) ?></span></a>
                                        </td>
                                        <td class="py-2 align-middle"><?= esc($value['artist']) ?></td>
                                        <td class="py-2 align-middle">
                                            <img class="album" src="<?= esc($value['cover_small']) ?>">
                                        </td>
                                        <td class="py-2 align-middle">
                                            <audio class="audio" preload="none" controls src="<?= esc($value['preview']) ?>"></audio>
                                        </td>
                                        <td class="text-center">
                                            <button class="trash-button btn btn-light border-0 rounded" onclick="deletePlaylistSongButton(this)" data-id="<?= esc($value['song_id']) ?>">
                                                <i class="fa fa-trash" style="color: red;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class=" card-footer bg-white border-top border-muted pb-0">
                        <?= $pager->links() ?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.content-wrapper -->
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script src="<?= base_url('js\playlist_show_section.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modal-form" action="" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" disabled></button>
                </div>
                <input type="hidden" name="playlist-id" value="<?= esc($playlist['id']) ?>">
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection() ?>