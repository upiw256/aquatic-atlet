<?= $this->extend('layouts/owner_layout') ?>
<?= $this->section('content') ?>

<h3>Edit Tim</h3>
<form action="/owner/team/update/<?= esc($team['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Nama Tim</label>
        <input type="text" name="name" id="name" value="<?= esc($team['name']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" id="description" rows="4" class="form-control"><?= esc($team['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="logo" class="form-label">Logo Tim (Upload File)</label>
        <input type="file" name="logo_file" id="logo" class="form-control" accept="image/*">

        <div class="mt-2">
            <!-- Tampilkan logo default dari folder public/uploads/logo/ -->
            <img id="logoPreview" src="<?= base_url('uploads/logo/' . esc($team['logo'])) ?>" alt="Logo Tim" style="max-height: 150px; max-width: 150px; object-fit: contain;">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="/owner/dashboard" class="btn btn-secondary">Kembali</a>
</form>

<script>
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logoPreview');

    logoInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            logoPreview.src = "<?= base_url('uploads/logo/' . esc($team['logo'])) ?>";
        }
    });
</script>

<?= $this->endSection() ?>
