<script src="js/sweetalert.min.js"></script>

<?php
session_start();

if (!empty($_SESSION["guest"])): 
    $hora_atual = time();
    $hora_acessou = $_SESSION['hora_acessou'];
    //echo "$hora_atual, acesso $hora_acessou";
    $tempo_online = $hora_atual - $hora_acessou;
    if ($tempo_online > 100):
        // Querys
        $query_delete_tasks = "DELETE FROM tb_task WHERE cd_user = ".$_SESSION['id'];
        $query_delete_projetos = "DELETE FROM projects WHERE user_id = ".$_SESSION['id'];
        $query_delete_posts = "DELETE FROM post_blog WHERE user_id = ".$_SESSION['id'];
        $query_select_image_blog = "SELECT image FROM post_blog WHERE user_id = ".$_SESSION['id'];
        // Execução das querys
        $result_delete_posts = mysqli_query($conn,$query_delete_posts);
        $result_delete_projetos = mysqli_query($conn,$query_delete_projetos);
        $result_delete_tasks = mysqli_query($conn,$query_delete_tasks);
        
        //echo $query_select_image_blog. "<br>";
        $result_select_image_blog = $conn->query($query_select_image_blog);
        while ($row_image = $result_select_image_blog->fetch_assoc()) {
            $image = $row_image['image'];
            // Excluir imagens cadastradas pelo guest no blog e projetos
            $image_path_blog ='./blog/assets/posts/'.$image;
            $image_path_blog_thumb = './blog/assets/posts/thumbnail/'.$image;

            if (file_exists($image_path_blog)):
                echo "Existe <br>";
                //CHECA SE O ARQUIVO EXISTE NA PASTA DE ORIGEM| SE EXISTIR EXCLUI O ARQUIVO da pasta original e da thumbnail
                 if(file_exists($image_path_blog)):
                     (unlink($image_path_blog)) ? "Arquivo Deletado com sucesso" : "Houve algum erro no processo";
                 endif;
                 if(file_exists($image_path_blog_thumb)):
                     (unlink($image_path_blog_thumb)) ? "Arquivo Deletado com sucesso" : "Houve algum erro no processo";
                 endif;
            else:
                echo "arquivo não existe <br>";
            endif;
        }


        $query_select_image_project = "SELECT file_name FROM projects WHERE user_id = ".$_SESSION['id'];
        //echo $query_select_image_project. "<br>";
        $result_select_project_image = $conn->query($query_select_image_project);
        while ($row_image = $result_select_project_image->fetch_assoc()) {
            $image = $row_image['file_name'];

            echo $image."<br>";
            // Excluir imagens cadastradas pelo guest no blog e projetos
            $image_path_project ='./assets/img/portfolio/'.$image;

            if (file_exists($image_path_project)) {
                echo "diretorio projetos image existe <br>";
            }else{
                echo "diretorio projetos image não existe <br>";
            }

            if (file_exists($image_path_project)):
                echo "Existe <br>";
                //CHECA SE O ARQUIVO EXISTE NA PASTA DE ORIGEM| SE EXISTIR EXCLUI O ARQUIVO
                 if(file_exists($image_path_project)):
                     (unlink($image_path_project)) ? "Arquivo Deletado com sucesso" : "Houve algum erro no processo";
                 endif;
            else:
                echo "arquivo não existe <br>";
            endif;
        }

       
        $_SESSION["loggedin"] = false;
        unset($_SESSION["login"]);
        session_destroy();
    else:
        if(isset($_GET["loggout"])):
            //Querys
            $query_delete_tasks = "DELETE FROM tb_task WHERE cd_user = ".$_SESSION['id'];
            $query_delete_projetos = "DELETE FROM projects WHERE user_id = ".$_SESSION['id'];
            $query_delete_posts = "DELETE FROM post_blog WHERE user_id = ".$_SESSION['id'];
            $query_select_image_blog = "SELECT image FROM post_blog WHERE user_id = ".$_SESSION['id'];
            // Execução das querys
            $result_delete_tasks = mysqli_query($conn,$query_delete_tasks);
            $result_delete_projetos = mysqli_query($conn,$query_delete_projetos);
            $result_delete_posts = mysqli_query($conn,$query_delete_posts);

            //echo $query_select_image_blog. "<br>";
            $result_select_image_blog = $conn->query($query_select_image_blog);
            while ($row_image = $result_select_image_blog->fetch_assoc()) {
                $image = $row_image['image'];
                // Excluir imagens cadastradas pelo guest no blog e projetos
                $image_path_blog ='./blog/assets/posts/'.$image;
                $image_path_blog_thumb = './blog/assets/posts/thumbnail/'.$image;

                if (file_exists($image_path_blog)):
                    //echo "Existe <br>";
                    //CHECA SE O ARQUIVO EXISTE NA PASTA DE ORIGEM| SE EXISTIR EXCLUI O ARQUIVO
                    if(file_exists($image_path_blog)):
                        (unlink($image_path_blog)) ? "Arquivo Deletado com sucesso" : "Houve algum erro no processo";
                    endif;
                    if(file_exists($image_path_blog_thumb)):
                        (unlink($image_path_blog_thumb)) ? "Arquivo Deletado com sucesso" : "Houve algum erro no processo";
                    endif;
                else:
                    echo "arquivo não existe <br>";
                endif;
            }


            $query_select_image_project = "SELECT file_name FROM projects WHERE user_id = ".$_SESSION['id'];
            //echo $query_select_image_project. "<br>";
            $result_select_project_image = $conn->query($query_select_image_project);
            while ($row_image = $result_select_project_image->fetch_assoc()) {
                $image = $row_image['file_name'];

                echo $image."<br>";
                // Excluir imagens cadastradas pelo guest no blog e projetos
                $image_path_project ='./assets/img/portfolio/'.$image;

                if (file_exists($image_path_project)) {
                    echo "diretorio projetos image existe <br>";
                }else{
                    echo "diretorio projetos image não existe <br>";
                }

                if (file_exists($image_path_project)):
                    echo "Existe <br>";
                    //CHECA SE O ARQUIVO EXISTE NA PASTA DE ORIGEM| SE EXISTIR EXCLUI O ARQUIVO
                    if(file_exists($image_path_project)):
                        (unlink($image_path_project)) ? "Arquivo Deletado com sucesso" : "Houve algum erro no processo";
                    endif;
                else:
                    echo "arquivo não existe <br>";
                endif;
            }

            $_SESSION["loggedin"] = false;
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