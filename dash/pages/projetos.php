<?php 
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$id = $_SESSION["id"];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <?php include_once("../../helpers/url.php");?>
    <script src="<?=$BASE_URL?>css/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$BASE_URL?>../css/bootstrap-icons-1.8.3/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?=$BASE_URL?>../css/style_local.css">
</head>

<body>
    <div class="container-fluid dashboard-content">

        <div class="px-lg-5">
            <div class="row">
            <?php

            $img_projeto =
            $title = 
            $descricao = 
            $percentual_conclusao = 
            $id_usuario = "";

            $SQL_Projeto = "SELECT * FROM projetos WHERE id_usuario = ".$id;
            $result = $conn->query($SQL_Projeto);
            if ($result->num_rows){
                while ($row = $result->fetch_assoc()){
                    $img_projeto = $row["img_projeto"];
                    $title = $row["title"];
                    $descricao = $row["descricao"];
                    $percentual_conclusao = $row["percentual_conclusao"];
                    $id_usuario = $row["id_usuario"];
                ?>

                    <!-- Gallery item -->
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="bg-white rounded shadow-sm"><img src="assets/img/portfolio/<?=$img_projeto?>" alt=""
                                class="img-fluid card-img-top">
                            <div class="p-4">
                                <h5> <a href="#" class="text-dark"><?=$title;?></a></h5>
                                <p class="small text-muted mb-0 my-1"><?=$descricao?></p>

                                <p>Conclusão do projeto:</p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: <?=$percentual_conclusao?>%" aria-valuenow="25" aria-valuemin="0"
                                        aria-valuemax="100"><?=$percentual_conclusao?>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End -->
                
                <?php
                }
            }
        ?>

            </div>
             <div class="py-5 text-right"><a href="#" class="btn btn-dark px-5 py-3 text-uppercase">Ver mais</a>
        </div>
    </div>
    </div>
</body>

</html>
