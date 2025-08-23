<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Tambah Kompetisi</h1>

<form action="<?= site_url('admin/competitions/store') ?>" method="post">
    <?= csrf_field() ?>

    <!-- Nama Kompetisi -->
    <div class="mb-3">
        <label for="name" class="form-label">Nama Kompetisi</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <!-- Deskripsi -->
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>

    <!-- Level -->
    <div class="mb-3">
        <label for="level" class="form-label">Tingkat</label>
        <select class="form-select" id="level" name="level" required>
            <option value="">Pilih Tingkat</option>
            <option value="local">Lokal</option>
            <option value="kabupaten">Kabupaten</option>
            <option value="provinsi">Provinsi</option>
            <option value="nasional">Nasional</option>
            <option value="internasional">Internasional</option>
        </select>
    </div>

    <!-- Tanggal Mulai -->
    <div class="mb-3">
        <label for="start_date" class="form-label">Tanggal Mulai</label>
        <input type="text" class="form-control" id="start_date" name="start_date" required>
    </div>

    <!-- Tanggal Selesai -->
    <div class="mb-3">
        <label for="end_date" class="form-label">Tanggal Selesai</label>
        <input type="text" class="form-control" id="end_date" name="end_date" required>
    </div>

    <!-- Lokasi -->
    <div class="mb-3">
        <label for="location" class="form-label">Lokasi</label>
        <input type="text" class="form-control" id="location" name="location" required>
    </div>

    <!-- Batas Pendaftaran -->
    <div class="mb-3">
        <label for="registration_deadline" class="form-label">Batas Pendaftaran</label>
        <input type="text" class="form-control" id="registration_deadline" name="registration_deadline" required>
    </div>

    <button type="submit" class="btn btn-primary">Tambah Kompetisi</button>
</form>

<script>
    $(function() {
        $('#start_date, #end_date, #registration_deadline').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
</script>

<?= $this->endSection() ?>
