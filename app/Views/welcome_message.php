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