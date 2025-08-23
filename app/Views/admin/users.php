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
                        <?php else: ?>
                            <button class="btn btn-sm btn-secondary" onclick="changePassword('<?= $user['id'] ?>')">Ganti Password</button>
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

    function changePassword(userId) {
        Swal.fire({
            title: 'Ganti Password',
            html: `
        <div class="swal2-input-group" style="position:relative">
            <input id="old-password" type="password" class="swal2-input" placeholder="Masukkan password lama">
            <i id="toggle-old" class="ti ti-eye" 
               style="position:absolute; right:15px; top:18px; cursor:pointer;"></i>
        </div>
        <div class="swal2-input-group" style="position:relative">
            <input id="new-password" type="password" class="swal2-input" placeholder="Masukkan password baru">
            <i id="toggle-new" class="ti ti-eye" 
               style="position:absolute; right:15px; top:18px; cursor:pointer;"></i>
        </div>
        <div class="swal2-input-group" style="position:relative">
            <input id="confirm-password" type="password" class="swal2-input" placeholder="Konfirmasi password baru">
            <i id="toggle-confirm" class="ti ti-eye" 
               style="position:absolute; right:15px; top:18px; cursor:pointer;"></i>
        </div>
    `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            didOpen: () => {
                const togglePassword = (inputId, toggleId) => {
                    const input = document.getElementById(inputId);
                    const toggle = document.getElementById(toggleId);

                    toggle.addEventListener('click', () => {
                        if (input.type === "password") {
                            input.type = "text";
                            toggle.classList.remove("ti-eye");
                            toggle.classList.add("ti-eye-off");
                        } else {
                            input.type = "password";
                            toggle.classList.remove("ti-eye-off");
                            toggle.classList.add("ti-eye");
                        }
                    });
                };

                togglePassword("old-password", "toggle-old");
                togglePassword("new-password", "toggle-new");
                togglePassword("confirm-password", "toggle-confirm");
            },
            preConfirm: () => {
                const oldPassword = document.getElementById('old-password').value;
                const newPassword = document.getElementById('new-password').value;
                const confirmPassword = document.getElementById('confirm-password').value;

                if (!oldPassword || !newPassword || !confirmPassword) {
                    Swal.showValidationMessage('Semua field wajib diisi');
                    return false;
                }

                if (newPassword !== confirmPassword) {
                    Swal.showValidationMessage('Konfirmasi password tidak cocok');
                    return false;
                }

                return {
                    oldPassword,
                    newPassword
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/changePassword/${userId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        },
                        body: JSON.stringify({
                            old_password: result.value.oldPassword,
                            new_password: result.value.newPassword
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Password berhasil diganti',
                                icon: 'success'
                            }).then(() => {
                                // Refresh setelah sukses
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Terjadi kesalahan saat menghubungi server.', 'error');
                    });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Refresh jika user klik Batal
                window.location.reload();
            }
        });
    }
</script>

<?= $this->endSection() ?>