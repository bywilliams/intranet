<?php

require_once ("../../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ../error.php");
endif;

# trazendo as categorias para o input
$query_category = "SELECT * FROM cat_blog ORDER BY id ASC";
$result_category = $conn->query($query_category);

# traz as noticias destaques
$query_main_post = "SELECT * FROM post_blog WHERE main_post = 'S' ORDER BY created_at DESC LIMIT 2";
$result_main_post = $conn->query($query_main_post);
//echo $query_main_post;


# traz as noticias normais
$query_noticias = "SELECT * FROM post_blog WHERE main_post <> 'S' OR main_post IS NULL";
$result_noticias = $conn->query($query_noticias); 


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blog Home - Developing the future</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <!-- Font Aewsome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<style>
.img-wrapper {
    max-width: 100%;
    /* height: 65vw; */
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

img {
    max-width: 100%;
    max-height: 100%;
}

@media screen and (min-width: 576px) {
    .carousel-inner {
        display: flex;
    }

    .carousel-item {
        display: block;
        margin-right: 0;
        flex: 0 0 calc(100% / 3);
    }

    /* .img-wrapper {
    height: 21vw;
  } */
}

.carousel-inner {
    padding: 1em;
}

.card {
    margin: 0 0.5em;
    border-radius: 0;
    box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
    font-size: 0.9em;
}

.carousel-control-prev,
.carousel-control-next {
    width: 6vh;
    height: 6vh;
    background-color: #e1e1e1;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.5;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    opacity: 0.8;
}
</style>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#!"><img src="assets/logo.png" width="50" height="50" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li clas=""><input class="form-control" type="text" placeholder="Pesquise algo..."</li>
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Sobre</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="#!">Contato</a></li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page header with logo and tagline-->
    <header class="py-5 bg-light border-bottom mb-4 banner-home">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder text-white">Bem vindo ao Developing The Future!</h1>
                <!-- <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p> -->
            </div>
        </div>
    </header>
    <!-- Page content-->
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="card mb-4" style="border: none; box-shadow: none;">
                    <div id="carouselExampleControls" class="carousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php 
                            if ($result_main_post->num_rows > 0) {
                                while ($row_main_post = $result_main_post->fetch_assoc()){
                                        $id = $row_main_post['id'];
                                        $title = $row_main_post['title_post'];
                                        $image = $row_main_post['image'];
                                        $message = $row_main_post['message'];
                                        $category = $row_main_post['category_id'];
                                        $user_id = $row_main_post['user_id'];
                                        $created_at = $row_main_post['created_at'];

                                        //echo $image;
                                    ?>

                            <div class="carousel-item active">
                                <div class="card">
                                    <div class="img-wrapper">
                                        <img src="assets/posts/thumbnail/<?=$image?>" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?=$title?></h5>
                                        <p class="card-text" <?=$message?></p>
                                        <p>Data do post: <?=$created_at?> </p>
                                        <a href="#" class="btn btn-primary">Leia mais</a>
                                    </div>
                                </div>
                            </div>

                            <!-- <a href="#!"><img class="card-img-top" src="assets/posts/thumbnail/<?=$image?>" width="850" height="350" alt="..." /></a>
                                    <div class="card-body">
                                        <div class="small text-muted"><?=$created_at?>&nbsp;<span>Autor: William</span></div>
                                        <h2 class="card-title"><?=$title?></h2>
                                        <p class="card-text"><?=$message?></p>
                                        <a class="btn btn-primary" href="#!">Leia mais →</a>
                                    </div> -->
                            <?php
                                }
                            }
                        ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <!-- Featured blog post-->
                
                <!-- Nested row for non-featured blog posts-->
                <div class="row">

                    <?php 
                            if ($result_noticias->num_rows > 0) {
                                while ($row_noticias = $result_noticias->fetch_assoc()) {
                                    $title = $row_noticias['title_post'];
                                    $image = $row_noticias['image'];
                                    $message = $row_noticias['message'];
                                    $created_at = $row_noticias['created_at'];

                                     //echo $message;
?>
                    <div class="col-lg-4">
                        <!-- Blog post-->
                        <div class="card mb-4">
                            <a href="#!"><img class="card-img-top" src="assets/posts/thumbnail/<?=$image?>"
                                    width="200px" height="250px" alt="..." /></a>
                            <div class="card-body">
                                <div class="small text-muted"><?=$created_at?></div>
                                <h2 class="card-title h4"><?=$title?></h2>
                                <p class="card-text"><?=$message?></p>
                                <a class="btn btn-primary" href="#!">Leia mais →</a>
                            </div>
                        </div>
                        <!-- Blog post-->
                    </div>
                    <?php
                                }
                            }
?>


                </div>
                <!-- Pagination-->
                <nav aria-label="Pagination">
                    <hr class="my-0" />
                    <ul class="pagination justify-content-center my-4">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"
                                aria-disabled="true">Novo</a></li>
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                        <li class="page-item"><a class="page-link" href="#!">2</a></li>
                        <li class="page-item"><a class="page-link" href="#!">3</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                        <li class="page-item"><a class="page-link" href="#!">15</a></li>
                        <li class="page-item"><a class="page-link" href="#!">Antigo</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4">
                <!-- Search widget-->
                <!-- <div class="card mb-4">
                    <div class="card-header">Busca</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Pesquise algo..."
                                aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Vai!</button>
                        </div>
                    </div>
                </div> -->
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categorias</div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                                $p = 1;
                                if ($result_category->num_rows > 0) {
                                    while ($row = $result_category->fetch_assoc()){
                                        $id = $row['id'];
                                        $category_name = $row['category_name'];
                                        if ($p <= 4) {
                                            ?>
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!"><?=$category_name?></a></li>
                                </ul>
                            </div>
                            <?php
                                        }else{
                                            ?>
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!"><?=$category_name?></a></li>
                                </ul>
                            </div>
                            <?php
                                        }
                                        ?>

                            <?php
                                    }
                                }
?>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to
                        use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Developing The Future 2022</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <script>
    const multipleItemCarousel = document.querySelector("#carouselExampleControls");

    if (window.matchMedia("(min-width:576px)").matches) {
        const carousel = new bootstrap.Carousel(multipleItemCarousel, {
            interval: false
        });

        var carouselWidth = $(".carousel-inner")[0].scrollWidth;
        var cardWidth = $(".carousel-item").width();

        var scrollPosition = 0;

        $(".carousel-control-next").on("click", function() {
            if (scrollPosition < carouselWidth - cardWidth * 4) {
                console.log("next");
                scrollPosition = scrollPosition + cardWidth;
                $(".carousel-inner").animate({
                    scrollLeft: scrollPosition
                }, 600);
            }
        });
        $(".carousel-control-prev").on("click", function() {
            if (scrollPosition > 0) {
                console.log("prev");
                scrollPosition = scrollPosition - cardWidth;
                $(".carousel-inner").animate({
                    scrollLeft: scrollPosition
                }, 600);
            }
        });
    } else {
        $(multipleItemCarousel).addClass("slide");
    }
    </script>
</body>

</html>