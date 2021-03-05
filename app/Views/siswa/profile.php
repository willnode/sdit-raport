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
    <nav class="navbar navbar-expand navbar-navy navbar-dark">
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
          <a class="nav-link" href="/siswa/logout">
            <i class="fa fa-sign-out-alt mr-2"></i> Keluar
          </a>
        </li>
      </ul>
    </nav>

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
          <form method="POST">
            <?php if ($siswa->semester >= 6) : ?>
              <div class="card mb-3">
                <div class="card-body">
                  <h4 class="mb-3">Masukkan Judul Tugas Akhir</h4>
                  <?php if (!$siswa->tugas_akhir) : ?>
                    <div class="alert alert-danger">
                      Anda harus mengisi judul tugas akhir anda:
                    </div>
                  <?php endif ?>
                  <input type="text" class="form-control mb-3" name="tugas_akhir" value="<?= esc($siswa->tugas_akhir) ?>">
                  <input type="submit" value="Simpan" class="btn btn-primary">
                </div>
              </div>
            <?php endif ?>
            <div class="card mb-3">
              <div class="card-body">
                <h4 class="mb-3">Ganti Password</h4>
                <?php if (!$siswa->password) : ?>
                  <div class="alert alert-danger">
                    Akun ini belum ada passwordnya. Amankan akun anda segera dengan mengisi password akun:
                  </div>
                <?php endif ?>
                <input type="password" class="form-control mb-3" name="password" placeholder="<?= $siswa->password ? 'Masukkan apabila ingin mengganti password' : 'Masukkan password baru' ?>">
                <input type="submit" value="Simpan" class="btn btn-primary">
              </div>
            </div>
          </form>
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
                        <a href="/siswa/transkrip/?s=<?= $s ?>" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                      </td>
                    </tr>
                    <?php foreach ($ss->nilai as $n) : ?>
                      <tr>
                        <td>
                          <?= esc($n->nama_matkul) ?>
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
                      <a href="/siswa/transkrip/" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
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
</body>

</html>