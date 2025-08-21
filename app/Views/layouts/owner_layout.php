<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= base_url() ?>/">
    <title>Owner Area</title>
    <link rel="shortcut icon" type="image/png" href="/assets/images/logo-aquatic.png" />
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
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar top">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/owner/dashboard" class="text-nowrap logo-img">
                        <img src="../assets/images/logo-aquatic.png" width="50" alt="" />
                        <span class="logo-name text-truncate"> Dashboard owner</span>
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
                            <a class="sidebar-link" href="/owner/dashboard" aria-expanded="false">
                                <i class="ti ti-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/owner/team/edit/<?= esc($team['id']) ?>" aria-expanded="false">
                                <i class="ti ti-atom"></i>
                                <span class="hide-menu">Edit Team</span>
                            </a>
                        </li>

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
                            <a href="javascript:void(0)" class="sidebar-link" aria-expanded="false" onclick="changePassword(<?= session('id') ?>)">
                                <i class="ti ti-lock"></i>
                                <span class="hide-menu">Ubah Password</span>
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
        function changePassword(userId) {
            Swal.fire({
                title: 'Ganti Password',
                html: `
                <div class="swal2-input-group" style="position:relative">
                    <input id="old-password" type="password" class="swal2-input" placeholder="Masukkan password lama">
                    <i id="toggle-old" class="ti ti-eye" 
                    style="position:absolute; right:15px; top:18px; cursor:pointer;"></i>
                </div>
                <div class="swal2-input-group" style="position:relative">
                    <input id="new-password" type="password" class="swal2-input" placeholder="Masukkan password baru">
                    <i id="toggle-new" class="ti ti-eye" 
                    style="position:absolute; right:15px; top:18px; cursor:pointer;"></i>
                </div>
                <div class="swal2-input-group" style="position:relative">
                    <input id="confirm-password" type="password" class="swal2-input" placeholder="Konfirmasi password baru">
                    <i id="toggle-confirm" class="ti ti-eye" 
                    style="position:absolute; right:15px; top:18px; cursor:pointer;"></i>
                </div>
            `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                didOpen: () => {
                    const togglePassword = (inputId, toggleId) => {
                        const input = document.getElementById(inputId);
                        const toggle = document.getElementById(toggleId);

                        toggle.addEventListener('click', () => {
                            if (input.type === "password") {
                                input.type = "text";
                                toggle.classList.remove("ti-eye");
                                toggle.classList.add("ti-eye-off");
                            } else {
                                input.type = "password";
                                toggle.classList.remove("ti-eye-off");
                                toggle.classList.add("ti-eye");
                            }
                        });
                    };

                    togglePassword("old-password", "toggle-old");
                    togglePassword("new-password", "toggle-new");
                    togglePassword("confirm-password", "toggle-confirm");
                },
                preConfirm: () => {
                    const oldPassword = document.getElementById('old-password').value;
                    const newPassword = document.getElementById('new-password').value;
                    const confirmPassword = document.getElementById('confirm-password').value;

                    if (!oldPassword || !newPassword || !confirmPassword) {
                        Swal.showValidationMessage('Semua field wajib diisi');
                        return false;
                    }

                    if (newPassword !== confirmPassword) {
                        Swal.showValidationMessage('Konfirmasi password tidak cocok');
                        return false;
                    }

                    return {
                        oldPassword,
                        newPassword
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch(`/admin/users/changePassword/${userId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                old_password: result.value.oldPassword,
                                new_password: result.value.newPassword
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Password berhasil diganti',
                                    icon: 'success'
                                }).then(() => {
                                    // Refresh setelah sukses
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(err => {
                            Swal.fire('Error', 'Terjadi kesalahan saat menghubungi server.', 'error');
                        });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Refresh jika user klik Batal
                    window.location.reload();
                }
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

        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Tindakan ini tidak bisa dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + id).submit();
                }
            });
        }

        function previewPhoto(event) {
            const input = event.target;
            const preview = document.getElementById('photo-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>