<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= base_url() ?>/">
    <title><?= $title ?? 'Member Area' ?></title>
    <link rel="shortcut icon" type="image/png" href="/assets/images/logo-aquatic.png" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
            margin: 15px;
            text-align: center;
            background: #f0f0f0;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            clip-path: polygon(0 0, 100% 0, 100% 90%, 50% 100%, 0 90%);
        }

        .team-header {
            background-color: #7b0000;
            color: #fff;
            font-weight: bold;
            padding: 6px 0;
        }

        .team-logo {
            padding: 20px 10px;
            height: 140px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .team-logo img {
            max-height: 100px;
            max-width: 100%;
        }

        .team-item.special {
            background: linear-gradient(to bottom, #062a4d, #de1f26);
            color: white;
        }

        .team-item.special .team-header {
            background-color: rgba(0, 0, 0, 0.6);
        }

        .team-item.special .team-logo {
            background-image: url('https://esports.id/img/grid.png');
            background-size: cover;
        }
    </style>
</head>

<body>

    <!-- Header with Logo -->
    <div class="header-bg">
        <a class="navbar-brand" href="#">
            <img src="/assets/images/logo-aquatic.png" alt="Akuatik Indonesia Logo">
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="container py-4">
            <div class="d-flex flex-wrap justify-content-center">
                <h1 class="text-center w-100 mb-4">Tim Akuatik Indonesia</h1>
                <?php foreach ($teams as $team): ?>
                    <div class="team-item special">
                        <div class="team-header"><?= esc($team['name']) ?></div>
                        <div class="team-logo">
                            <img src="<?= base_url('uploads/logo/' . $team['logo']) ?>" alt="<?= esc($team['name']) ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/scripts.min.js"></script>

    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                text: '<?= session()->getFlashdata('success') ?>',
            });
        </script>
    <?php endif; ?>

</body>

</html>