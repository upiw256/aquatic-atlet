<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Daftar Kompetisi</h1>
<form action="<?= site_url('admin/competition/save') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name_competition" class="form-label">Nama Kompetisi</label>
        <input type="text" class="form-control" id="name_competition" name="name_competition" required>
    </div>
    <div class="mb-3">
        <label for="level" class="form-label">Tingkat</label>
        <select class="form-select" id="level" name="level" required>
            <option value="">Pilih Tingkat</option>
            <option value="lokal">Lokal</option>
            <option value="nasional">Nasional</option>
            <option value="internasional">Internasional</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Lokasi</label>
        <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <button type="submit" class="btn btn-primary">Tambah Kompetisi</button>
</form>

<?= $this->endsection() ?>