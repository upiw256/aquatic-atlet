<?= $this->extend('layouts/owner_layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Biodata Saya</h2>
    <form action="<?= site_url('/owner/profile/save') ?>" enctype="multipart/form-data" method="post">
        <?= csrf_field() ?>

        <?= view('partials/biodata_fields', ['biodata' => $biodata]) ?>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<?= $this->endSection() ?>
