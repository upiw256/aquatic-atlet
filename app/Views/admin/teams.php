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
            <?php $i = 0; foreach ($teams as $team): ?>
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
        const data = membersData.find(team => team.id == teamId);

        if (!data || !data.members || data.members.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak ada anggota tim',
                text: 'Tim ini belum memiliki anggota.',
            });
            return;
        }

        let tableHTML = `
            <div class="table-responsive">
                <table class="table table-bordered table-striped display nowrap" id="membersTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama Atlit</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>`;

        data.members.forEach((member, index) => {
            tableHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${member.name}</td>
                    <td>${member.email}</td>
                    <td>${member.role}</td>
                </tr>`;
        });

        tableHTML += `
                    </tbody>
                </table>
            </div>`;

        Swal.fire({
            title: `Anggota Tim ${data.name}`,
            html: `<div style="max-height:400px; overflow-y:auto;">${tableHTML}</div>`,
            width: '800px',
            showCloseButton: true,
            focusConfirm: false,
            confirmButtonText: 'Tutup',
        });

        $('#membersTable').DataTable({
            responsive: true,
            autoWidth: false,
        });
    }
</script>
<?= $this->endSection() ?>
