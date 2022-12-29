<?php
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;


$id_projeto = $_GET["id"];


$query_projeto = "SELECT title, description, file_name FROM projects WHERE id = ".$id_projeto;
$result_project = $conn->query($query_projeto);
//echo $query_projeto;

$query_phase = "SELECT * FROM projects_phases WHERE project_id = ".$id_projeto;
$result_phase = $conn->query($query_phase);
//echo $query_phase;

$color_cicle = "";

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: "Roboto", sans-serif;
    }

    .cards {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .cards_new {
        margin: 40px;
        position: relative;
        max-width: 580px;
        max-height: 364px;
        box-shadow: 0 40px 60px -6px black;
    }

    .card-title {
        display: block;
        text-align: center;
        color: #fff;
        background-color: #6184a8;
        padding: 2%;
        border-top-right-radius: 4px;
        border-top-left-radius: 4px;
    }

    .cards_new img {
        width: 100%;
        height: 98%;
        object-fit: cover;
        display: block;
        position: relative;
    }

    .card-desc {
        display: block;
        font-size: 1.2rem;
        position: absolute;
        height: 0;
        top: 0;
        opacity: 0;
        padding: 18px 28%;
        background-color: white;
        overflow-y: scroll;
        transition: 0.8s ease;
        text-align: center;
    }

    .cards_new:hover .card-desc {
        opacity: 1;
        height: 115%;
    }

    h2 {
        margin-bottom: 0 !important;
    }
    </style>
</head>

<style>
.list-group-item {
    margin-right: 4px;
}
</style>

<body>
    <div class="container-fluid dashboard-content">
        <h1 class="mb-3" align="center">Timeline do Projeto</h1>
        <div class="cards mb-3">
            <div class="cards_new">
<?php
                if ($result_project->num_rows > 0):
                    while ($row_projeto = $result_project->fetch_assoc()):
                        $title = $row_projeto["title"];
                        $description = $row_projeto["description"];
                        $file_name = $row_projeto["file_name"];
?>
                        <h2 class="card-title"><?=$title?></h2>
                        <img src="assets/img/portfolio/<?=$file_name?>" alt="">
                        <p class="card-desc"><?=$description?></p>
<?php
                    endwhile;
                endif;
?>
            </div>
        </div>

        <div class="container d-flex ">
            <div class="container py-2 mt-4 mb-4">
<?php
                if ($result_phase->num_rows > 0) {
                    while ($row_phase = $result_phase->fetch_assoc()){
                        $id_phase = $row_phase["id"];
                        $phase_name = $row_phase["phase_name"];
                        $phase_id = $row_phase["phase_id"];
                        $extra_info = $row_phase["extra_info"];
                        $project_id = $row_phase["project_id"];
                        $dt_conclusion = $row_phase["dt_conclusion"];
                        $image_phase = $row_phase["image_phase"];
                        $finish = $row_phase["finish"];

                        //echo $image_phase;

                        switch ($phase_id):
                            case 1:
                                $color_cicle = "danger";
                                break;
                            case 2:
                                $color_cicle= "info";
                                break;
                            case 3:
                                $color_cicle = "warning";
                                break;
                            case 4:
                                $color_cicle = "success";
                                break;
                            default:
                                break;
                        endswitch;

?>
                <?php if($finish == "S"): ?>
                <div class="row">
                    <!-- timeline item 1 left dot -->
                    <div class="col-auto text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge badge-pill bg-<?=$color_cicle?> border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <!-- timeline item 1 event content -->
                    <div class="col py-2">
                        <div class="card">
                            <div class="card-body mb-3">
                                <div class="float-right text-muted">Data de término: <?=$dt_conclusion?></div>
                                <h4 class="card-title_">Fase <?=$phase_id?> - <?=$phase_name?></h4>
                                <?php if($image_phase): ?>
                                <img src="./assets/img/portfolio/phases/<?=$image_phase?>" alt="" class="rounded mb-2" alt="Cinque Terre" width="30%" height="236">
                                <?php endif; ?>
                                <p class="card-text"><?=$extra_info?></p>
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <?php endif; ?>
<?php
                    }
                }
?>
            </div>
        </div>
        <!--container-->
    </div>


</body>

</html>