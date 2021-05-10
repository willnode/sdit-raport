<!DOCTYPE html>
<html lang="en">

<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('shared/panel_navbar') ?>
    <div class="content-wrapper p-4">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <?php /** @var \App\Entities\Nilai[] $data */ ?>
            <div class="d-flex">
              <h1>Data Nilai <?= get_kelas_pelajaran_nice_name($kelas_pelajaran) ?></h1>
              <div class="ml-auto">
                <?= view('shared/button', [
                  'actions' => ['import', 'export'],
                  'target' => $kelas_pelajaran,
                  'size' => 'btn-lg'
                ]); ?>
              </div>
            </div>
            <?= view('shared/table', [
              'data' => $data,
              'columns' => [
                'NIS' => function (\App\Entities\Nilai $x) {
                  return $x->nis;
                },
                'Nama' => function (\App\Entities\Nilai $x) {
                  return $x->nama_siswa;
                },
                'Nilai' => function (\App\Entities\Nilai $x) {
                  return $x->nilai;
                },
              ]
            ]) ?>
            <?= view('shared/pagination') ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>