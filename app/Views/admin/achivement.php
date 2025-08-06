<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Daftar Atlit dan Kejuaraan</h2>
    <div class="mb-3">
        <a href="<?= site_url('admin/achivement/create') ?>" class="btn btn-primary">Tambah Kejuaraan</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Atlit</th>
                <th>Team</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($achievements)): ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            <?php else: ?>
                <?php $i = 1;
                foreach ($achievements as $achievement): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($achievement['member_name']) ?></td>
                        <td><?= esc($achievement['team_name']) ?></td>
                        <td>
                            <button
                                onclick="showAchievements('<?= $achievement['team_member_id'] ?>')"
                                class="btn btn-sm btn-info">
                                Lihat
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
    const achievementsData = <?= json_encode($achievements) ?>;

function showAchievements(memberId) {
    const data = achievementsData[memberId];
    if (!data || !data.achievements || data.achievements.length === 0) {
        Swal.fire({
            icon: 'info',
            title: `${data?.member_name || 'Tidak diketahui'}`,
            text: 'Belum ada data kejuaraan.',
        });
        return;
    }

    let tableHTML = `
<table class="table table-bordered" style="width:100%; text-align:left">
<thead>
    <tr>
        <th>Nama Kejuaraan</th>
        <th>Lokasi</th>
        <th>Tingkat</th>
        <th>Tahun</th>
        <th>Posisi Akhir</th>
        <th>Skor</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>`;

    data.achievements.forEach(a => {
        tableHTML += `
<tr>
    <td>${a.nama_kejuaraan}</td>
    <td>${a.lokasi}</td>
    <td>${a.tingkat}</td>
    <td>${a.tahun}</td>
    <td>${a.posisi_akhir}</td>
    <td>${a.skor ?? '-'}</td>
    <td>
        <a href="<?= base_url() ?>admin/achivements/edit/${a.id}" class="btn btn-sm btn-warning">Edit</a>
        <a href="<?= base_url() ?>admin/achivements/delete/${a.id}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kejuaraan ini?');">Hapus</a>
    </td>
</tr>`;
    });

    tableHTML += `</tbody></table>`;

    Swal.fire({
        title: `${data.member_name}`,
        html: tableHTML,
        width: '90%',
        customClass: {
            popup: 'text-start'
        }
    });
}
</script>
<?= $this->endSection() ?>