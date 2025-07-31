<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Kelola Member</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $i => $member): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($member['name']) ?></td>
                    <td><?= esc($member['email']) ?></td>
                    <td><?= esc($member['role']) ?> <?= esc($member['team_name'] ?? '-') ?></td>
                    <td>
                        <?php if ($member['role'] === 'member'): ?>
                            <a href="/admin/assign-owner/<?= $member['id'] ?>" class="btn btn-sm btn-warning">Jadikan Owner</a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>