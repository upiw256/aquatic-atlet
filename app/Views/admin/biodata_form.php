<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Edit Biodata Pengguna</h2>
    <form action="<?= site_url('/admin/biodata/save/' . $userId) ?>" method="post">
        <?= csrf_field() ?>

        <?= view('partials/biodata_fields', ['biodata' => $biodata]) ?>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<?= $this->endSection() ?>
