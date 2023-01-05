<script src="js/sweetalert.min.js"></script>

<?php
// session_start();

if (!empty($_SESSION["guest"])): 
    $hora_atual = time();
    $hora_acessou = $_SESSION['hora_acessou'];
    //echo "$hora_atual, acesso $hora_acessou";
    $tempo_online = $hora_atual - $hora_acessou;
    if ($tempo_online > 30):
        $query_delete_all = "DELETE FROM tb_task WHERE cd_user = ".$_SESSION['id'];
        $result_delete_tasks = mysqli_query($conn,$query_delete_all);
        $query_delete_projetos = "DELETE FROM projects WHERE user_id = ".$_SESSION['id'];
        $result_delete_projetos = mysqli_query($conn,$query_delete_projetos);
        $_SESSION["loggedin"] = false;
        unset($_SESSION["login"]);
        session_destroy();
        ?>
        <script>
            let timerInterval
            Swal.fire({
            title: 'Fechando!',
            html: 'Finalizando sessão aguarde.',
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            });
            setTimeout(function() {
            window.location.href = "index.php";
            }, 2000);
        </script>
        <?php
        exit();
    elseif(isset($_GET["loggout"])):
        $query_delete_tasks = "DELETE FROM tb_task WHERE cd_user = ".$_SESSION['id'];
        $result_delete_tasks = mysqli_query($conn,$query_delete_tasks);
        $query_delete_projetos = "DELETE FROM projects WHERE user_id = ".$_SESSION['id'];
        $result_delete_projetos = mysqli_query($conn,$query_delete_projetos);
        $_SESSION["loggedin"] = false;
        unset($_SESSION["login"]);
        session_destroy();
        echo "...";
        ?>
        <script>
            let timerInterval
            Swal.fire({
            title: 'Fechando!',
            html: 'Finalizando sessão aguarde.',
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            });
            setTimeout(function() {
            window.location.href = "index.php";
            }, 2000);
        </script>
        <?php
        exit();
        //header("location: index.php");
    endif;
else:
    if(isset($_GET["loggout"])):
        echo "...<br>";
        ?>
        <script>
            let timerInterval
            Swal.fire({
            title: 'Fechando!',
            html: 'Finalizando sessão aguarde.',
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
            });
            setTimeout(function() {
            window.location.href = "index.php";
            }, 2000);
        </script>
        <?php
        unset($_SESSION["login"]);
        session_destroy();
         exit();
       
    endif;
endif;



?>