<?= $this->extend('layouts/login_layout') ?>
<?= $this->section('content') ?>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
  data-sidebar-position="fixed" data-header-position="fixed">
  <div
    class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card mb-0">
            <div class="card-body">
              <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                <img src="../assets/images/logo-aquatic.png" width="180" alt="">
              </a>
              <p class="text-center">Pendataan atlet Polo Air Indonesia</p>
              <form action="<?= site_url('/register') ?>" method="post">
                <?= csrf_field() ?>
                <!-- Flash message -->
                <?php if (session()->getFlashdata('errors')): ?>
                  <div class="alert alert-danger">
                    <ul class="mb-0">
                      <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                <?php endif ?>
                <?php if (session()->getFlashdata('success')): ?>
                  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif ?>
                <div class="mb-3">
                  <label for="exampleInputtext1" class="form-label">Nama Lengkap</label>
                  <input type="text" name="name" class="form-control" id="exampleInputtext1" aria-describedby="textHelp">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Alamat Email</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-4">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-4">
                  <label for="exampleInputPassword1" class="form-label">komfirmasi Password</label>
                  <input type="password" name="confirm" class="form-control" id="exampleInputPassword1">
                </div>
                <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" type="submit">Daftar Sekarang</button>
                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                  <a class="text-primary fw-bold ms-2" href="/login">Sign In</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '<?= session()->getFlashdata('success') ?>',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = '/login';
    });
  </script>
<?php endif ?>

<?= $this->endSection() ?>