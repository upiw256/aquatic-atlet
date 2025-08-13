<?php
$birthDate = new DateTime($biodata[0]['birth_date']);
$today     = new DateTime('today');
$age       = $birthDate->diff($today)->y;
?>

<table class="header-table">
    <tr>
        <td class="logo-cell">
            <img src="file://<?= FCPATH ?>assets/images/logo-aquatic.png" alt="Logo" class="logo">
        </td>
        <td class="title-cell">
            <h2>LAPORAN DATA ATLET POLO AIR</h2>
            <div class="sub-title">Tingkat Nasional - <?= date('Y') ?></div>
        </td>
    </tr>
</table>
<!-- Biodata -->
<table class="biodata">
    <tr>
        <td class="label">Nama Lengkap</td>
        <td><?= esc($biodata[0]['user_name']) ?></td>
        <td rowspan="10" class="photo">
            <img src="file://<?= FCPATH . $biodata[0]['photo'] ?>" alt="Foto Atlet" class="thumbnail">
        </td>
    </tr>
    <tr>
        <td class="label">NIK</td>
        <td><?= esc($biodata[0]['nik']) ?></td>
    </tr>
    <tr>
        <td class="label">Jenis Kelamin</td>
        <td><?= esc($biodata[0]['gender']) ?></td>
    </tr>
    <tr>
        <td class="label">Tempat, Tgl Lahir</td>
        <td><?= esc($biodata[0]['birth_place']) ?>, <?= date('d M Y', strtotime($biodata[0]['birth_date'])) ?></td>
    </tr>
    <tr>
        <td class="label">Usia</td>
        <td><?= $age ?> tahun</td>
    </tr>
    <tr>
        <td class="label">Agama</td>
        <td><?= esc($biodata[0]['religion']) ?></td>
    </tr>
    <tr>
        <td class="label">Status Perkawinan</td>
        <td><?= esc($biodata[0]['marital_status']) ?></td>
    </tr>
    <tr>
        <td class="label">Pendidikan</td>
        <td><?= esc($biodata[0]['education']) ?></td>
    </tr>
    <tr>
        <td class="label">Pekerjaan</td>
        <td><?= esc($biodata[0]['occupation']) ?></td>
    </tr>
    <tr>
        <td class="label">Alamat</td>
        <td><?= esc($biodata[0]['address']) ?></td>
    </tr>
    <tr>
        <td class="label">No. HP</td>
        <td><?= esc($biodata[0]['phone']) ?></td>
    </tr>
    <tr>
        <td class="label">Team</td>
        <td><?= esc($dataTeam['name']) ?></td>
    </tr>
    <tr>
        <td class="label">Manager</td>
        <td><?= esc($dataTeam['owner_name']) ?></td>
    </tr>
    <tr>
        <td class="label">Posisi</td>
        <td><?= esc($dataTeam['role']) ?></td>
    </tr>
</table>

<!-- Riwayat Kejuaraan -->
<h3>Riwayat Kejuaraan</h3>
<table class="achievements">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kejuaraan</th>
            <th>Lokasi</th>
            <th>Tingkat</th>
            <th>Tahun</th>
            <th>Posisi Akhir</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($achievements)): ?>
            <?php foreach ($achievements as $i => $a): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($a['nama_kejuaraan']) ?></td>
                    <td><?= esc($a['lokasi']) ?></td>
                    <td><?= esc($a['tingkat']) ?></td>
                    <td><?= esc($a['tahun']) ?></td>
                    <td><?= esc($a['posisi_akhir']) ?></td>
                    <td><?= esc($a['skor']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada data kejuaraan.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Catatan -->
<div class="note">
    * Atlet aktif dalam 3 musim kejuaraan terakhir.<br>
    * Tidak ada catatan pelanggaran atau cedera besar.
</div>
