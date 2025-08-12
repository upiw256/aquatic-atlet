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
</div>

<script>
    const tbody = document.querySelector('#userTable tbody');
    const pager = document.querySelector('.d-flex.justify-content-center');
    const originalTbody = tbody.innerHTML;
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    searchButton.addEventListener('click', () => {
        const query = searchInput.value.trim();
        searchUsers(query);
    });

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            searchUsers(searchInput.value.trim());
        }
    });

    async function searchUsers(query) {
        if (query.length < 3) {
            tbody.innerHTML = originalTbody;
            pager.style.display = 'flex';
            return;
        }

        try {
            const res = await fetch(`/admin/users/search?q=${encodeURIComponent(query)}`);
            const users = await res.json();

            pager.style.display = 'none';
            tbody.innerHTML = '';

            if (users.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada hasil ditemukan</td></tr>`;
                return;
            }

            users.forEach((user, index) => {
                const badgeClass = user.role === 'admin' ? 'danger' :
                    user.role === 'owner' ? 'primary' :
                    user.role === 'member' ? 'success' : 'secondary';

                let aksi = '';
                if ('<?= session()->get('user_id') ?>' !== user.id) {
                    aksi += `<button onclick="resetPassword('${user.id}')" class="btn btn-sm btn-warning">Reset Password</button> `;
                    if (user.role === 'member') {
                        aksi += `<button onclick="confirmJadikanAdmin('${user.id}','${user.name}')" class="btn btn-sm btn-info">Jadikan Admin</button>`;
                    } else if (user.role === 'admin') {
                        aksi += `<button onclick="confirmJadikanAdmin('${user.id}','${user.name}')" class="btn btn-sm btn-primary">Jadikan Member</button>`;
                    }
                }

                tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td><span class="badge bg-${badgeClass}">${user.role}</span></td>
                    <td>${aksi}</td>
                </tr>
            `;
            });

        } catch (err) {
            console.error('Gagal fetch data:', err);
            tbody.innerHTML = `<tr><td colspan="5" class="text-danger text-center">Gagal mengambil data</td></tr>`;
        }
    }
</script>

<?= $this->endSection() ?>