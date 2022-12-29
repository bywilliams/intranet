<?php
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once ("inc/valida_guest.php");

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$id = $_SESSION['id'];


$query_noticias_geral = "SELECT p.id, p.title_post, p.message, c.category_name AS 'category',  p.created_at, p.update_at FROM post_blog AS p JOIN cat_blog AS c ON p.category_id = c.id WHERE user_id = $id ORDER BY p.id";
$result_noticias_geral = $conn->query($query_noticias_geral);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <?php include_once("../../helpers/url.php");?>
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">

</head>

<body>

    <section class="vh-100 w-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center mt-5">
                <div class="col-md-12 col-xl-10">

                    <div class="card " style="background: #4E6C50">
                        <div class="card-header p-3" style="background-color: #fff;">
                            <h5 class="mb-0"><i class="bi bi-list-task me-3"></i>&nbsp;<strong>Lista de
                                    Posts</strong></h5>
                        </div>
                        <div class="card-body p-4 text-white" style="background-color: #fff;">
                           
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Nø Post</th>
                                        <th scope="col">Titulo</th>
                                        <th scope="col">Mensagem</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Criado</th>
                                        <th scope="col">Atualizado</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                               
                                $t = 0;

                                if ($result_noticias_geral->num_rows > 0) {
                                   while ($rowNews = $result_noticias_geral->fetch_assoc()) {
                                      $t++;
                                    //   echo $t;
                                      $id = $rowNews['id'];
                                      $title = $rowNews["title_post"];
                                      $message = $rowNews["message"];
                                      $category_name = $rowNews["category"];
                                      $created_at = $rowNews["created_at"];
                                      $update_at = $rowNews["update_at"];
                                      
                                        

                                       
                                ?>
                                <tr class="fw-normal">
                                        <td class="align-middle">
                                            <h6 class="mb-0"><?=$id?></h6>
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-0"><?=$title?></h6>
                                        </td>
                                        <td class="align-middle">
                                             <h6 class="mb-0" style="margin: 0;"><?=$message?></h6>
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-0"><?=$category_name?> </h6>
                                        </td>
                                        <td class="align-middle" >
                                            <h6 class="mb-0"><?=$created_at?></h6>
                                        </td>
                                        <td class="align-middle">

                                            <a href="#!" title="Editar" id="feito_<?=$t;?>">
                                                <i class="bi bi-pencil-square text-success" style="font-size: 1.5rem;">
                                                </i></a>
                                            <a href="act_users/task_act.php?del_task=<?=$task_id?>"
                                                data-mdb-toggle="tooltip" title="Remover"><i
                                                    class="bi bi-trash-fill text-danger"
                                                    style="font-size: 1.5rem;"></i></a>

                                            <?php 
                                        }
                                        ?>

                                        </td>
                                    </tr>
                                    <?php

                                    
                                    
                                }else{
                                    echo "não trouxe nada";
                                }
                                ?>

                                </tbody>
                            </table>

                        </div>
                        <!-- <div class="card-footer text-end p-3">

                        <button class="btn btn-success" id="myBtn">Adicionar Tarefa</button>
                        <?php
                        if ($_SESSION["nivel"] == 3) {
                            ?>
                            <a href="task_list.php" class="btn btn-outline-primary" id="myBtn" target="myFrame">Ver Tarefas da Equipe</a>
                            <a href="task_historico.php" class="btn btn-outline-primary" id="myBtn" target="myFrame">Histórico</a>
                            <?php
                        }
                        ?>
                    </div> -->
                    </div>

                </div>
            </div>
        </div>
        <section class="vh-100 gradient-custom-2">



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





            <script>
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