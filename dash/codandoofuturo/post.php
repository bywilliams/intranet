<?php include('templates/header.php'); ?>
<?php

// <!-- checando se conseguimos pegar o id do post  -->

// isset informa se a variável existe 
if(isset($_GET['id'])){

    $postId = $_GET['id'];
    $currentPost;

    //for para percorrer a lista com os posts 
    foreach($posts as $post){
        //se a variavel que acessa os indices da lista na posição 'id' for igual a variavel que recebeu o id conferido no inicio do if
        // então a variavel vazia currentPost recebe a variavel $post 
        if ($post['id'] == $postId) {
            $currentPost = $post;
        }
    }


}

?>
<h1><?= $currentPost['title'] ?></h1>
<?php include('templates/footer.php'); ?>