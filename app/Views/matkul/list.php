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
            <?php /** @var \App\Entities\Matkul[] $data */ ?>
            <div class="d-flex">
              <h1>Data Matkul</h1>
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
                'Kode' => function (\App\Entities\Matkul $x) {
                  return $x->mkode;
                },
                'Nama' => function (\App\Entities\Matkul $x) {
                  return $x->nama;
                },
                'SKS' => function (\App\Entities\Matkul $x) {
                  return $x->sks;
                },
                'Semester' => function (\App\Entities\Matkul $x) {
                  return $x->semester;
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