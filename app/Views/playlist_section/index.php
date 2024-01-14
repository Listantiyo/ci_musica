<?= $this->extend('master/index') ?>

<?= $this->section('css'); ?>
<style>
    .card-body>div>div>div {
        cursor: pointer;
    }

    div>.card-text {
        color: transparent;
        transition: 0.5s;
    }

    div:hover>.card-text {
        color: white;
        backdrop-filter: grayscale(1);

    }

    .card-title {
        font-size: 0.7rem;
        font-family: 'Monaco', 'Lucida Conosle', 'Courier New';
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
<title>Playlist</title>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<section class="content">
    <div class="card">
        <div class="card-header rounded-0 p-0">
            <ol class="breadcrumb float-sm-left bg-white my-0">
                <i class="back-button fa fa-arrow-left p-1 mr-2"></i>
            </ol>
            <ol class="breadcrumb float-sm-right bg-white my-0">
                <li class="breadcrumb-item"><a href="/music">Music</a></li>
                <li class="breadcrumb-item active">Playlist</li>
            </ol>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                    <a href="/playlist/create">
                        <div class="card mb-2 bg-white p-3">
                            <img class="card-img-top border" src="<?= base_url('plus.png') ?>" alt="Dist Photo 1">
                        </div>
                    </a>
                </div>
                <?php foreach ($playlist as $value) : ?>
                    <div class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-2">
                        <a href="<?= url_to('PlaylistController::show', $value['id']) ?>">
                            <div class="card mb-2 bg-gradient-dark">
                                <img class="card-img-top" src="<?= $value['image'] ?>" alt="Dist Photo 1">
                                <div class="card-img-overlay d-flex flex-column justify-content-end p-0">
                                    <h6 class="card-title bg-white text-muted pb-2 pr-2 pl-2 pt-2"><?= $value['name'] ?></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script>
    tempSave = true;
    const playlistShowBackButton = document.querySelector('.back-button');
    playlistShowBackButton.addEventListener('click', function() {
        location.href = '/music/show'
    })
</script>
<!-- <script src="<?= base_url('js\playlist_section.js') ?>"></script> -->
<?= $this->endSection() ?>