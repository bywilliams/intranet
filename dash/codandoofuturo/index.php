<?php include_once('templates/header.php') ?>
<main>
    <div class="title-container">
        <h1>Blog Codando o Futuro</h1>
        <p>O seu blog de programação</p>
    </div>
    <div class="post-container">
        <!-- fazendo o backend do blog -->
        <?php foreach ($posts as $post) : ?>
            <div class="post-box">
                <!---- pegando a imagem  ---->
                <img src="<?= $BASE_URL ?>/img/<?= $post['img'] ?>" alt="<?= $post['title'] ?>">
                  <!---- pegando o Titulo do Post  ---->
                <h2 class="post-title">
                    <a href="<?php $BASE_URL ?>post.php?id=<?= $post['id'] ?>"> <?= $post['title'] ?></a>
                </h2>
                  <!---- pegando a descrição do post  ---->
                <p class="post-description"><?= $post['description'] ?></p>
                  <!---- pegando as tags do Post  ---->
                <div class="tags-container">
                    <?php foreach ($post['tags'] as $tag) : ?>
                        <a href=""><?= $tag ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</main>

<?php include_once('templates/footer.php') ?>