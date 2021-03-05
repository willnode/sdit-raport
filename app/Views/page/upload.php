<!DOCTYPE html>
<html lang="en">

<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('shared/panel_navbar') ?>
    <div class="content-wrapper p-4">
      <div class="container" style="max-width: 540px;">
        <div class="card">
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <h1 class="mb-3">Upload Data <?= ucfirst($page) ?></h1>
              <input type="file" class="form-control mb-3 h-auto" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
              <div class="alert alert-default-info">
                <ul class="pl-3 mb-0">
                  <li>Harus berformat Excel 2007 keatas (XLSX).</li>
                  <li>Hanya sheet pertama yang akan diproses.</li>
                  <li>Baris pertama tidak akan diproses.</li>
                  <li>Untuk format Excel yang dipakai mohon gunakan format sesuai file download pada data yang ingin diedit.</li>
                  <li>Data yang diedit mengacu pada kode matkul / NIS di tiap baris data excel. Untuk input nilai, perubahan pada nama matkul/siswa dalam Excel tidak akan merubah data.</li>
                  <li>Tidak ada penghapusan data apabila ada input data yang kurang dalam excel, sehingga tidak masalah apabila hanya mengupload sebagian data saja.</li>
                </ul>
              </div>
              <div class="d-flex mb-3">
                <input type="submit" value="Upload" class="btn btn-primary">
                <a class="ml-auto btn btn-outline-secondary" href="..">Kembali</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>