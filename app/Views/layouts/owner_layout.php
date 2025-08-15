<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <base href="<?= base_url() ?>/">
    <link rel="shortcut icon" type="image/png" href="../assets/images/logo-aquatic.png" />
    <title><?= isset($title) ? esc($title) : 'Owner Panel' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js "></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
        <a class="navbar-brand" href="/owner/dashboard">Owner Panel</a>
        <div class="ms-auto">
            <a href="/owner/profile" class="text-white me-3 text-decoration-none">
                Hai, <?= esc(session('name')) ?>
            </a>
            <a href="/logout" class="btn btn-outline-light btn-sm">Logout</a>
        </div>

    </nav>

    <div class="container mt-4">
        <h1 class="mb-4"><?= $title ?? 'Dashboard Owner' ?></h1>

        <?= $this->renderSection('content') ?>
    </div>

    <script>
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