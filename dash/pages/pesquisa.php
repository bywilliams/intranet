<?php
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$search = "";
if (strlen($_POST['search']) > 5)  {
    $search = $_POST['search'];
}else{
    $msg_error = "<h1>A pesquisa precisa ter mais de 5 caracteres</h1>";
}

if(empty($msg_error)):
    ?>
    <h1>Pesquisando...</h1>
    <p>Buscando resultados para <?= $search;?>:</p>
    <?php   
else:
    echo $msg_error;
endif;

?>