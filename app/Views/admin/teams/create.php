<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Tambah Tim Baru</h1>

<form action="/admin/teams/store" method="post" enctype="multipart/form-data">
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

    <div class="mb-3">
        <label for="logo" class="form-label">Logo Tim</label>
        <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
        <small class="form-text text-muted">Format: PNG, JPG, maksimal 2MB.</small>
        <div class="mt-3">
            <img id="logoPreview" src="#" alt="Preview Logo" style="display: none; max-width: 200px; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
        </div>
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

<script>
function previewLogo(event) {
    const input = event.target;
    const preview = document.getElementById('logoPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>

<?= $this->endSection() ?>
