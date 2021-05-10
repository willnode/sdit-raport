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
            <div class="d-flex">
              <h1>Data Nilai <?= \Config\Services::config()->periodeFull ?></h1>
              <div class="ml-auto">
                <?= view('shared/button', [
                  'actions' => ['import', 'export', \Config\Services::login()->role === 'admin' ? 'set' : ''],
                  'target' => '',
                  'size' => 'btn-lg'
                ]); ?>
              </div>
            </div>
            <?= view('shared/table', [
              'data' => $data,
              'columns' => [
                'Pelajaran' => function (\App\Entities\Nilai $x) {
                  return $x->nama_pelajaran;
                },
                'Kelas' => function (\App\Entities\Nilai $x) {
                  return get_kelas_nice_name($x);
                },
                'Input' => function (\App\Entities\Nilai $x) {
                  $text = $x->terisi . ' / ' . $x->total;
                  $prog =  $x->terisi / $x->total;
                  $class = 'badge badge-' . ($prog == 0 ? 'danger' : ($prog == 1 ? 'success' : 'warning'));
                  return "<div class='$class'>$text</div>";
                },
                'Download' => function (\App\Entities\Nilai $x) {
                  return view('shared/button', [
                    'actions' => ['detail', 'export'],
                    'target' => $x->angkatan . ',' . $x->kelas . ',' . $x->mkode,
                    'size' => 'btn-sm'
                  ]);;
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