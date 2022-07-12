<?php
require_once ("../../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// PEGA ID DO USUARIO
$id = $_GET["id"];

// PEGA NOME DA IMAGEM E CAMINHO
$img = $_GET["profile_img"];
$path ='../../images/'.$img;

// CHECA SE O ARQUIVO EXISTE NA PASTA DE ORIGEM| SE EXISTIR EXCLUI O ARQUIVO
if(file_exists($path)):
   (unlink($path)) ? "Arquivo Deletado com sucesso" : "Houve algum erro no processo";
else:
    echo "<script>
	alert('Ops, algo deu errado, arquivo não encontrado!');
	</script>";
endif;

// DELETE USUARIO DO BANCO
$SQL_Delete = "DELETE FROM usuarios WHERE id = '$id'";
if($result_insert = mysqli_query($conn,$SQL_Delete)):
    echo "<script>
	alert('Usuario excluído com sucesso!'); location= '../usuarios.php';
	</script>";
else:
    echo "error";
endif;      


?>