<?= $this->extend('master/index') ?>

<?= $this->section('css'); ?>
<style>
    body {
        background: url(<?= base_url('background-hero.jpg') ?>);
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('title'); ?>
<title>Hero</title>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<section class="content pt-5">
    <div class="container-fluid">
        <h2 class="text-center display-4">Search</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form id="hero-form">
                    <?= csrf_field() ?>
                    <div class="input-group" method="post">
                        <input name="param" type="search" class="form-control form-control-lg border border-top-0 border-right-0 border-left-0 rounded-0" placeholder="Find Music">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default border border-top-0 border-right-0 border-left-0 rounded-0 bg-white">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script>
    let csrf = {
        'csrf_name': '<?= csrf_token() ?>',
        'csrf_token': '<?= csrf_hash() ?>'
    }
</script>
<script src="<?= base_url('js\hero_section.js') ?>"></script>
<?= $this->endSection() ?>