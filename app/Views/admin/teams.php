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
            <?php $i = 0;
            foreach ($teams as $team): ?>
                <tr>
                    <td><?= ++$i ?></td>
                    <td><?= esc($team['name']) ?></td>
                    <td><?= esc($team['owner_name'] ?? '-') ?></td>
                    <td><?= esc($team['member_count']) ?></td>
                    <td>
                        <button
                            onclick="showMembers('<?= $team['id'] ?>')"
                            class="btn btn-sm btn-info">
                            Lihat
                        </button>
                        <a href="/admin/teams/edit/<?= $team['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="/admin/teams/<?= $team['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus tim ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>
    const membersData = <?= json_encode($teams) ?>;

    function showMembers(teamId) {
        const team = membersData.find(t => t.id === teamId);
        if (!team) return;

        let tableHTML = `
        <div class="row">
            <div class="col-md-2 text-center">
            ${team.logo 
            ? `<img src="uploads/logo/${team.logo}" alt="Logo Tim" style="max-width: 120px;">`
            : 'Tidak ada logo'}
            </div>
            <div class="col-md-10">
                <p>${team.description || 'Tidak ada deskripsi'}</p>
            </div>
        </div>
        <table id="membersTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Atlit</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                ${team.members.map((m, i) => `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${m.name}</td>
                        <td>${m.email}</td>
                        <td>${m.role}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;

        Swal.fire({
            title: `Anggota Tim ${team.name}`,
            html: tableHTML,
            width: '800px',
            heightAuto: false,
            didOpen: () => {
                new DataTable('#membersTable'); // Inisialisasi DataTables setelah modal terbuka
            }
        });
    }
</script>
<?= $this->endSection() ?>