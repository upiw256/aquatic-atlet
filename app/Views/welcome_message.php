<?= $this->extend('layouts/home_layout') ?>
<?= $this->section('content') ?>
<h1 class="text-center w-100 mb-4">Tim Polo Air Indonesia</h1>
<?php if ($teams !== null): ?>
    <?php foreach ($teams as $team): ?>
        <a href="<?= base_url('team-detail/' . $team['id']) ?>" class="text-decoration-none">
            <div class="team-item" data-name="<?= strtolower(esc($team['name'])) ?>">
                <div class="team-header"><?= esc($team['name']) ?></div>
                <div class="team-logo">
                    <img src="<?= base_url('uploads/logo/' . $team['logo']) ?>" alt="<?= esc($team['name']) ?>">
                </div>
            </div>
        </a>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center text-muted">Tidak ada tim yang tersedia.</p>
<?php endif; ?>

<!-- Pesan jika tidak ada hasil -->
<div id="noResults" class="text-center text-muted w-100" style="display: none;">
    <p><strong>Tim tidak ditemukan.</strong></p>
</div>
<?= $this->endSection() ?>