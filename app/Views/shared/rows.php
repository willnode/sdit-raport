<?php if (isset($_GET['success_rows'])) : ?>
    <div class="alert alert-default-primary alert-dimissable fade show">
        Upload data berhasil dengan telah merubah <?= esc($_GET['success_rows']) ?> baris data.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>