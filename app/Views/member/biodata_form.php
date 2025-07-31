<?= $this->extend('layouts/layout_member') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Biodata Saya</h2>
    <form action="<?= site_url('/member/profile/save') ?>" enctype="multipart/form-data" method="post">
        <?= csrf_field() ?>

        <?= view('partials/biodata_fields', ['biodata' => $biodata]) ?>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<?= $this->endSection() ?>