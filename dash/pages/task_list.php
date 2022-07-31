<?php
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once ("inc/valida_guest.php");


$id = $_SESSION['id'];

if ($_SESSION["nivel"] != 3) {
    header("location: ./error.php");
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista tarefas</title>
    <?php include_once("../../helpers/url.php");?>
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">

</head>

<body>

    <div class="row">

        <div class="col-12">
            <div class="row ">
                <div class="col-md-2">
                    <br>
                    <a href="tarefas.php" style="text-decoration: none;"> <i class="bi bi-arrow-return-left"
                            style="font-size: 30px; text-decoration: none;">&nbsp;Voltar</i></a>
                </div>
            </div>

            <div class="row">
                <div class="container">
                    <h1>Pesquisar por:</h1>
                        <form action="">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="">Usuario</label>
                                    <select class="form-control" name="" id="">
                                        <option value="0">Selecione</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Data</label>
                                    <input type="date" class="form-control" id="task_name" name="taskname" placeholder="Aprender laravel">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Status</label>
                                    <select class="form-control" name="" id="">
                                        <option value="0">Selecione</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                <label for=""></label>
                                <input type="submit" class="form-control btn btn-dark" id="task_name" name="taskname" value="Buscar" style="margin-top: 0.5rem;">
                                </div>
                            </div>
                           
                        </form>
                </div>
             </div>


            <div class="container">

                <section class="gradient-custom-2">
                    <!-- <div class="container  h-100"> -->
                        <div class="row h-100">
                            <div class="col-md-12 col-xl-12">

                                <div class="card">
                                    <div class="card-header p-3" style="background-color: #fff;">
                                        <h5 class="mb-0"><i class="bi bi-list-task me-3"></i>&nbsp;<strong>Lista de
                                                Tarefas da Equipe</strong></h5>
                                    </div>
                                    <div class="card-body" style="background-color: #fff; padding: 0;">

                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Usuário</th>
                                                    <th scope="col">Tarefa</th>
                                                    <th scope="col">Prioridade</th>
                                                    <th scope="col">Data a Concluir</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $SQL_Select_Tarefa = "SELECT DISTINCT a.cd_user,a.name_task,a.priority,a.status_task,a.dt_expired,a.created_at,b.nome,b.profile_img,b.id FROM tb_task a,usuarios b WHERE a.cd_user = b.id AND a.cd_user <> 1 ORDER BY a.cd_user";
                                                //echo $SQL_Select_Tarefa;
                                                $t = 0;

                                                $result_tarefas = $conn->query($SQL_Select_Tarefa);
                                                if ($result_tarefas->num_rows > 0) {
                                                   while ($rowTarefas = $result_tarefas->fetch_assoc()) {
                                                        $t++;
                                                        $nome = $rowTarefas["nome"];
                                                        $profile_img = $rowTarefas["profile_img"];
                                                        $task_id = $rowTarefas["id"];
                                                        $name_task = $rowTarefas["name_task"];
                                                       
                                                        $priority = $rowTarefas["priority"];
                                                        $status_task = $rowTarefas["status_task"];
                                                        $created_at = $rowTarefas["created_at"];
                                                        $dt_expired = $rowTarefas["dt_expired"];
                                                        //original date is in format YYYY-mm-dd
                                                        $timestamp = strtotime($dt_expired); 
                                                        $expired_at = date("d-m-Y", $timestamp );
                                                        $dia_expired = date("d", $timestamp);

                                                        $colorPriority = "";
                                                        if ($priority == 1):
                                                            $prioridade = "Alta Prioridade";
                                                            $colorPriority = "danger";
                                                        elseif($priority == 2):
                                                            $prioridade = "Media Prioridade";
                                                            $colorPriority = "warning";
                                                        else:
                                                            $prioridade = "Baixa Prioridade";
                                                            $colorPriority = "secondary";
                                                        endif;
                                                        $dia_atual ="";
                                                        // echo $data_atual;
                                                        //echo $dia_expired;
                                                        $timezone = new DateTimeZone('America/Sao_Paulo');
                                                        $hoje = new DateTime('now', $timezone);
                                                        $dia_atual = $hoje->format('d');
                                                        
                                                        if ($dia_atual == $dia_expired) {
                                                            echo "<script>swal('O colaborador $nome possui tarefas que expiram hoje!')</script>";
                                                        }
                                                ?>

                                                <tr class="fw-normal">
                                                    <th>
                                                        <img src="../images/<?=$profile_img;?>"
                                                            class="shadow-1-strong rounded-circle" alt="avatar 1"
                                                            style="width: 55px; height: 55px;">&nbsp;
                                                        <?php
                                                                if ($_SESSION["nivel"] == 3) {
                                                                    ?>
                                                        <span class="ms-2"><?=$nome?></span>
                                                        <?php
                                                                }
                                                            ?>


                                                    </th>
                                                    <td class="align-middle">
                                                        <span id="span_<?=$t;?>"><?=$name_task?></span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <h6 class="mb-0"><span
                                                                class="badge bg-<?=$colorPriority?>"><?=$prioridade?></span>
                                                        </h6>
                                                    </td>
                                                    <td class="align-middle">
                                                        <h6 class="mb-0"><span class="badge"><?=$expired_at?></span>
                                                        </h6>
                                                    </td>
                                                    <td class="align-middle" style="text-align: center;">
                                                        <?php
                                                            if (!empty($status_task)) {
                                                                ?>
                                                        <a href="#!" title="Feito" id="feito_<?=$t;?>"><i
                                                                class="bi bi-check-all text-success"
                                                                style="font-size: 1.5rem;"></i></a>
                                                        <?php
                                                            }else{
                                                                echo "pendente";
                                                            }
                                                            ?>
                                                    </td>
                                                </tr>
                                                <?php

                                                    }
                                                    
                                                }
                                                ?>

                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="card-footer text-end p-3">

                                        <!-- <button class="btn btn-success" id="myBtn">Adicionar Tarefa</button>
                                        <a href="" class="btn btn-primary" id="myBtn">Ver Tarefas da Equipe</a> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    <!-- </div> -->

            </div>
    </div>


</body>

</html>