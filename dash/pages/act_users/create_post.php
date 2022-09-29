<?php
require_once ("../../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;
$id_user = $_SESSION["id"];


# BD do heroku usa auto_increment de 10 em 10 
# pegamos o último registro caso tenha, para usa-lo como padrão na incrementação manual
$query_ultimo_id = "SELECT id FROM post_blog ORDER BY created_at DESC LIMIT 1";
//echo $query_ultimo_id;
$result_ultimo_id = $conn->query($query_ultimo_id);

$last_id = 0; #usada para a soma manual do auto incremento
$id = null; # variavel que será usada para receber o numero do ultimo id registrado, será usado para o auto incremento manual

if ($result_ultimo_id->num_rows > 0) {
    while ($row = $result_ultimo_id->fetch_assoc()){
        $last_id = $row["id"];
    }
}

//echo $last_id;

# dia e hora atual no timezone de SP
$timezone = new DateTimeZone('America/Sao_Paulo');
$agora = new DateTime('now', $timezone);
$data_atual = $agora->format('Y-m-d H:i:s');
//echo $data_atual;


# se enviarPost for clicado
if (isset($_POST["sendPost"]) && $_POST["sendPost"] != null) {
    //echo "entrou aqui";
   $title = $_POST["title"];
   $category = $_POST["category"];
   $texto = $_POST["textarea"];
   $destaque = $_POST["destaque"];

   
   if(isset($_FILES['file'])):
        $extensao = strtolower(substr($_FILES['file']['name'], -4)); // Pega nome da extensao do arquivo
        $nome_imagem = md5(time()) . $extensao; // define nome para o arquivo
        $diretorio = "../../pages/blog/assets/posts/"; // Define o diretorio para onde o arquivo vai ser enviado
        $thumb = "../../pages/blog/assets/posts/thumbnail/";

        $fullPath_image = $diretorio.$nome_imagem;
        $path_copy_destine = $thumb.$nome_imagem;	
        
        if (!file_exists($fullPath_image)) {
            //echo "entrou no if";
           move_uploaded_file($_FILES['file']['tmp_name'], $diretorio.$nome_imagem); // efetua o upload
            
           if (file_exists($fullPath_image)) {
               copy($fullPath_image, $path_copy_destine);
           }
        }
        
    endif;

   //echo "titulo: $title, categoria: $category, texto: $texto";
   
    if (empty($last_id)) {
        $id = 1;
    }else{
        $id = $last_id + 1;
    }

    $SQL_Insert_Post = "INSERT INTO post_blog (
    id,
    title_post, 
    image,
    message,
    category_id,
    user_id,
    main_post,
    created_at)
    VALUES(
        ".$id.",
        '".$title."',
        '".$nome_imagem."',
        '".$texto."',
        ".$category.",
        ".$id_user.",
        '".$destaque."',
        '".$data_atual."'          
    )";
    // echo $SQL_Insert_Post;
    // exit;
    if($result_Insert_Post = mysqli_query($conn,$SQL_Insert_Post)):
        echo "<script>
        alert('Post cadastrado com sucesso!'); location= '../post_blog.php';
        </script>";
    else:
        echo "error";
    endif;            
  
}

?>