<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    .table,
    .table th,
    .table td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 2px 10px;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }
  </style>
</head>

<body>
  <div class="wrapper">

    <?php
    /**
     * @var \App\Libraries\NilaiAgregasi  $nilai
     * @var \App\Entities\Siswa $siswa
     */
    ?>
    <h1 class="text-center"><?= $s ? 'Kartu Hasil Nilai' : 'Nilai Transkrip Sementara' ?></h1>
    <p class="text-center">Prodistik MAN 4 Jombang</p>
    <hr>
    <h2 class="mb-3">Data Siswa</h2>
    <table>
      <tbody>
        <tr>
          <td>NIS</td>
          <td><?= esc($siswa->nis) ?></td>
        </tr>
        <tr>
          <td>Nama</td>
          <td><?= esc($siswa->nama) ?></td>
        </tr>
        <tr>
          <td>Kelas</td>
          <td><?= $siswa->kelasFull ?></td>
        </tr>
        <tr>
          <td>Tahun Masuk</td>
          <td><?= $siswa->thn_masuk ?></td>
        </tr>
      </tbody>
    </table>
    <h2 class="mb-3">Nilai</h2>
    <table class="table table-sm">
      <thead>
        <tr>
          <?php $i = 0 ?>
          <th width="50px">NO</th>
          <th>MATAKULIAH</th>
          <th width="50px">SKS</th>
          <th width="50px">NILAI</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($nilai->semester as $se => $ss) : ?>
          <?php if ($s && ($se != $s)) continue; ?>
          <tr>
            <td colspan="3" class="text-center">
              <h4 class="mr-auto">SEMESTER <?= $se ?></h4>
            </td>
            <td class="text-center">
              <?= esc($ss->abjad) ?>
            </td>
          </tr>
          <?php foreach ($ss->nilai as $n) : ?>
            <tr>
              <td class="text-center">
                <?= ++$i ?>
              </td>
              <td>
                <?= esc($n->nama_matkul) ?>
              </td>
              <td class="text-center">
                <?= esc($n->sks) ?>
              </td>
              <td class="text-center">
                <?= esc($n->abjad) ?>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endforeach ?>
        <?php if (!$s) : ?>
          <tr>
            <td colspan="3" class="text-right">
              <h4 class="ml-auto">Jumlah SKS</h4>
            </td>
            <td class="text-center">
              <?= esc($nilai->sks) ?>
            </td>
          </tr>
          <tr>
            <td colspan="3" class="text-right">
              <h4 class="ml-auto">Prestasi Indeks Kumulatif</h4>
            </td>
            <td class="text-center">
              <?= esc($nilai->ipk) ?>
            </td>
          </tr>
        <?php endif ?>
      </tbody>
    </table>
    <br><br><br>
    <table class="text-center">
      <tbody>
        <tr>
          <td width="50%"></td>
          <td width="50%">Jombang, <?= strftime('%d %B %Y') ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>

</html>