<!DOCTYPE html>
<html lang="en">

<?= view('shared/head') ?>

<body>
  <style>
    th.rotated-text {
      height: 140px;
      white-space: nowrap;
      padding: 0 !important;
    }

    th.rotated-text>div {
      transform:
        translate(13px, 0px) rotate(310deg);
      width: 30px;
    }

    th.rotated-text>div>span {
      padding: 5px 10px;
    }
  </style>
  <div class="wrapper">
    <?= view('shared/panel_navbar') ?>
    <div class="content-wrapper p-4">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <?php
            /**
             * @var \App\Entities\Matkul[] $matkul
             * @var \App\Entities\Nilai[][] $nilai
             * @var \App\Entities\Siswa[] $siswa
             */
            ?>
            <form class="d-flex">
              <select name="kelas" class="form-control">
                <option value="">Semua Kelas</option>
                <?= implode('', array_map(function ($x) {
                  return '<option ' . (($_GET['kelas'] ?? '') === $x->thn_masuk . ',' . $x->kelas ? 'selected' : '') .
                    ' value="' . $x->thn_masuk . ',' . $x->kelas . '">' . $x->kelasFull . '</option>';
                }, $kelas)) ?>
              </select>
              <input type="submit" value="Lihat" class="mx-2 btn btn-primary">
              <a href="/user/leger/export/?kelas=<?= $_GET['kelas'] ?? '' ?>" class="btn btn-success"><i class="fa fa-download"></i></a>
            </form>
            <?php if ($nilai) : ?>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIS</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <?php foreach ($matkul as $m) : ?>
                        <th class="rotated-text">
                          <div><span><?= esc($m->nama) ?></span></div>
                        </th>
                      <?php endforeach ?>
                      <th class="rotated-text">
                        <div><span>NA</span></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($siswa as $is => $s) : ?>
                      <tr>
                        <td><?= $is + 1 ?></td>
                        <td><?= esc($s->nis) ?></td>
                        <td><?= esc($s->nama) ?></td>
                        <td><?= $s->kelasFull ?></td>

                        <?php foreach ($matkul as $m) : ?>
                          <td><?= $nilai[$s->nis][$m->mkode] ?? '-' ?></td>
                        <?php endforeach ?>
                        <td>-</td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>