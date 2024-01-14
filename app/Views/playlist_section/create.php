<?= $this->extend('master/index') ?>

<?= $this->section('css'); ?>
<style>
    .audio {
        max-height: 1.59rem;
    }

    .album {
        cursor: pointer;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('title'); ?>
<title>Create Playlist</title>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<section class="content">
    <!-- general form elements disabled -->
    <div class="card rounded-0">
        <div class="card-header rounded-0 p-0">
            <ol class="breadcrumb float-sm-right bg-white my-0">
                <li class="breadcrumb-item"><a href="/playlist">Playlist</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
        <!-- /.card-header -->
        <form id="create-playlist-form" action="/playlist/store" method="post">
            <?= csrf_field() ?>
            <div class="card-body row m-0">
                <div class="col-4">
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Tittle</label>
                                <input name="title-playlist" type="text" class="form-control" placeholder="Enter ...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Image</label>
                                <input name="image-playlist" type="text" class="form-control" placeholder="Image Url [ Ration 1:1 ]">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- textarea -->
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description-playlist" class="form-control" rows="2" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <label>Add Music</label>
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 29.5rem;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>*</th>
                                                <th>Title</th>
                                                <th>Artist</th>
                                                <th>Album</th>
                                                <th>Preview</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- general form elements disabled -->
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script>

</script>
<script src="<?= base_url('js\playlist_create_section.js') ?>"></script>
<?= $this->endSection() ?>