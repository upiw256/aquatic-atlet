<?= $this->extend('layouts/home_layout') ?>
<?= $this->section('content') ?>
<div class="container py-5">

    <!-- Judul -->
    <h1 class="mb-4"><?= esc($team['name']) ?></h1>

    <!-- Informasi Tim + Logo Tim -->
    <div class="row d-flex align-items-center justify-content-center mb-4">
        <!-- Kolom Kiri: Deskripsi -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informasi Tim</h5>
                    <?php if (!empty($team['description'])): ?>
                        <p><strong>Deskripsi:</strong><br><?= esc($team['description']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($team['owner']['name'])): ?>
                        <p><strong>Owner:</strong> <?= esc($team['owner']['name']) ?></p>
                    <?php endif; ?>
                    <p><strong>Jumlah Anggota:</strong> 
                    <?= 
                    $acceptedCount = count(array_filter($team["members"], function ($member) {
                        return $member["status"] === "accepted";
                        }));
                    ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Logo Tim -->
        <div class="col-md-4 d-flex justify-content-center">
            <img src="<?= base_url('uploads/logo/' . $team['logo']) ?>" alt="<?= esc($team['name']) ?>"
                class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
        </div>
    </div>
<!-- Anggota -->
<div class="text-center mt-5">
    <h2 class="mb-3">Anggota Tim</h2>
    <?php if (!empty($team['members'])): ?>
        <div class="d-flex flex-wrap justify-content-center">
            <?php foreach ($team['members'] as $member): ?>
                <?php if ($member['status'] == 'accepted'): ?>
                    <div class="team-wrapper">
                        <!-- Role di luar frame -->
                        <div class="role-overlay"><?= esc($member['role']) ?></div>

                        <!-- Frame -->
                        <div class="team-item special" data-name="<?= strtolower(esc($team['name'])) ?>">
                            <!-- Foto -->
                            <div class="team-photo-wrapper">
                                <?php if (!empty($member['photo'])): ?>
                                    <img src="<?= base_url($member['photo']) ?>" class="team-photo" alt="<?= esc($team['name']) ?>">
                                <?php else: ?>
                                    <img src="<?= base_url() ?>/uploads/photos/default.png" class="team-photo" alt="Default Photo">
                                <?php endif; ?>
                            </div>

                            <!-- Nama -->
                            <div class="team-header"><?= esc($member['name']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted"><em>Belum ada anggota terdaftar.</em></p>
    <?php endif; ?>
</div>





</div>
<?= $this->endSection() ?>
