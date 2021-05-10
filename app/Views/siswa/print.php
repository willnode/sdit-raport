<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">

    <?php
    /**
     * @var \App\Libraries\NilaiAgregasi  $nilai
     * @var \App\Entities\Siswa $siswa
     */
    ?>
    <?= view('shared/panel_navbar') ?>
    <div class="content-wrapper p-4">

      <div class="container p-4 text-navy">
        <div class="row">
          <div class="col-lg-6">
            <div class="card mb-3">
              <div class="card-body">
                <h2 class="mb-3">Data Siswa</h2>
                <table class="table">
                  <tbody>
                    <tr>
                      <td>Nama</td>
                      <td><?= esc($siswa->nama) ?></td>
                    </tr>
                    <tr>
                      <td>NIS / NISN</td>
                      <td><?= esc($siswa->nis) ?> / <?= esc($siswa->nisn) ?></td>
                    </tr>
                    <tr>
                      <td>Kelas</td>
                      <td><?= $siswa->kelasFull ?></td>
                    </tr>
                    <tr>
                      <td>Semester</td>
                      <td><?= $siswa->semester ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h2 class="mb-3">Nilai</h2>
                <table class="table table-sm">
                  <tbody>
                    <?php foreach ($nilai->semester as $s => $ss) : ?>
                      <tr>
                        <td colspan="2">
                          <h5 class="mr-auto">Semester <?= $s ?></h5>
                        </td>
                        <td title="<?= $ss->ips ?>">
                          <?= esc($ss->abjad) ?>
                        </td>
                        <td>
                          <a href="/user/siswa/transkrip/<?= $siswa->nis ?>?s=<?= $s ?>" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                        </td>
                      </tr>
                      <?php foreach ($ss->nilai as $n) : ?>
                        <tr>
                          <td>
                            <?= esc($n->nama_pelajaran) ?>
                          </td>
                          <td>
                            <?= esc($n->sks) ?> SKS
                          </td>
                          <td title="<?= $n->nilai ?>">
                            <?= esc($n->abjad) ?>
                          </td>
                          <td></td>
                        </tr>
                      <?php endforeach ?>
                    <?php endforeach ?>
                    <tr>
                      <td>
                        <h5 class="mr-auto">Transkrip Sementara</h5>
                      </td>
                      <td>
                        <?= esc($nilai->sks) ?> SKS
                      </td>
                      <td title="<?= $nilai->ipk ?>">
                        <?= esc($nilai->abjad) ?>
                      </td>
                      <td style="width: 1px;">
                        <a href="/user/siswa/transkrip/<?= $siswa->nis ?>" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>