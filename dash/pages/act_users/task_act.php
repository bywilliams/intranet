<?php 
require_once ("../../../conn/config.php");


if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ../error.php");
endif;

$id = $_SESSION['id'];

// echo $id;
    
if (isset($_POST["salvar"])):
   
    $task_name = $_POST["taskname"];
    $task_date = $_POST["taskDate"];
    $priority = $_POST["priority"];
    $task_to = $_POST["task_to"];
    
    // echo $task_name;
    // echo $task_date;
    // echo $priority;

    // ADM ADCIONA A TAREFA PARA ALGUEM, SE NAO PROPRIO USUARIO ADCIONA SUA TAREFA
    if (!empty($task_to)) {
        $SQL_Insert_Task = "INSERT INTO tb_task (
            cd_user,
            name_task,
            priority,
            status_task,
            dt_expired,
            created_at,
            designado_por)
            VALUE(
                ".$task_to.",
                '".$task_name."',
                ".$priority.",
                0,
                '".$task_date."',
                now(),
                ".$id."
            )";
    }else{
        $SQL_Insert_Task = "INSERT INTO tb_task (
            cd_user,
            name_task,
            priority,
            status_task,
            dt_expired,
            created_at)
            VALUE(
                ".$id.",
                '".$task_name."',
                ".$priority.",
                0,
                '".$task_date."',
                now()
            )";
    }

    // echo "<br> $SQL_INSERT";

    if($result_insert = mysqli_query($conn,$SQL_Insert_Task)):
        echo "<script> alert('Tarefa cadastrada com sucesso!'); location= '../tarefas.php'; </script>";
    else:
        echo "error";
    endif;      

endif;


// SE BOTAO ATUALIZAR NO SISTEMA FOR CLICADO
if ($_GET['action_atualiza'] == 1) {
    $task_id = $_GET['task_id'];
    //echo $task_id;
    $SQL_Atualiza_Task = "UPDATE tb_task SET status_task = 1 WHERE id = ".$task_id;
    //echo $SQL_Atualiza_Task;

    if($result_update = mysqli_query($conn,$SQL_Atualiza_Task)):
        echo "<script> alert('Status da tarefa Atualizada com sucesso!'); location= '../tarefas.php'; </script>";
    else:
        echo "error";
    endif;      

}


// SE BOTAO DELETAR TAREFA FOR CLICADO
if ($_GET["del_task"]):
    $task_id = $_GET["del_task"];
    $SQL_Delete_Task = "DELETE from tb_task WHERE id = ".$task_id;
    //echo $SQL_Delete_Task;

    if($result_delete = mysqli_query($conn,$SQL_Delete_Task)):
        echo "<script> alert('Tarefa Deletada com sucesso!'); location= '../tarefas.php'; </script>";
    else:
        echo "error";
    endif;    

endif;
?>