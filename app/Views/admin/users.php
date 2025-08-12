<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Kelola User</h1>

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
                        <?php elseif ($user['member_id'] != null): ?>
                            <span class="badge bg-success">Atlet</span>
                        <?php elseif ($user['role'] === 'inspector'): ?>
                            <span class="badge bg-warning">Inspector</span>
                        <?php elseif ($user['role'] === 'member'): ?>
                            <span class="badge bg-warning">Memeber</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Unknown</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (session()->get('user_id') !== $user['id']): ?>
                            <button onclick="resetPassword('<?= $user['id'] ?>')" class="btn btn-sm btn-warning">Reset Password</button>

                            <?php if (
                                $user['role'] === 'member' &&
                                empty($user['member_id']) && // belum gabung tim
                                empty($user['is_owner'])     // bukan owner
                            ): ?>
                                <button class="btn btn-sm btn-info" onclick="confirmJadikanAdmin('<?= $user['id'] ?>','<?= $user['name'] ?>','admin')">Jadikan Admin</button>
                                <button class="btn btn-sm btn-success" onclick="confirmJadikanAdmin('<?= $user['id'] ?>','<?= $user['name'] ?>','inspector')">Jadikan Pengawas</button>

                            <?php elseif ($user['role'] === 'admin' || $user['role'] === 'inspector'): ?>
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
</div>

<script>
    function confirmJadikanAdmin(userId, userName, role) {
        Swal.fire({
            title: 'Yakin akan merubah role?',
            text: ` ${userName} akan Merubah role.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setuju!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/updateRole/`, {
                        method: 'put',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        },
                        body: JSON.stringify({
                            role: role,
                            user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                html: data.message,
                                icon: 'success'
                            }).then(() => {
                                location.reload(); // reload seluruh halaman
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', `Terjadi kesalahan saat menghubungi server. ${err}`, 'error');
                    });
            }
        });
    }
</script>

<?= $this->endSection() ?>