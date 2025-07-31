<?= $this->extend('layouts/owner_layout') ?>
<?= $this->section('content') ?>

<h3>Profil Saya</h3>
<form method="post" action="/owner/profile">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>

<?= $this->endSection() ?>