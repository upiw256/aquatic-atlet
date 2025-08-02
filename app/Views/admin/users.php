<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Kelola Tim</h1>
    <table class="table table-bordered table-striped">
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
                    <td><?= esc($user['name']) ?></td>   
                    <td><?= esc($user['email']) ?></td>
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
                    <?php endif; ?>
                    </td>            
                </tr>
            <?php endforeach; ?>
        </tbody>
</div>
<?= $this->endSection() ?>