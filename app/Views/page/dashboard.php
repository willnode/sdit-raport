<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('shared/panel_navbar') ?>
    <div class="content-wrapper p-4">
      <div class="container" style="max-width: 720px;">
        <div class="card">
          <div class="card-body text-center">
            <h1 class="mb-4">Selamat Datang di Portal Nilai Prodistik MAN 4 Jombang!</h1>
            <div class="btn-group btn-block">
              <a href="/user/nilai/" class="btn btn-outline-primary py-4">
                <i class="fas fa-2x fa-info"></i><br>
                Input Nilai
              </a>
              <?php if (\Config\Services::login()->role === 'admin') : ?>
                <a href="/user/siswa/" class="btn btn-outline-primary py-4">
                  <i class="fas fa-2x fa-info"></i><br>
                  Input Siswa
                </a>
                <a href="/user/matkul/" class="btn btn-outline-primary py-4">
                  <i class="fas fa-2x fa-info"></i><br>
                  Input Matkul
                </a>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>