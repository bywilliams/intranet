<?php
require_once ("../../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// PEGA ID DO USUARIO
$id = $_POST["id"];


if(isset($_POST["update"])):
    $nome_completo = $_POST["nome_update"];
    $email = $_POST["email_update"];
    $usuario = $_POST["usuario_update"];
    $password = $_POST["password_update"];
    $nivel = $_POST["nivel_update"];
    $imagem = "";
    $password_final = "";

    // PEGA A SENHA E A IMAGEM ATUAL DO USER 
    $SQL_Senha_crypt = "SELECT password, profile_img FROM usuarios WHERE id = ".$id;
    $result_senha_crypt = $conn->query($SQL_Senha_crypt);
    $profile_img = "";
    if ($result_senha_crypt->num_rows > 0) {
        while ($row = $result_senha_crypt->fetch_assoc()) {
            $password_atual = $row["password"];
            $imagem = $row["profile_img"];
        }
    }


    // CHECA SE O ARQUIVO EXISTE NO INPUT FILE IMAGEM_UPDATE
    if(file_exists($_FILES["imagem_update"]["tmp_name"])):
    
        $extensao = strtolower(substr($_FILES['imagem_update']['name'], -4)); // Pega nome da extensao do arquivo
        $nome_imagem = md5(time()) . $extensao; // define nome para o arquivo
        $diretorio = "../../images/"; // Define o diretorio para onde o arquivo vai ser enviado
        move_uploaded_file($_FILES['imagem_update']['tmp_name'], $diretorio.$nome_imagem); // efetua o upload
        $imagem = $nome_imagem;
        //echo $nome_imagem;
    endif;


    // CHECA SE HOUVE MUDANÇA NO INPUT DA SENHA
    if($password_atual == $password):
        echo "senhas conferem";
        $password_final = $password_atual;
    else:
        $password_final = md5($password);
    endif;


    $SQL_Update = "UPDATE usuarios
    SET
        username = '".$usuario."',
        password =  '".$password_final."',
        email =  '".$email."',
        nivel_usuario =   ".$nivel.",
        profile_img =  '".$imagem."',
        nome =  '".$nome_completo."'
    WHERE id = ".$id;


   // EXECUTA A QUERY
    if($result_update = mysqli_query($conn,$SQL_Update)):
        echo "<script>
        alert('Usuario atualizado com sucesso!'); location= '../usuarios.php';
        </script>";
    else:
        echo "error";
    endif;
endif;



?>
