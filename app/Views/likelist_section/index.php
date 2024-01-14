<?= $this->extend('master/index') ?>

<?= $this->section('css'); ?>
<style>
    /* .table td {
        border: none !important;
    } */

    .audio {
        max-height: 1.59rem;
    }

    tbody td {
        padding: 0;
    }

    .card-footer.bg-white.border-top.border-muted nav ul li {
        margin-right: 10px;
        margin-left: 10px;
    }

    .back-button {
        cursor: pointer;
    }

    .back-button:hover {
        cursor: pointer;
        color: blue;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('title'); ?>
<title>Likelist</title>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<section>
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mx-0 pl-2 pr-2 py-2 row" style="height: 84vh;">
        <div id="column-detail" class="col-sm-12 col-md-4 col-xl-3 ml-0">
            <div class="card" style="height: 100%;">
                <div class="card-header"><span class="font-weight-light"><i class="back-button fa fa-arrow-left p-1 mr-2"></i> <i class="font-weight-bold">L</i>IKELIST <i class="font-weight-bold">D</i>ETAIL</span></div>
                <div class="card-body">
                    <div class="card card-second" style="height: 100%;">
                        <div class="card-header">
                            <div class="badge badge-info text-wrap d-flex justify-content-center">
                                <em><i id="counted-song"><?= esc($liked_music_count) ?></i> Liked Song</em>
                            </div>
                        </div>
                        <div class="card-body row d-flex justify-content-center">
                            <div class="col-12 d-flex justify-content-center align-middle"><img style="object-fit: contain;" id="image-preview" src="https://i.pinimg.com/474x/76/33/63/763363a3be941b93610d58f8fb54e638.jpg" alt=""></div>
                            <div class="col-12 pt-3 text-center">
                                <i id="title-preview"></i>
                            </div>
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
                                    <th class="font-weight-light text-center" style="width: 8rem;"><i class="font-weight-bold">P</i>LAYLIST</th>
                                    <th class="font-weight-light text-center"><i class="font-weight-bold">D</i>ELETE</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php foreach ($data as $value) : ?>
                                    <tr>
                                        <td class="py-2 align-middle">
                                            <a href="<?= $value['full_link'] ?>" target="_blank"><span class="title" title="TOOLTIP"><?= $value['title'] ?></span></a>
                                        </td>
                                        <td class="artist py-2 align-middle"><?= $value['artist'] ?></td>
                                        <td class="py-2 align-middle">
                                            <img class="album" data-cover-medium="<?= $value['cover_medium'] ?>" src="<?= $value['cover_small'] ?>">
                                        </td>
                                        <td class="py-2 align-middle">
                                            <audio class="audio" preload="none" controls src="<?= $value['preview'] ?>"></audio>
                                        </td>
                                        <td class="text-center">
                                            <button class="playlist-button btn btn-light border-0 rounded" onclick="addToPlaylistButton(this)" data-id="<?= $value['id'] ?>">
                                                <i class="fas fa-plus" style="color: red;"></i>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button class="trash-button btn btn-light border-0 rounded" onclick="deleteSongButton(this)" data-id="<?= $value['id_music'] ?>">
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

    <!-- /.content-wrapper -->
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script>

</script>
<script src="<?= base_url('js\likelist_section.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section('modal') ?>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted">Add To Playlist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modal-form" action="" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="selected-playlist-id" class="form-control select2" data-dropdown-css-class="select2-info" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-info">Add</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $this->endSection() ?>

<!-- 

 Idea : show played song at blank page

 -->