<?php

if (!empty($_SESSION["guest"])): 
    $hora_atual = time();
    $hora_acessou = $_SESSION['hora_acessou'];
    $tempo_online = $hora_atual - $hora_acessou;
    if ($tempo_online > 40):
        
        unset($_SESSION["login"]);
        
        session_destroy();
        echo "<script>setTimeout(() => {
            window.location.reload(true);
            }, 45000);</script>";
        // header("refresh: 1; url = ../../index.php");
        
        // header("refresh: 1; url = ../index.php");
        header("location: ../index.php");
        // exit();
        
    endif;
endif;

?>