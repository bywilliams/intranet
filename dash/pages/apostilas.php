<?php
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;

?>



<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <?php include_once("../../helpers/url.php");?>
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">

</head>

<style>
.list-group-item {
    margin-right: 4px;
}
</style>

<body>
    <div class="container-fluid dashboard-content">
        <h1>Apostilas e PDFs</h1>
        <div class="container d-flex ">


            <div class="container py-2 mt-4 mb-4">
                <!-- timeline item 1 -->
                <div class="row no-gutters">
                    <div class="col-sm">
                        <!--spacer-->
                    </div>
                    <!-- timeline item 1 center dot -->
                    <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge badge-pill bg-light border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <!-- timeline item 1 event content -->
                    <div class="col-sm py-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right text-muted small">Jan 9th 2019 7:00 AM</div>
                                <h4 class="card-title">Day 1 Orientation</h4>
                                <p class="card-text">Welcome to the campus, introduction and get started with the tour.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/row-->
                <!-- timeline item 2 -->
                <div class="row no-gutters">
                    <div class="col-sm py-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right small">Jan 10th 2019 8:30 AM</div>
                                <h4 class="card-title">Day 2 Sessions</h4>
                                <p class="card-text">Sign-up for the lessons and speakers that coincide with your course
                                    syllabus. Meet and greet with instructors.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge badge-pill bg-light border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <!--spacer-->
                    </div>
                </div>
                <!--/row-->
                <!-- timeline item 3 -->
                <div class="row no-gutters">
                    <div class="col-sm">
                        <!--spacer-->
                    </div>
                    <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge badge-pill bg-light border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-sm py-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right text-muted small">Jan 11th 2019 8:30 AM</div>
                                <h4 class="card-title">Day 3 Sessions</h4>
                                <p>Shoreditch vegan artisan Helvetica. Tattooed Codeply Echo Park Godard kogi, next
                                    level irony ennui twee squid fap selvage. Meggings flannel Brooklyn literally small
                                    batch, mumblecore PBR try-hard kale chips. Brooklyn vinyl lumbersexual
                                    bicycle rights, viral fap cronut leggings squid chillwave pickled gentrify mustache.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/row-->
                <!-- timeline item 4 -->
                <div class="row no-gutters">
                    <div class="col-sm py-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right text-muted small">Jan 12th 2019 11:30 AM</div>
                                <h4 class="card-title">Day 4 Wrap-up</h4>
                                <p>Join us for lunch in Bootsy's cafe across from the Campus Center.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge badge-pill bg-light border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <!--spacer-->
                    </div>
                </div>
                <!--/row-->
            </div>

            <hr>

        </div>
        <!--container-->
    </div>
    </div>


</body>

</html>