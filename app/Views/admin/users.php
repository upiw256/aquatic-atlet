<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Kelola Tim</h1>
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama atau email...">
    </div>
    <table class="table table-bordered table-striped" id="userTable">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="nama"><?= esc($user['name']) ?></td>   
                    <td class="email"><?= esc($user['email']) ?></td>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge bg-danger">Admin</span>
                        <?php elseif ($user['role'] === 'owner'): ?>
                            <span class="badge bg-primary">Owner</span>
                        <?php elseif ($user['role'] === 'member'): ?>
                            <span class="badge bg-success">Member</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Unknown</span>
                        <?php endif; ?>     
                    </td>
                    <td>
                    <?php if (session()->get('user_id') !== $user['id']): ?>
                        <button onclick="resetPassword('<?= $user['id'] ?>')" class="btn btn-sm btn-warning">Reset Password</button>
                        
                    <?php if ($user['role'] === 'member'): ?>
                        <button onclick="confirmJadikanAdmin('<?= $user['id'] ?>','<?= $user['name'] ?>')" class="btn btn-sm btn-info">Jadikan Admin</button>

                    <?php elseif ($user['role'] === 'admin'): ?>
                        <button onclick="confirmJadikanAdmin('<?= $user['id'] ?>','<?= $user['name'] ?>')" class="btn btn-sm btn-primary">Jadikan Member</button>

                    <?php elseif ($user['role'] === 'owner'): ?>
                        <!-- Tidak tampilkan tombol apapun -->
                    <?php endif; ?>
                    <?php endif; ?>
                    </td>            
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <?= $pager->links('group1','bootstrap_full') ?>
    </div>
</div>


<?= $this->endSection() ?>