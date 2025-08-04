<?= $this->extend('layouts/owner_layout') ?>
<?= $this->section('content') ?>

<?php if ($team): ?>
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between align-items-center">
                <?= esc($team['name']) ?>
                <a href="/owner/team/edit/<?= esc($team['id']) ?>" class="btn btn-sm btn-outline-primary">Edit Tim</a>
            </h4>
            <p class="card-text"><?= esc($team['description']) ?></p>
            <p class="text-muted">Jumlah Anggota: <?= count($members) ?></p>
        </div>
    </div>

    <h5>Anggota Tim</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?= esc($member['name']) ?></td>
                    <td><?= esc($member['email']) ?></td>
                    <td>
                        <form action="/owner/dashboard/update-role" method="post" class="d-flex">
                            <?= csrf_field() ?>
                            <input type="hidden" name="member_id" value="<?= esc($member['team_member_id']) ?>">
                            <select name="role" class="form-select form-select-sm me-2">
                                <option value="point" <?= $member['role'] === 'point' ? 'selected' : '' ?>>Point</option>
                                <option value="Left Flat" <?= $member['role'] === 'Left Flat' ? 'selected' : '' ?>>Left Flat</option>
                                <option value="Right Flat" <?= $member['role'] === 'Right Flat' ? 'selected' : '' ?>>Right Flat</option>
                                <option value="Left Wing" <?= $member['role'] === 'Left Wing' ? 'selected' : '' ?>>Left Wing</option>
                                <option value="Right Wing" <?= $member['role'] === 'Right Wing' ? 'selected' : '' ?>>Right Wing</option>
                                <option value="Center Forward" <?= $member['role'] === 'Center Forward' ? 'selected' : '' ?>>Center Forward</option>
                                <option value="Goalkeeper" <?= $member['role'] === 'Goalkeeper' ? 'selected' : '' ?>>Goalkeeper</option>
                                <option value="cadangan" <?= $member['role'] === 'cadangan' ? 'selected' : '' ?>>Cadangan</option>
                                <option value="pelatih" <?= $member['role'] === 'pelatih' ? 'selected' : '' ?>>Pelatih</option>
                            </select>
                            <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
                        </form>
                    </td>
                    <td>
                        <form id="deleteForm-<?= $member['team_member_id'] ?>" action="/owner/dashboard/remove-member" method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="member_id" value="<?= esc($member['team_member_id']) ?>">
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $member['team_member_id'] ?>')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php if (empty($members)): ?>
                <tr>
                    <td colspan="4" class="text-muted text-center">Belum ada anggota.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

    <h5>Tambah Anggota</h5>
    <form method="post" action="/owner/team/add">
        <?= csrf_field() ?>
        <div class="input-group mb-3">
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Member --</option>
                <?php foreach ($availableMembers as $am): ?>
                    <option value="<?= esc($am['id']) ?>"><?= esc($am['name']) ?> (<?= esc($am['email']) ?>)</option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-success">Tambah</button>
        </div>
    </form>
<?php else: ?>
    <div class="alert alert-warning">Anda belum memiliki tim. Silakan hubungi admin.</div>
<?php endif; ?>

<?= $this->endSection() ?>
