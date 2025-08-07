<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Edit data penghargaan</h1>
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
        <input type="text" class="form-control visually-hidden" id="member_name" name="member_id" value="<?= $achivements[0]['member_id'] ?>">
        <input type="text" class="form-control visually-hidden" id="id" name="id" value="<?= $achivements[0]['id'] ?>">
        <fieldset disabled>
        <input type="text" class="form-control " id="member_name" name="member_name" value="<?= $achivements[0]['member_name'] ?>">
    </fieldset>
    </div>
    <div class="form-group">
        <label for="name">Nama Kejuaraan</label>
        <input type="text" class="form-control" id="name" name="nama_kejuaraan" value="<?= $achivements[0]['nama_kejuaraan'] ?>" required>
    </div>
    <div class="form-group">
        <label for="location">Lokasi</label>
        <input type="text" class="form-control" id="location" name="lokasi" value="<?= $achivements[0]['lokasi'] ?>" required>
    </div>
    <div class="form-group">
        <label for="level">Tingkat</label>
        <input type="text" class="form-control" id="level" name="tingkat" value="<?= $achivements[0]['tingkat'] ?>" required>
    </div>
    <div class="form-group">
        <label for="year">Tahun</label>
        <input type="number" class="form-control" id="year" name="tahun" value="<?= $achivements[0]['tahun'] ?>" required>
    </div>
    <div class="form-group">
        <label for="final_position">Posisi Akhir</label>
        <input type="text" class="form-control" id="final_position" name="posisi_akhir" value="<?= $achivements[0]['posisi_akhir'] ?>" required>
    </div>
    <div class="form-group">
        <label for="score">Score</label>
        <input type="text" class="form-control" id="score" name="score" value="<?= $achivements[0]['skor'] ?>" required>
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