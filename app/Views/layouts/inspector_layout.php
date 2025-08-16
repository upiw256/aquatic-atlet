<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= base_url() ?>/">
    <title><?= $title ?? 'Inspector Area' ?></title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->

    <!-- Scripts -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/logo-aquatic.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js "></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    </link>
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
    </link>
    <link href="https://cdn.datatables.net/responsive/3.0.5/css/responsive.dataTables.css">
    </link>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar top">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/member/dashboard" class="text-nowrap logo-img">
                        <img src="../assets/images/logo-aquatic.png" width="50" alt="" />
                        <span class="logo-name text-truncate"> Dashboard Pengawas</span>
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-6"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/inspector/dashboard" aria-expanded="false">
                                <i class="ti ti-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/<?= session('role') ?>/members" aria-expanded="false">
                                <i class="ti ti-user"></i>
                                <span class="hide-menu">Members</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/inspector/teams" aria-expanded="false">
                                <i class="ti ti-atom"></i>
                                <span class="hide-menu">Team</span>
                            </a>
                        <!-- </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/inspector/achivements" aria-expanded="false">
                                <i class="ti ti-trophy"></i>
                                <span class="hide-menu">Penghargaan</span>
                            </a>
                        </li> -->

                    </ul>
                    <ul class="sidebar-nav mt-4">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Settings</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/member/profile" aria-expanded="false">
                                <i class="ti ti-ad-2"></i>
                                <span class="hide-menu">Biodata</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/logout" aria-expanded="false">
                                <i class="ti ti-logout"></i>
                                <span class="hide-menu">Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        </aside>
        <div class="body-wrapper">
            <header class="app-header top">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="<?= esc($biodata['photo'] ?? '../assets/images/profile/user-1.jpg') ?>" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="/member/profile" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Team</p>
                                        </a>
                                        <a href="/logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/responsive.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/dataTables.responsive.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script>
        function assignOwner(teamId) {
            Swal.fire({
                title: 'Yakin ingin mengatur member ini sebagai Owner?',
                text: "Tindakan ini akan menetapkan pemilik tim!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, tetapkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke URL handler assign owner tanpa form
                    window.location.href = '/admin/assign-owner/' + teamId + '?confirm=true';
                }
            });
        }

        function toggleDarkMode() {
            Swal.fire({
                title: 'Mode Gelap Aktif',
                text: 'Saat ini kamu sudah berada dalam mode gelap.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }

        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error') ?>'
            });
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('warning') ?>'
            });
        <?php endif; ?>
    </script>
    <script>
        function resetPassword(userId) {
            Swal.fire({
                title: 'Reset Password?',
                text: "Password akan diganti secara acak.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/reset/${userId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    html: `Password baru: <strong>${data.new_password}</strong>`,
                                    icon: 'success'
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(err => {
                            Swal.fire('Error', 'Terjadi kesalahan saat menghubungi server.', 'error');
                        });
                }
            });
        }
        new DataTable('#team', {
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate
                }
            }
        });
        new DataTable('#userTable', {
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate
                }
            }
        });
    </script>
</body>

</html>