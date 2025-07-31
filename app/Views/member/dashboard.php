<?= $this->extend('layouts/layout_member') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Dashboard Member</h1>

<div class="row">
    <!-- Profil -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Profil Saya</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nama:</strong> <?= esc($user['name']) ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?= esc($user['email']) ?></li>
                    <li class="list-group-item">
                        <strong>Jenis Kelamin:</strong>
                        <?= !empty($biodata['gender']) ? esc($biodata['gender']) : ' - ' ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Tempat, tanggal lahir:</strong>
                        <?php
                        $tempat = !empty($biodata['birth_place']) ? esc($biodata['birth_place']) : ' - ';
                        $tanggal = !empty($biodata['birth_date']) ? date('d F Y', strtotime($biodata['birth_date'])) : ' - ';
                        ?>
                        <?= $tempat . ', ' . $tanggal ?>
                    </li>
                    <a href="/member/profile" class="btn btn-sm btn-success mt-3">Edit Profile</a>
            </div>
        </div>
    </div>

    <!-- Informasi Tim -->
    <div class="col-md-6">
        <?php if ($team): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Tim Saya: <?= esc($team['name']) ?></h5>
                    <p><?= esc($team['description']) ?></p>
                    <?php if (!empty($team['owner_name'])): ?>
                        <p><strong>Owner:</strong> <?= esc($team['owner_name']) ?> (<?= esc($team['owner_email']) ?>)</p>
                    <?php else: ?>
                        <p><strong>Owner:</strong> <span class="text-muted">Belum memiliki owner</span></p>
                    <?php endif; ?>
                    <p><strong>Total Anggota:</strong> <?= count($members) ?></p>
                    <button type="button" class="btn btn-danger btn-sm mt-2" onclick="confirmLeave()">Keluar dari Tim</button>
                </div>
            </div>

            <h5>Anggota Tim</h5>
            <ul class="list-group">
                <?php foreach ($members as $member): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <?= esc($member['name']) ?> (<?= esc($member['email']) ?>)
                        </div>
                        <span class="badge bg-secondary"><?= esc($member['role']) ?></span>
                    </li>
                <?php endforeach ?>
                <?php if (empty($members)): ?>
                    <li class="list-group-item text-muted">Belum ada anggota.</li>
                <?php endif ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-warning">Anda belum tergabung dalam tim manapun.</div>
        <?php endif; ?>
    </div>
</div>

<!-- Undangan Tim -->
<?php if (!empty($pendingInvites)): ?>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="card-title">Undangan Tim</h5>
            <ul class="list-group">
                <?php foreach ($pendingInvites as $invite): ?>
                    <?php $teamInfo = $teamModel->find($invite['team_id']); ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= esc($teamInfo['name']) ?></strong> — <?= esc($teamInfo['description']) ?>
                        </div>
                        <div>
                            <button type="button" class="btn btn-success btn-sm" onclick="confirmAccept('<?= $invite['id'] ?>')">Setujui</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmReject('<?= $invite['id'] ?>')">Tolak</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>