<?php

require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;


if (isset($_POST['enviar'])) {
    
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $range = $_POST['range'];
    $user_id = $_POST['user_id'];

    if(isset($_FILES['filename'])):
        //echo "arquivo existe <br>";
		$extensao = strtolower(substr($_FILES['filename']['name'], -4)); // Pega nome da extensao do arquivo
		$nome_imagem = md5(time()) . $extensao; // define nome para o arquivo
		$diretorio = "assets/img/portfolio/"; // Define o diretorio para onde o arquivo vai ser enviado

       // echo "$extensao , $nome_imagem";
		if(move_uploaded_file($_FILES['filename']['tmp_name'], $diretorio.$nome_imagem)): // efetua o upload
            //echo "sucesso <br>";
        else:
            echo "falha <br>";
        endif;
    endif;
    //echo "$titulo , $nome_imagem , $descricao, $range, $user_id";

    $SQL_project = "INSERT INTO projects (
        user_id, 
        title,
        description,
        file_name,
        percent_conclusion,
        created_at)
        VALUES(
            ".$user_id.",
            '".$titulo."',
            '".$descricao."',
            '".$nome_imagem."',
            0,
            now()          
        )
    ";
    //echo $SQL_project;
    if($result_project = mysqli_query($conn,$SQL_project)):
        echo "<script>
        alert('Projeto cadastrado com sucesso!'); location= '../pages/projetos.php';
        </script>";
    else:
        echo "error";
    endif;            
}


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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style_local.css">

<style>

    .contact-form{
        background: #fff;
        margin-top: 3%;
        margin-bottom: 2%;
        width: 80%;
    }
    .contact-form .form-control{
        border-radius:0.3rem;
    }
    .contact-image{
        text-align: center;
    }
    .contact-image img{
        border-radius: 6rem;
        width: 11%;
        margin-top: -3%;
        transform: rotate(29deg);
    }
    .contact-form form{
        padding: 14%;
    }
    .contact-form form .row{
        margin-bottom: -7%;
    }
    .contact-form h1{
        margin-bottom: 8%;
        margin-top: -15%;
        text-align: center;
        color: #0062cc;
    }
    .contact-form .btnContact {
        width: 50%;
        border: none;
        border-radius: 1rem;
        padding: 1.5%;
        background: #dc3545;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
    }
    .btnContactSubmit
    {
        width: 50%;
        border-radius: 1rem;
        padding: 1.5%;
        color: #fff;
        background-color: #0062cc;
        border: none;
        cursor: pointer;
    }
</style>
</head>
<body>
        
<div class="container contact-form">
            <div class="contact-image">
                <i class="fa-solid fa-diagram-project fa-4x" style="color: #0062cc;;"></i>
            </div>
            <form action="projetos_create.php" method="post" enctype="multipart/form-data">
                <h1>Cadastrar Projeto</h1>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-group">Titulo do Projeto:</label>
                            <input type="text" name="titulo" class="form-control" placeholder="ex: Aplicação web" required>
                        </div>
                        <label for="" class="form-group">Imagem do Projeto:</label>
                        <div class="custom-file">
                            <input type="file"  name="filename" onchange="fileName()">
                            <!-- <label class="custom-file-label" id="custom-file-label" for="customFile">Escolher arquivo</label> -->
                        </div>
                        <br>
                        <br>
                        <!-- <div class="form-group">
                            <label for="">Porcentagem de conclusão:</label>
                            <h1 align="center" style="margin: 1rem 0;"><span class="text-primary" id="resultado">0%</span></h1>
                            <input type="range" id="range" name="range" class="custom-range" value="0" min="0" max="100" required>
                            
                        </div> -->
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="<?=$_SESSION["id"]?>">
                            <button type="submit" name="enviar" class="btn btn-success btn-lg">Enviar</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="descricao" class="form-control" placeholder="Descrição do projeto *" style="width: 100%; height: 230px;" required></textarea>
                        </div>
                    </div>
                </div>
            </form>
</div>

        <script>
            function fileName(){
                let file = document.querySelector('#customFile').value;
                //console.log(file);
                if (file != "") {
                    document.querySelector('#custom-file-label').innerHTML = file;
                }
            }
                // Porcentagem em Tempo real
                let $range = document.querySelector('#range'),
                    $value = document.querySelector('#resultado');
                $range.addEventListener('input', function(){
                    $value.textContent = this.value+"%";
                });
            
        </script>
    </body>
</html>