<?= $this->extend('components/layout_clear') ?>
<?= $this->section('content') ?>

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        <div class="d-flex justify-content-center py-4">
          <a href="<?= base_url('/') ?>" class="logo d-flex align-items-center w-auto">
            <img src="<?= base_url() ?>NiceAdmin/assets/img/logo_blangkon.jpg" alt="" style="height: 40px;">
            <span class="ms-2 fw-bold fs-4">Blangkis Store</span>
          </a>
        </div><!-- End Logo -->

        <div class="card mb-3 w-100">

          <div class="card-body">

            <div class="pt-3 pb-2">
              <h5 class="card-title text-center pb-0 fs-4">Buat Akun Baru</h5>
              <p class="text-center small">Masukkan data dengan benar untuk membuat akun</p>
            </div>

            <?php if (session()->getFlashdata('failed')): ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('failed') ?></div>
            <?php endif; ?>

            <form class="row g-3 needs-validation" action="<?= base_url('register') ?>" method="post" novalidate>
              <?= csrf_field() ?>

              <div class="col-12">
                <label for="username" class="form-label">Username</label>
                <div class="input-group has-validation">
                  <span class="input-group-text" id="inputGroupPrepend">@</span>
                  <input type="text" name="username" class="form-control" id="username" required value="<?= old('username') ?>">
                </div>
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required value="<?= old('email') ?>">
              </div>

              <div class="col-12">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
              </div>

              <div class="col-12">
                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirm" class="form-control" id="password_confirm" required>
              </div>

              <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Daftar</button>
              </div>

              <div class="col-12 text-center">
                <p class="small mb-0">Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></p>
              </div>
            </form>

          </div>
        </div>

        <div class="credits">
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>

      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
