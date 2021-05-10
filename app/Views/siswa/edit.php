<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('shared/panel_navbar') ?>
    <?php /** @var \App\Entities\Siswa $item */ ?>
    <div class="content-wrapper p-4">
      <div class="container" style="max-width: 540px;">
        <div class="card">
          <div class="card-body">
            <form enctype="multipart/form-data" method="post">
              <div class="d-flex mb-3">
                <h1 class="h3 mb-0 mr-auto">Edit Siswa</h1>
                <a href="/user/siswa/?detail=<?= $item->angkatan ?>,<?= $item->kelas ?>" class="btn btn-outline-secondary ml-2">Kembali</a>
              </div>
              <label class="d-block mb-3">
                <span>NIS</span>
                <input type="text" class="form-control" name="nis" value="<?= esc($item->nis) ?>" disabled>
              </label>
              <label class="d-block mb-3">
                <span>NISN</span>
                <input type="text" class="form-control" name="nisn" value="<?= esc($item->nisn) ?>">
              </label>
              <label class="d-block mb-3">
                <span>Kelas</span>
                <input type="text" class="form-control" name="kelas" value="<?= esc($item->kelas) ?>">
              </label>
              <label class="d-block mb-3">
                <span>Tahun Masuk</span>
                <input type="text" class="form-control" name="angkatan" value="<?= esc($item->angkatan) ?>">
              </label>
              <label class="d-block mb-3">
                <span>Tugas Akhir</span>
                <input type="text" class="form-control" name="tugas_akhir" value="<?= esc($item->tugas_akhir) ?>">
              </label>
              <label class="d-block mb-3">
                <span>Password</span>
                <input type="password" class="form-control" name="password" placeholder="Masukkan apabila ingin mengganti password">
              </label>
              <div class="d-flex mb-3">
                <input type="submit" value="Save" class="btn btn-primary mr-auto">
                <?php if ($item->nis) : ?>
                  <label for="delete-form" class="btn btn-danger mb-0"><i class="fa fa-trash"></i></label>
                <?php endif ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="/user/manage/delete/<?= $item->nis ?>">
    <input type="submit" hidden id="delete-form" onclick="return confirm('Hapus siswa?')">
  </form>
</body>

</html>