<!DOCTYPE html>
<html lang="en">
<?= view('shared/head') ?>

<body>
  <div class="wrapper">
    <?= view('shared/panel_navbar') ?>
    <?php /** @var \App\Entities\Config $item */ ?>
    <div class="content-wrapper p-4">
      <div class="container">
        <div class="card">
          <div class="card-body">
            <form method="post">
              <div class="d-flex mb-3">
                <h1 class="h3 mb-0 mr-auto">Edit Periode</h1>
                <a href="/user/nilai/" class="btn btn-outline-secondary ml-2">Kembali</a>
              </div>
              <label class="d-block mb-3">
                <span>Periode</span>
                <input type="text" class="form-control" name="periode" value="<?= esc($item->periode) ?>" required>
              </label>
              <div class="d-flex mb-3">
                <input type="submit" value="Save" class="btn btn-primary mr-auto">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="/user/article/delete/<?= $item->id ?>">
    <input type="submit" hidden id="delete-form" onclick="return confirm('Do you want to delete this article permanently?')">
  </form>
  <?= view('shared/summernote') ?>
</body>

</html>