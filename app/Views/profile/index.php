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
<title>Profile</title>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<section class="content">
    <div class="card" style="height: 84vh;">
        <div class="card-header rounded-0 p-0">
            <ol class="breadcrumb float-sm-left bg-white my-0">
                <i class="back-button fa fa-arrow-left p-1 mr-2"></i>
            </ol>
        </div>
        <div class="card-body d-flex justify-content-center row">

            <div class="card card-widget widget-user shadow col-4">
                <div class="card-header">
                    <h3 class="widget-user-username"><?= auth()->user()->username ?></h3>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <img class="img-circle" src="https://i.pinimg.com/474x/76/33/63/763363a3be941b93610d58f8fb54e638.jpg" alt="User Avatar">
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <span class="description-header"><a href="/playlist" type="button" class="btn btn-warning"><?= esc($playlist) ?> PLAYLIST</a></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <form id="form-delete-user" action="/profile/delete" method="post">
                                    <?= csrf_field() ?>
                                    <span class="description-header">
                                        <button type="submit" class="btn btn-outline-danger" id="delete-user"><i class="fa fa-trash"></i></button>
                                    </span>
                                </form>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <span class="description-header"><a href="/likelist" type="button" class="btn btn-success"><?= esc($likedSongs) ?> LIKELIST</a></span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
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

    let Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    const deleteUserButton = document.querySelector('#delete-user');
    deleteUserButton.addEventListener('click', (event) => {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-user').submit();
            }
        })
    })
</script>
<!-- <script src="<?= base_url('js\playlist_section.js') ?>"></script> -->
<?= $this->endSection() ?>