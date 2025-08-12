<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Edit Tim</h1>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form action="/admin/teams/update/<?= $team['id'] ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= esc($team['id']) ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Nama Tim</label>
        <input type="text" name="name" class="form-control" value="<?= esc($team['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="owner_id" class="form-label">Pilih Owner</label>
        <select name="owner_id" class="form-select" id="editOwnerSelect">
            <option value="">Pilih Owner</option>
            <option value="<?= $users[0]['id'] ?>" selected><?= $users[0]['name'] ?> (<?= $users[0]['email'] ?>)</option>
            <?php foreach ($owners as $owner): ?>
                <option value="<?= esc($owner['id']) ?>">
                    <?= esc($owner['name']) ?> (<?= esc($owner['email']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi Tim</label>
        <textarea name="description" class="form-control" rows="4"><?= esc($team['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="logo" class="form-label">Logo Tim</label>
        <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
        <small class="form-text text-muted">Format: PNG, JPG, maksimal 2MB.</small>
        <div class="mt-3">
            <?php if ($team['logo']): ?>
                <img id="logoPreview" src="<?= base_url('uploads/logo/' . $team['logo']) ?>" alt="Preview Logo" style="max-width: 200px; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
            <?php else: ?>
                <img id="logoPreview" src="#" alt="Preview Logo" style="display: none; max-width: 200px; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
            <?php endif; ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="/admin/teams" class="btn btn-secondary">Kembali</a>
</form>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const logoPreview = document.getElementById('logoPreview');
            logoPreview.src = e.target.result;
            logoPreview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
    function editOwnerSelect() {
        const ownerSelect = document.getElementById('editOwnerSelect');
        const selectedValue = ownerSelect.value;

        // Set the selected value in the select element
        ownerSelect.value = selectedValue;

        // If no owner is selected, disable the select element
        if (selectedValue === '') {
            ownerSelect.disabled = true;
        } else {
            ownerSelect.disabled = false;
        }
    }
    $( '#editOwnerSelect' ).select2( {
            theme: 'bootstrap-5',
            placeholder: '<?= $users[0]['name'] ?>',
            value: '<?= $users[0]['id'] ?>',
            allowClear: true,
            width: '100%',
        } );
</script>

<?= $this->endSection() ?>