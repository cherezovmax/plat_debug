<?php

$u = explode('?', $_SERVER['REQUEST_URI']);
$s_u = $u[0];


?>

<script>
    $(document).ready(function() {
        $('#btnedit').on('click', function() {
            if (idid != "") {
                a = idid.split('_');
                window.location.href = '<?php echo ($s_u); ?>' + '?edittablename=<?php echo ($TableName) ?>' + '&typeedit=update&index=' + a[1];
            }
        });
        $('#btndel').on('click', function() {
            if (idid != "") {
                a = idid.split('_');
                window.location.href = '<?php echo ($s_u); ?>' + '?edittablename=<?php echo ($TableName) ?>' + '&typeedit=del&index=' + a[1];
            }
        });
        $('#btnadd').on('click', function() {

            window.location.href = '<?php echo ($s_u); ?>' + '?edittablename=<?php echo ($TableName) ?>' + '&typeedit=add';

        });

    })
</script>

<div class="offcanvas offcanvas-start" tabindex="-1" id="doppanelleft" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title mx-auto" id="offcanvasExampleLabel">Действия</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-grid gap-2 col-8 mx-auto text-center align-top mb-3 position-relative">
            <img src="/img/user/<?php echo $_SESSION['image'] ?>" alt="" style="width: 100px;">

            <br>
            <a class="btn btn-secondary btn-sm position-absolute top-0 end-0" href="/?action=exit" role="button">Выход</a>
        </div>

        <div class="d-grid gap-2 col-8 mx-auto">
            <?php if ($_SESSION['typeuser'] != 3) { ?>
                <?php if (empty($_GET['edittablename'])) { ?>

                    <a class="btn btn-success btn-lg" id="btnadd" href="#" role="button">Создать</a>
                    <a class="btn btn-primary btn-lg" id="btnedit" href="#" role="button">Редактировать</a>
                    <a class="btn btn-warning btn-lg" id="btndel" href="#" role="button">Удалить</a>

                <?php };

                ?>
            <?php } ?>

        </div>
    </div>
</div>

<?php


?>