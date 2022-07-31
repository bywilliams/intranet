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
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <?php include_once("../../helpers/url.php");?>
    <script src="<?=$BASE_URL?>../js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">

</head>

<body>

    <!-- <h1>Lista de Usuário</h1> -->

    <div class="row">
        <div class="col-12">

            <div class="container">
                <div class="row" style="margin: 5px 0;">
                    <div class="col-md-10">


                    </div>
                    <div class="col-md-2" style="padding-top: 5px; text-align: end; padding-right: 0;">
                        <button class="btn btn-success" id="myBtn">Adicionar</button>
                    </div>

                </div>

                <table width="100%" border="1" cellspacing="0" cellpadding="3" class="tabela_cor" bordercolor=#DFF6FF>
                    <tr>
                        <th width="10%" align="left" style="background-color: #243A73;"><strong></strong>
                        <th width="15%" align="center" style="background-color: #243A73; color: #fff;">
                            <strong>Usuario</strong></td>
                        <th width="25%" align="center" style="background-color: #243A73;  color: #fff;">
                            <strong>Nome</strong>
                            </td>
                        <th width="15%" align="left" style="background-color: #243A73;  color: #fff;">Data de cadastro
                            </td>
                        <th width="15%" align="left" style="background-color: #243A73;  color: #fff;"><strong>Nível
                                Acesso</strong>
                            </td>
                        <th width="20%" style="background-color: #243A73;  color: #fff; text-align: center;">
                            <strong></strong>Ações</td>
                    </tr>
                    <?php
                    
                        // PEGA OS DADOS DO USUARIO 
                        $SQL_IMG_PROFILE = "SELECT id, username, nome, password, created_at, email, nivel_usuario, profile_img FROM usuarios WHERE id > 0 ";
                        //echo $SQL_IMG_PROFILE."<br>";
                        $result = $conn->query($SQL_IMG_PROFILE);
                       $t = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()){
                                $t++;
                                $id = $row["id"];
                                $img_profile = $row["profile_img"];
                                $username = $row["username"];
                                $nome = $row["nome"];
                                $email = $row["email"];
                                $data_cadastro = $row["created_at"];
                                $data_cadastro = date('d/m/Y', strtotime($data_cadastro));
                                $nivel = $row["nivel_usuario"];
                                $password = $row["password"];

                                
                        ?>
                    <tr class="btn-light" style="cursor:pointer;">
                        <td height="50" align="center" valign=""> <img class="user-avatar-md rounded-circle"
                                src="../images/<?=$img_profile;?>" data-holder-rendered="true"></td>
                        <td height="50"><?=$username?></td>
                        <td height="50"><?=$nome?></td>
                        <td height="50" align="left"><?=$data_cadastro?></td>
                        <td height="50" align="center"><?=$nivel?></td>
                        <td align="center">
                            <button class="btn btn-primary" title="Editar" id="btn_editar<?=$t;?>" onclick="atualizar(<?=$t;?>)"><i
                                    class="bi bi-pencil-square icons-menu" id="btn_editar<?=$t;?>"></i></button>
                            <input type="text" hidden name="codigo" value="<?=$id;?>">
                            <a href="act_users/delete.php?id=<?=$id;?>&profile_img=<?=$img_profile;?>"
                                class="btn btn-danger" id="delete" name="delete" title="Deletar"><i
                                    class="bi bi-trash icons-menu"></i></a>
                        </td>
                    </tr>
                   
                    <!-- The Modal Update-->
                    <div id="myModal2<?=$t;?>" class="modal_editar" ">

                        <!-- Modal content -->
                        <div class="modal-content_editar">
                            <div class="modal-header">
                                <h3>Editar Usuário</h3>
                                <span class="close-2<?=$t;?>" id="close-2" >&times;</span>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="act_users/update.php" enctype="multipart/form-data">
                                <input type="text" hidden name="id" value="<?=$id;?>">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Nome Completo</label>
                                            <input type="text" class="form-control" id="nome" name="nome_update" value="<?=$nome;?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Email</label>
                                            <input type="email" class="form-control" name="email_update" id="email" value="<?=$email;?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputAddress">Usuário</label>
                                            <input type="text" class="form-control" name="usuario_update" id="usuario" value="<?=$username;?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Senha</label>
                                            <input type="password" name="password_update" class="form-control"
                                                id="inputPassword" value="<?=$password;?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputState">Nivel de Acesso:</label>
                                            <input type="radio" id="contactChoice1" name="nivel_update" value="1" <?php if($nivel == 1){echo "checked";}?>>
                                            <label for="contactChoice1">1</label>

                                            <input type="radio" id="contactChoice2" name="nivel_update" value="2" <?php if($nivel == 2){echo "checked";}?>>
                                            <label for="contactChoice2">2</label>

                                            <input type="radio" id="contactChoice3" name="nivel_update" value="3" <?php if($nivel == 3){echo "checked";}?>>
                                            <label for="contactChoice3">3</label>
                                            <p class="niveis">Nivel 1: Usuario <br />
                                                Nivel 2: Administrador <br />
                                                Nivel 3: Owner (Dono)</p>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputZip">Foto de Perfil</label>
                                            <input type="file" name="imagem_update"  accept="image/png,image/jpeg,image/jpg" />
                                        </div>
                                    </div>

                                    <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <h3><a href="" style="color: #fff;">Fechar</i></a></h3>
                            </div>
                        </div>

                    </div>

            </div>
        </div>
        <?php
                    }
                    ?>

        <?php
                }
                ?>

        <?php
                ?>
        <hr />
        </table>

    </div>

    <!-- The Modal CREATE -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h3>Cadastrar Usuários</h3>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form method="post" action="act_users/create.php" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="João da Sousa" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="joazinho@gmail.com" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Usuário</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="joazinho" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Senha</label>
                            <input type="password" name="password" class="form-control" id="inputPassword"
                                placeholder="123456" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputState">Nivel de Acesso:</label>
                            <input type="radio" id="contactChoice1" name="nivel" value="1" required>
                            <label for="contactChoice1">1</label>

                            <input type="radio" id="contactChoice2" name="nivel" value="2" required>
                            <label for="contactChoice2">2</label>

                            <input type="radio" id="contactChoice3" name="nivel" value="3" required>
                            <label for="contactChoice3">3</label>
                            <p class="niveis">Nivel 1: Usuario <br />
                                Nivel 2: Administrador <br />
                                Nivel 3: Owner (Dono)</p>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZip">Foto de Perfil</label>
                            <input type="file" name="imagem" accept="image/png,image/jpeg,image/jpg" />
                        </div>
                    </div>

                    <button type="submit" name="salvar" class="btn btn-primary">Registrar</button>
                </form>
            </div>
            <div class="modal-footer">
                <h3><a href="" style="color: #fff;">Fechar</i></a></h3>
            </div>
        </div>

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


    function atualizar(i) {
        // PEGA O ELEMENTO DO MODAL DE EDICAO
        var modal_edit = document.getElementById("myModal2" + i);


        //PEGA O BOTAO QUE VAI ABRIR O MODAL
        var btn2 = document.getElementById("btn_editar" + i);
       


        // PEGA O ELEMENTO SPAN QUE FECHA O MODAL
        var span = document.getElementsByClassName("close-2" + i)[0];

        // QUANDO O USER CLICA NO BOTAO ABRE O MODAL
        btn2.onclick = function() {
            modal_edit.style.display = "block";
        }

        //QUANDO O USER CLICA NO X FECHA O MODAL
        span.onclick = function() {
            modal_edit.style.display = "none";
        }

    }
    </script>



</body>

</html>