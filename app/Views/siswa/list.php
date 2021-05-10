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
            <?= view('shared/rows') ?>
            <?php /** @var \App\Entities\User[] $data */ ?>
            <div class="d-flex">
            <h1>Data Siswa</h1>
              <div class="ml-auto">
                <?= view('shared/button', [
                  'actions' => \Config\Services::login()->role === 'admin' ? ['import', 'export'] : [],
                  'target' => '',
                  'size' => 'btn-lg'
                ]); ?>
              </div>
            </div>
            <?= view('shared/table', [
              'data' => $data,
              'columns' => [
                'Kelas' => function (\App\Entities\Siswa $x) {
                  return $x->kelasFull;
                },
                'Jumlah' => function (\App\Entities\Siswa $x) {
                  return $x->jumlah;
                },
                'Action' => function (\App\Entities\Siswa $x) {
                  return view('shared/button', [
                    'actions' => ['detail', 'export'],
                    'target' => $x->angkatan . ',' . $x->kelas,
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