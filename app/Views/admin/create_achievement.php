<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Tambah Pencapaian Baru</h1>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('admin/achivement/save') ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="member_id">Nama Atlit</label>
        <select class="form-control" id="member_id" name="member_id" required>
            <option value="">-- Pilih Atlit --</option>
            <?php foreach ($members as $member): ?>
                <option value="<?= esc($member['team_member_id']) ?>"><?= esc($member['name']) ?> - (<?= esc($member['team_name']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="name">Nama Kejuaraan</label>
        <input type="text" class="form-control" id="name" name="nama_kejuaraan" required>
    </div>
    <div class="form-group">
        <label for="location">Lokasi</label>
        <input type="text" class="form-control" id="location" name="lokasi" required>
    </div>
    <div class="form-group">
        <label for="level">Tingkat</label>
        <input type="text" class="form-control" id="level" name="tingkat" required>
    </div>
    <div class="form-group">
        <label for="year">Tahun</label>
        <input type="number" class="form-control" id="year" name="tahun" required>
    </div>
    <div class="form-group">
        <label for="final_position">Posisi Akhir</label>
        <input type="text" class="form-control" id="final_position" name="posisi_akhir" required>
    </div>
    <div class="form-group">
        <label for="score">Score</label>
        <input type="text" class="form-control" id="score" name="score" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<script>
        $( '#member_id' ).select2( {
            theme: 'bootstrap-5',
            placeholder: 'Pilih Atlit',
            allowClear: true,
            width: '100%',
        } );
    </script>

<?= $this->endSection() ?>