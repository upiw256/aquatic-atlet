<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h3>Jadikan Owner: <?= esc($user['name']) ?></h3>

<form method="post" action="<?= site_url('/admin/assign-owner/' . $user['id']) ?>">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="team_id" class="form-label">Pilih Tim</label>
        <select name="team_id" class="form-select" id="teamSelect" required>
            <option value="">-- Pilih Tim --</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?= $team['id'] ?>"><?= esc($team['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
    <script>
        $( '#teamSelect' ).select2( {
            theme: 'bootstrap-5',
            placeholder: 'Pilih Owner',
            allowClear: true,
            width: '100%',
        } );
    </script>
<?= $this->endSection() ?>
