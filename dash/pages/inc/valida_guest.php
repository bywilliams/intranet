<?php
// session_start();

if (!empty($_SESSION["guest"])): 
    $hora_atual = time();
    $hora_acessou = $_SESSION['hora_acessou'];
    //echo "$hora_atual, acesso $hora_acessou";
    $tempo_online = $hora_atual - $hora_acessou;
    if ($tempo_online > 600):
        $query_delete_all = "DELETE FROM tb_task WHERE cd_user = ".$_SESSION['id'];
        $result_delete = mysqli_query($conn,$query_delete_all);
        $query_delete_projetos = "DELETE FROM projects WHERE user_id = ".$_SESSION['id'];
        $result_delete_projetos = mysqli_query($conn,$query_delete_projetos);
        unset($_SESSION["login"]);
        session_destroy();

        echo "<script>setTimeout(() => {
            window.location.reload(true);
            }, 45);</script>";
        header("location: index.php");  

    elseif(isset($_GET["loggout"])):
        $query_delete_tasks = "DELETE FROM tb_task WHERE cd_user = ".$_SESSION['id'];
        $result_delete_tasks = mysqli_query($conn,$query_delete_tasks);
        $query_delete_projetos = "DELETE FROM projects WHERE user_id = ".$_SESSION['id'];
        $result_delete_projetos = mysqli_query($conn,$query_delete_projetos);
        unset($_SESSION["login"]);
        session_destroy();
        header("location: index.php");

    endif;
else:
    if(isset($_GET["loggout"])):
        unset($_SESSION["login"]);
        session_destroy();
        header("location: index.php");
    endif;
endif;



?>