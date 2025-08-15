<?= $this->extend('layouts/' . session()->get('role') . '_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Kelola Member</h1>
    <table class="table table-bordered table-striped display nowrap" id="userTable">
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
            <?php $i = 0;
            foreach ($members as $member): ?>
                <tr>
                    <td><?= $i = $i + 1 ?></td>
                    <td class="nama"><?= esc($member['name']) ?></td>
                    <td class="email"><?= esc($member['email']) ?></td>
                    <td><?= esc($member['role']) ?> <?= esc($member['team']['name'] ?? $member['team_name']) ?></td>
                    <td>
                        <?php if (session()->get('role') === 'inspector'): ?>
                            <?php if (session()->get('user_id') === $member['id'] || $member['role'] === 'owner' || $member['team'] === null): ?>
                                <span class="text-muted">-</span>
                            <?php else: ?>
                                <a href="/inspector/portfolio/<?= $member['id'] ?>" class="btn btn-sm btn-primary"><i class="ti ti-printer"></i> Print</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($member['team'] === null && strtolower(trim($member['role'])) !== 'owner'): ?>
                                <a href="/admin/assign-owner/<?= $member['id'] ?>" class="btn btn-sm btn-warning">Jadikan Owner</a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<?= $this->endSection() ?>