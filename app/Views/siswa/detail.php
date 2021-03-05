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
            <?php /** @var \App\Entities\User[] $data */ ?>
            <div class="d-flex">
              <h1>Data Siswa <?= get_kelas_nice_name($kelas) ?></h1>
              <div class="ml-auto">
                <?= view('shared/button', [
                  'actions' => \Config\Services::login()->role === 'admin' ? ['import', 'export'] : [],
                  'target' => $kelas,
                  'size' => 'btn-lg'
                ]); ?>
              </div>
            </div>
            <?= view('shared/table', [
              'data' => $data,
              'columns' => [
                'NIS' => function (\App\Entities\Siswa $x) {
                  return $x->nis;
                },
                'Nama' => function (\App\Entities\Siswa $x) {
                  return $x->nama;
                },
                'Kelas' => function (\App\Entities\Siswa $x) {
                  return $x->kelasFull;
                },
                'Thn Masuk' => function (\App\Entities\Siswa $x) {
                  return $x->thn_masuk;
                },
                'Action' => function (\App\Entities\Siswa $x) {
                  return view('shared/button', [
                    'actions' => ['print', \Config\Services::login()->role === 'admin' ? 'edit' : ''],
                    'target' => $x->nis,
                    'size' => 'btn-sm'
                  ]);
                }
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