<?= $this->extend('layouts/owner_layout') ?>
<?= $this->section('content') ?>

<h3>Edit Tim</h3>
<form action="/owner/team/update/<?= esc($team['id']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Nama Tim</label>
        <input type="text" name="name" id="name" value="<?= esc($team['name']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" id="description" rows="4" class="form-control"><?= esc($team['description']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="/owner/dashboard" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
