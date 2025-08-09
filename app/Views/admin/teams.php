<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Kelola Tim</h1>

    <a href="/admin/teams/create" class="btn btn-primary mb-3">+ Buat Tim Baru</a>

    <table id="team" class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Tim</th>
                <th>Owner</th>
                <th>Jumlah Atlit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=0; foreach ($teams as $team): ?>
                <tr>
                    <td><?= $i = $i+1  ?></td>
                    <td><?= esc($team['name']) ?></td>
                    <td><?= esc($team['owner_name'] === null ? '-' : $team['owner_name']) ?></td>
                    <td><?= esc($team['member_count']) ?></td>
                    <td>
                        <a href="/admin/teams/<?= $team['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                        <a href="/admin/teams/<?= $team['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/admin/teams/<?= $team['id'] ?>/delete" class="btn btn-sm btn-danger" onclick="return confirm('Hapus tim ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>