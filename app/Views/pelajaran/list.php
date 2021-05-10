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
            <?php /** @var \App\Entities\Pelajaran[] $data */ ?>
            <div class="d-flex">
              <h1>Data Pelajaran</h1>
              <div class="ml-auto">
                <?= view('shared/button', [
                  'actions' => ['import', 'export'],
                  'target' => '',
                  'size' => 'btn-lg'
                ]); ?>
              </div>
            </div>
            <?= view('shared/table', [
              'data' => $data,
              'columns' => [
                'Kode' => function (\App\Entities\Pelajaran $x) {
                  return $x->mkode;
                },
                'Nama' => function (\App\Entities\Pelajaran $x) {
                  return $x->nama;
                },
                'Sifat' => function (\App\Entities\Pelajaran $x) {
                  return ucfirst($x->sifat);
                },
                'KKM' => function (\App\Entities\Pelajaran $x) {
                  return $x->kkm;
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