<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1>Daftar Kompetisi</h1>
<button class="btn btn-primary mb-3" onclick="location.href='<?= site_url('admin/competitions/create') ?>'">Tambah Kompetisi</button>

<table id="competitionsTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kompetisi</th>
            <th>Tingkat</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Batas Pendaftaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($competitions as $competition): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= esc($competition['name']) ?></td>
                <td><?= esc($competition['level']) ?></td>
                <td><?= esc($competition['start_date']) ?></td>
                <td><?= esc($competition['location']) ?></td>
                <td><?= esc($competition['registration_deadline']) ?></td>
                <td>
                    <a href="<?= site_url('admin/competitions/edit/' . $competition['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?= site_url('admin/competitions/delete/' . $competition['id']) ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kompetisi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#competitionsTable').DataTable();
    });
</script>

<?= $this->endSection() ?>