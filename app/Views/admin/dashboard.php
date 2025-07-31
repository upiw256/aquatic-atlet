<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Dashboard Admin</h1>
<div class="row g-3">
    <div class="col-md-6">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Jumlah Member</h5>
                <h3><?= esc($memberCount ?? 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Jumlah Tim</h5>
                <h3><?= esc($teamCount ?? 0) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Statistik Pengguna</h5>
                <canvas id="statsChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Member', 'Tim'],
            datasets: [{
                label: 'Jumlah',
                data: [<?= esc($memberCount ?? 0) ?>, <?= esc($teamCount ?? 0) ?>],
                backgroundColor: ['#0d6efd', '#198754']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>


<?= $this->endSection() ?>
