<?php
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;


$id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <?php include_once("../../helpers/url.php");?>
    <script src="<?=$BASE_URL?>../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$BASE_URL?>../css/bootstrap-icons-1.8.3/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?=$BASE_URL?>../css/style_local.css">

</head>

<body>

    <div class="row">
        <div class="col-12">

            <div class="container">

                <section class="gradient-custom-2">
                    <div class="container  h-100">
                        <div class="row d-flex  h-100">
                            <div class="col-md-12 col-xl-10">

                                <div class="card">
                                    <div class="card-header p-3" style="background-color: #fff;">
                                        <h5 class="mb-0"><i class="bi bi-list-task me-3"></i>&nbsp;<strong>Lista de
                                                Tarefas</strong></h5>
                                    </div>
                                    <div class="card-body" style="background-color: #fff;">
                                       <div class="row"<?php if($_SESSION["nivel"] == 3){echo 'style="justify-content: end"';}?>>
                                        <div class="col-md-5"></div>
                                        <div class="col-md-1" style="display: flex; font-size: 0.8rem;"><i class="bi bi-check text-success" style="font-size: 1rem;"></i>checa</div>
                                        <div class="col-md-3"  style="display: flex; font-size: 0.8rem; justify-content: center;"><i class="bi bi-check-all text-success" style="font-size: 1rem;"></i>Atualiza no Sistema</div>
                                        <?php
                                        if ($_SESSION["nivel"] != 3) {
                                            ?>
                                            <div class="col-md-3"  style="display: flex; font-size: 0.8rem;"><i class="bi bi-lock-fill text-danger" style="font-size: 1rem;"></i>Designada pelo ADM</div>   
                                            <?php
                                        }
                                        ?>
                                        
                                    </div>
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Usuário</th>
                                                    <th scope="col">Tarefa</th>
                                                    <th scope="col">Prioridade</th>
                                                    <th scope="col">Data a Concluir</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $SQL_Select_Tarefa = "SELECT t.id, t.cd_user, t.name_task, t.priority, t.created_at, t.dt_expired, t.designado_por, u.profile_img, u.nome FROM tb_task AS t INNER JOIN usuarios AS u ON t.cd_user = u.id WHERE cd_user = $id ORDER BY priority ASC";
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
                                                        $created_at = $rowTarefas["created_at"];
                                                        $dt_expired = $rowTarefas["dt_expired"];
                                                        $designado_por = $rowTarefas["designado_por"];
                                                        //original date is in format YYYY-mm-dd
                                                        $timestamp = strtotime($dt_expired); 
                                                        $expired_at = date("d-m-Y", $timestamp );
                                                        $dia_expired = date("d", $timestamp);
                                                        // echo $dia_expired;
                                                        //echo $expired_at;

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
                                                        $timezone = new DateTimeZone('America/Sao_Paulo');
                                                        $hoje = new DateTime('now', $timezone);
                                                        $dia_atual = $hoje->format('d');
                                                        
                                                        if ($dia_atual == $dia_expired) {
                                                            echo "<script>swal('Você tem tarefas que expiram hoje, fique atento!')</script>";
                                                        }
                                                        //echo $profile_img;
                                                ?>

                                                <tr class="fw-normal">
                                                    <th>
                                                        <img src="<?=$BASE_URL?>../images/<?=$profile_img;?>"
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
                                                    <td class="align-middle">
                                                        <a href="#!" title="Feito" id="feito_<?=$t;?>"
                                                            onclick="check(<?=$t?>);"><i
                                                                class="bi bi-check text-success"
                                                                style="font-size: 1.5rem;"></i></a>
                                                                <a href="#!" title="Feito" id="feito_<?=$t;?>"
                                                            onclick="check(<?=$t?>);"><i
                                                                class="bi bi-check-all text-success"
                                                                style="font-size: 1.5rem;"></i></a>
                                                        <?php 
                                                        if (empty($designado_por)) {
                                                            ?>
                                                            <a href="act_users/task_act.php?del_task=<?=$task_id?>"
                                                            data-mdb-toggle="tooltip" title="Remover"><i
                                                                class="bi bi-trash-fill text-danger"
                                                                style="font-size: 1.5rem;"></i></a>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <i class="bi bi-lock-fill text-danger" style="font-size: 1.5rem;" title="Somente o ADM pode remover">
                                                            <?php
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

                                        <button class="btn btn-success" id="myBtn">Adicionar Tarefa</button>
                                        <?php
                                        if ($_SESSION["nivel"] == 3) {
                                            ?>
                                            <a href="<?=$BASE_URL?>/task_list.php" class="btn btn-primary" id="myBtn" target="myFrame">Ver Tarefas da Equipe</a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <section class="vh-100 gradient-custom-2">
            </div>

            <!-- The Modal CREATE -->
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content" style="width: 60%;">
                    <div class="modal-header" style="background-color: #5272c7">
                        <h3>Cadastrar Tarefa</h3>
                        <span class="close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="act_users/task_act.php" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="">Nome da tarefa</label>
                                    <input type="text" class="form-control" id="task_name" name="taskname"
                                        placeholder="Aprender laravel">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">Data para térmimo</label>
                                    <input type="date" class="form-control" id="taskDate" name="taskDate"
                                        placeholder="Aprender laravel">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Prioridade</label>
                                    <select class="form-control" name="priority" id="">
                                        <option value="">Selecione</option>
                                        <option value="1" class="bg-danger" style="color: #fff;">Alta Prioridade
                                        </option>
                                        <option value="2" class="bg-warning" style="color: #fff;">Media Prioridade
                                        </option>
                                        <option value="3" class="bg-secondary" style="color: #fff;">Baixa Prioridade
                                        </option>
                                    </select>
                                </div>
                                <?php
                                if ($_SESSION["nivel"] == 3) {
                                  
                                ?>
                                <div class="form-group col-md-4">
                                    <label for="">Designar essa tarefa para:</label>
                                    <select class="form-control" name="task_to" id="">
                                        <option value="">Selecione</option>
                                        <?php
                                            $SQL_Users = "SELECT id, nome FROM usuarios WHERE id <> 1";
                                            $result = $conn->query($SQL_Users);
                                            if ($result->num_rows > 0) {
                                                while ($rowUser = $result->fetch_assoc()) {
                                                     $id_user = $rowUser['id'];
                                                     $nome_user = $rowUser['nome'];
                                                    ?>
                                                     <option value="<?=$id_user?>"><?= $nome_user?></option>
                                                     <?php
                                                }
                                            }       
                                            ?>                                 
                                    </select>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <button type="submit" name="salvar" class="btn btn-success">Registrar tarefa</button>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>



    <script>
    function check(i) {

        const div = document.getElementById('span_' + i);

        var btn = document.getElementById("feito_" + i);
        const display = "";
        btn.onclick = function() {

            const display = window.getComputedStyle(div).textDecoration;
            console.log(`Valor de textdecoration: ${display}`);
            if (display == "none solid rgb(33, 37, 41)") {
                // alert('entrou no 1 if');
                div.style.textDecoration = "line-through";
                div.style.backgroundColor = "#00FFAB";
            }
            if (display == "line-through solid rgb(33, 37, 41)") {
                div.style.textDecoration = "none";
                div.style.backgroundColor = "transparent";
            }
        }

    }


    // PEGA O ELEMENTO DO MODAL DE CADASTRO
    var modal = document.getElementById("myModal");


    //PEGA O BOTAO QUE VAI ABRIR O MODAL
    var btn = document.getElementById("myBtn");

    // PEGA O ELEMENTO SPAN QUE FECHA O MODAL
    var span = document.getElementsByClassName("close")[0];

    // QUANDO O USER CLICA NO BOTAO ABRE O MODAL
    btn.onclick = function() {
        modal.style.display = "block";
    }

    //QUANDO O USER CLICA NO X FECHA O MODAL
    span.onclick = function() {
        modal.style.display = "none";
    }

    // QUANDO O USER CLICA FORA DO MODAL TAMBEM FECHA O MODAL
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

</body>

</html>