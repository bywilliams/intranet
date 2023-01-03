<?php
require_once ("../../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// clicando em salvar(form cadastro) pega os inputs e efetua o upload do arquivo para  a pasta de destino
if(isset($_POST["salvar"])):
    
    $nome_completo = $_POST["nome"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $password = md5($_POST["password"]);
    $nivel = $_POST["nivel"];

    if(isset($_FILES['imagem'])):
		$extensao = strtolower(substr($_FILES['imagem']['name'], -4)); // Pega nome da extensao do arquivo
		$nome_imagem = md5(time()) . $extensao; // define nome para o arquivo
		$diretorio = "../../images/"; // Define o diretorio para onde o arquivo vai ser enviado

       // echo "$extensao , $nome_imagem";
		move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$nome_imagem); // efetua o upload
	endif;

    // exit();
    
    $SQL_Insert = "INSERT INTO usuarios (
        username, 
        password,
        email,
        nivel_usuario,
        profile_img,
        nome)
        VALUES(
            '".$usuario."',
            '".$password."',
            '".$email."',
            ".$nivel.",
            '".$nome_imagem."',
            '".$nome_completo."'          
        )
    ";

    //echo $SQL_Insert;
    if($result_insert = mysqli_query($conn,$SQL_Insert)):
        echo "<script>
        alert('Usuario cadastrado com sucesso!'); location= '../usuarios.php';
        </script>";
    else:
        echo "error";
    endif;            
endif;


?>
