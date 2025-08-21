<table class="header-table">
    <tr>
        <td class="logo-cell">
            <img src="file://<?= FCPATH ?>assets/images/logo-polo.png" alt="Logo" class="logo">
        </td>
        <td class="title-cell">
            <h2>LAPORAN DATA TEAM POLO AIR</h2>
            <div class="sub-title">Tingkat Provinsi - <?= date('Y') ?></div>
        </td>
        <td class="logo-cell">
            <img src="file://<?= FCPATH ?>assets/images/logo-aquatic.png" alt="Logo" class="logo">
        </td>
    </tr>
</table>

<table class="biodata">
    <tr>
        <td class="label">Nama Team</td>
        <td><?= esc($team['name']) ?></td>
        <td rowspan="10" class="photo">
            <img src="file://<?= FCPATH . '/uploads/logo/' . $team['logo'] ?>" alt="Foto Atlet" class="thumbnail">
        </td>
    </tr>
    <tr>
        <td class="label">Nama Owner</td>
        <td><?= esc($team['owner_name']) ?></td>
    </tr>
    <tr>
        <td class="label">Tentang Team</td>
        <td><?= esc($team['description']) ?></td>
    </tr>
</table>

<h3>Anggota Team</h3>
<table class="achievements">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Posisi</th>
            <th>Foto</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($DataMembers)): ?>
            <?php foreach ($DataMembers as $index => $DataMember): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($DataMember['name']) ?></td>
                    <td><?= esc($DataMember['email']) ?></td>
                    <td><?= esc($DataMember['role']) ?></td>
                    <td><img src="file://<?= FCPATH . $DataMember['photo'] ?>" alt="Foto Atlet" style="max-width: 50px;"></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada anggota dalam team ini.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>