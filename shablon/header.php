<header class="navbar navbar-expand-lg navbar-dark fixed-top bg-success">
    <div class="container-fluid"> <img src="img/logo.png" alt="" class="d-inline-block align-text-top" style="position: absolute; top: 0;width: 100px;">
        <a class="navbar-brand " href="/" style="margin-left: 150px;">Платные услуги</a>


        <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="my-nav" class="collapse navbar-collapse" style="margin-left:50px;">
            <ul class="navbar-nav mr-auto">

                <?php if ($_SESSION['typeuser'] == 1) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="EditMenuDown" data-bs-toggle="dropdown" aria-expanded="false">Справочники</span></a>
                        <ul class="dropdown-menu" aria-labelledby="EditMenuDown">
                            <?php
                            foreach ($BDtable as $i => $table) {
                                if ($table["editone"] == 1) {
                                    echo ("<li><a class='dropdown-item' href='?tablename=" . $table["name"] . "' id='edit_" . $table["name"] . "'>" . $table["rusname"] . "</a></li>");
                                }
                            }

                            ?>
                        </ul>

                    </li>
                <?php } ?>
                <?php if (empty($_GET['edittablename'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" tabindex="-1" aria-disabled="true" data-bs-toggle="offcanvas" href="#doppanelleft">Действия

                        </a>
                    </li> <?php } ?>
                <?php if ($TableName == 'pacient') { ?>
                    <li class="nav-item">
                        <script>
                            $(document).ready(function() {
                                $('#zapbtn').on('click', function() {
                                    console.log(idid);
                                    if (idid != "") {
                                        a = idid.split('_');
                                        window.location.href = '?pindex=' + a[1];
                                    }
                                });
                            });
                        </script>

                       <!-- <a id="zapbtn" class="btn btn-warning ml-6" role="button" style="margin-left: 5em; width: 30em;">Записать пациента</a> -->
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</header>