<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('shared/navbar') ?>
    <div class="container p-4 text-navy">
      <div class="card my-3">
        <div class="row gutter-0">
          <div class="col-lg-4 p-4 d-flex flex-column justify-content-center">
            <h2>Raport Prodistik</h2>
            <p>Pangkalan Data Raport SDIT Ar-Ruhul Jadid</p>
            <div><a href="/cek/" class="btn mb-3 bg-gradient-navy">Cek Nilai Siswa</a></div>
            <div><a href="/login/" class="btn mb-3 bg-gradient-navy">Masuk (Guru)</a></div>
          </div>
          <div class="col-lg-8 d-none d-lg-block">
            <div style="background: url(https://images.unsplash.com/photo-1591686224641-2e07b13c0b51?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1834&q=80) center/cover;
        min-height: 400px;"></div>
          </div>
        </div>
      </div>
      <div class="row">
      </div>
    </div>
  </div>
</body>

</html>