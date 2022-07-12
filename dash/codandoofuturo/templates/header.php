<?php include_once("helpers/url.php");?>
<?php include_once("data/categories.php");?>
<?php include_once("data/posts.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--- estilos do projeto -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>/css/styles.css">
    <!---- fonts do projeto --->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600&display=swap" rel="stylesheet">

    <title>Blog Codando o Futuro 💻</title>
</head>
<body>
    <header>
        <a href="<?= $BASE_URL ?>" id="logo">
            <img src="<?= $BASE_URL ?>/img/logo.svg" alt="Blog Codar">
        </a>
        <nav>
            <ul id="navbar">
                <li><a href="<?= $BASE_URL ?>" class="nav_link">Home</a></li>
                <li><a href="#" class="nav_link">Categorias</a></li>
                <li><a href="#" class="nav_link">Sobre</a></li>
                <li><a href="<?= $BASE_URL ?>/contact.php" class="nav_link">Contato</a></li>
            </ul>
            
        </nav>
    </header>