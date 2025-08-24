<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= base_url() ?>/">
    <title><?= $title . " - Akuatik Indonesia" ?? 'Member Area' ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/assets/images/logo-polo.png" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            /* Isi ruang di antara header dan footer */
        }

        /* Header Background Image */
        .header-bg {
            background-image: url('https://akuatikindonesia.id/images/menu-background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 80px;
            display: flex;
            align-items: center;
            padding-left: 20px;
        }

        .navbar-brand img {
            height: 60px;
        }

        /* Navbar Styling */
        .navbar-custom {
            background-color: #c62828;
        }

        .navbar-custom .nav-link {
            color: #fff !important;
            position: relative;
            padding-bottom: 5px;
            transition: color 0.3s ease;
        }

        .navbar-custom .nav-link::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #ffffff;
            transition: width 0.3s ease-in-out;
        }

        .navbar-custom .nav-link:hover {
            color: #ffe082 !important;
        }

        .navbar-custom .nav-link:hover::after {
            width: 100%;
        }

        /* Hamburger Menu */
        .navbar-toggler {
            border: none;
            background: transparent;
            padding: 0;
        }

        .hamburger {
            width: 24px;
            height: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hamburger span {
            display: block;
            height: 3px;
            width: 100%;
            background-color: white;
            border-radius: 2px;
            transition: 0.3s;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .team-item {
            width: 120px;
            height: 200px;
            margin: 15px;
            text-align: center;
            background: #f0f0f0;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            clip-path: polygon(0 0, 100% 0, 100% 90%, 50% 100%, 0 90%);
            position: relative;
            overflow: hidden;
        }

        .role-overlay {
            position: absolute;
            top: -20px;
            /* semakin negatif, semakin tinggi */
            left: 0;
            right: 0;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            background-color: rgba(123, 0, 0, 1);
            padding: 3px 5px;
            text-align: center;
            z-index: 10;
            border-radius: 5px;
        }

        .team-wrapper {
            position: relative;
            display: inline-block;
            /* biar lebarnya mengikuti isi */
            margin: 15px;
        }

        .team-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-header {
            background-color: #7b0000;
            color: #fff;
            font-size: 13px;
            font-weight: bold;
            padding: 5px 0;
        }

        .team-logo {
            padding: 20px 10px;
            height: 140px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .team-logo img {
            max-height: 100px;
            max-width: 100%;
        }

        .team-item.special {
            background: linear-gradient(to bottom,
                    oklch(20% 0.1 270),
                    /* setara biru tua */
                    oklch(65% 0.25 25)
                    /* setara merah terang */
                );
            color: white;
        }

        .team-item.special .team-header {
            background-color: rgba(0, 0, 0, 0.6);
            height: 100px;
        }

        .team-item.special .team-logo {
            background-image: url('https://images.unsplash.com/photo-1584467735871-d71f10d5d01f?auto=format&fit=crop&w=400&h=300&q=80');
            background-size: cover;
        }
    </style>
</head>

<body>

    <!-- Header with Logo -->
    <div class="header-bg">
        <a class="navbar-brand" href="#">
            <img src="<?= base_url() ?>/assets/images/logo-polo.png" alt="Akuatik Indonesia Logo">
        </a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Daftar</a></li>
                    <li class="nav-item ms-3">
                        <input type="text" name="cari" id="searchInput" class="form-control bg-white" placeholder="Cari team..." aria-label="Search" oninput="cariTeam()">
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container py-4">
            <div class="d-flex flex-wrap justify-content-center">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <p class="mb-1">© <?= date('Y') ?> Akuatik Indonesia. All rights reserved.</p>
            <div class="mb-2">
                <a href="https://instagram.com/akuatikindonesia" target="_blank" class="text-white me-3">
                    <i class="bi bi-instagram fs-4"></i>
                </a>
                <a href="https://facebook.com/akuatikindonesia" target="_blank" class="text-white me-3">
                    <i class="bi bi-facebook fs-4"></i>
                </a>
                <a href="https://youtube.com/@akuatikindonesia" target="_blank" class="text-white">
                    <i class="bi bi-youtube fs-4"></i>
                </a>
            </div>
            <small>
                Dibangun dengan <span style="color: #c62828;">❤️</span> oleh Tim Developer Akuatik
            </small>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                text: '<?= session()->getFlashdata('success') ?>',
            });
        </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
            });
        </script>
    <?php endif; ?>

    <!-- Script untuk pencarian -->
    <script>
        let shownAlertOnce = false;

        function cariTeam() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const teamItems = document.querySelectorAll('.team-item');
            const noResults = document.getElementById('noResults');
            if (!input || !teamItems.length) {
                if (!shownAlertOnce) {
                    alert("Pencarian hanya bisa dilakukan di halaman utama.");
                    shownAlertOnce = true; // agar tidak ditampilkan lagi
                }
                return;
            }

            let visibleCount = 0;

            teamItems.forEach(item => {
                const teamName = item.getAttribute('data-name');
                if (teamName.includes(input)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    </script>

</body>

</html>