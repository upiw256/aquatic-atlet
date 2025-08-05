<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Kelola Member</h1>
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama atau email...">
    </div>
    <table class="table table-bordered table-striped" id="userTable">
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
                    <td><?= $i + 1 + ($perPage * ($page - 1)) ?></td>
                    <td class="nama"><?= esc($member['name']) ?></td>
                    <td class="email"><?= esc($member['email']) ?></td>
                    <td><?= esc($member['role']) ?> <?= esc($member['team']['name'] ?? $member['team_name']) ?></td>
                    <td>
                        <?php if ($member['team'] === null && strtolower(trim($member['role'])) !== 'owner'): ?>
                            <a href="/admin/assign-owner/<?= $member['id'] ?>" class="btn btn-sm btn-warning">Jadikan Owner</a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <?= $pager ?>
    </div>
</div>


<?= $this->endSection() ?>
