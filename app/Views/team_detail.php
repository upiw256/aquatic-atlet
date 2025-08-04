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
                    <p><strong>Jumlah Anggota:</strong> <?= count($team['members']) ?></p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Logo Tim -->
        <div class="col-md-4 d-flex justify-content-center">
            <img src="<?= base_url('uploads/logo/' . $team['logo']) ?>" alt="<?= esc($team['name']) ?>"
                class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
        </div>
    </div>

    <!-- Anggota Tim -->
    <div class="text-center mt-5">
        <h2 class="mb-3">Anggota Tim</h2>
        <?php if (!empty($team['members'])): ?>
                <?php foreach ($team['members'] as $member): ?>
                    <?php if($member['status'] == 'accepted'): ?>
                    <div class="team-item special" data-name="<?= strtolower(esc($team['name'])) ?>">
                        <div class="d-flex flex-column align-items-center pt-3 ">
                            <h1 class="fw-bold text-light text-uppercase"><?= esc($member['role']) ?></h1>
                        </div>
                        <div class="team-header"><?= esc($member['name']) ?></div>
                        <div class="">
                            <img src="<?= base_url($member['photo']) ?>" class="w-100 h-100 object-fit-cover" alt="<?= esc($team['name']) ?>">
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted"><em>Belum ada anggota terdaftar.</em></p>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>
