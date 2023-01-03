<?php 
require_once ("../../conn/config.php");
require_once ("inc/valida_guest.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;

$id = $_SESSION["id"];

$config_user = $_SERVER["HTTP_USER_AGENT"];

//Google news API
$url = 'https://newsapi.org/v2/top-headlines?sources=google-news-br&apiKey=27a753fdaaab471189742fb09cac21a3';

// INICIALIZANDO O CURL
$ch = curl_init($url);


curl_setopt($ch, CURLOPT_USERAGENT, $config_user);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_REFERER, $url);

$newsData = json_decode(curl_exec($ch));
curl_close($ch);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <?php include_once("../../helpers/url.php");?>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">
</head>

<body>
    
    <div class="container-fluid dashboard-content">
            <h1 class="mb-5">Notícias</h1>

            <?php
                $internet = fsockopen('www.google.com.br', 80);
                if (!$internet) {
                    echo "Você esta sem internet no momento, verifique a conexão e tente novamente";
                }else{
                    foreach ($newsData->articles as $news){
                    ?>
                    <div class="row d-flex justify-content-center align-items-center newsGrid">
                        <div class="col-md-4">
                            <img src="<?php echo $news->urlToImage ?>" alt="image google" title="google_image" width="300" height="300" style="border-radius: 10px">
                            <?php
                            if($news->author == true):
                                echo "<p>$news->author ";
                            else:
                                echo "<p>Não tem autor ";
                            endif;
                            $data_noticia = strtotime($news->publishedAt);
                            echo date('d/m/Y h:i', $data_noticia)."</p>";
                        
                            ?>
                            

                        </div>
                        <div class="col-md-6">
                            <h5><?=$news->title ?></h5>
                            <h6><?=$news->description ?></h6>
                            <p><?=$news->content ?></p>
                            <p><strong>Leia mais:</strong> <br /> <br /> 
                            <a href="<?=$news->url ?>" target="_blank"><button type="button" class="btn btn-outline-dark">Ir para a notícia</button></a></p>

                        </div>

                    </div>
                    <div class="spacer mb-5">
                            
                            </div>
            <?php
                    }
                }
                ?>
    </div>
</body>

</html>