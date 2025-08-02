<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Tambah Tim Baru</h1>

<form action="/admin/teams/store" method="post">
    <?= csrf_field() ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <label for="name" class="form-label">Nama Tim</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="owner_id" class="form-label">Pilih Owner</label>
        <select name="owner_id" class="form-select" id="ownerSelect">
            <option value="">Pilih Owner</option>
            <?php foreach ($owners as $owner): ?>
                <option value="<?= esc($owner['id']) ?>"><?= esc($owner['name']) ?> (<?= esc($owner['email']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi Tim</label>
        <textarea name="description" class="form-control" rows="4"><?= old('description') ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="/admin/teams" class="btn btn-secondary">Kembali</a>
</form>
    <script>
        $( '#ownerSelect' ).select2( {
            theme: 'bootstrap-5',
            placeholder: 'Pilih Owner',
            allowClear: true,
            width: '100%',
        } );
    </script>

<?= $this->endSection() ?>