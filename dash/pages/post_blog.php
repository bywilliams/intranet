<?php 
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;
$id = $_SESSION["id"];

#trazendo as categorias para o input
$query_category = "SELECT * FROM cat_blog ORDER BY id ASC";
$result_category = $conn->query($query_category);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <?php include_once("../../helpers/url.php");?>
    <script src=" css/sweetalert.min.js"></script>
    <?php include_once("../../helpers/url.php");?>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">
    <script src="js/tinymce/tinymce.min.js"></script>
    
</head>

<body>
    <div class="container-fluid dashboard-content">

        <div class="row">

            <div class="col-xl-8 offset-xl-2 ">

                <form action="act_users/create_post.php" id="contact-form" method="post" role="form" enctype="multipart/form-data">

                    <div class="messages mb-3"><h1>Criar Post</h1></div>

                    <div class="controls">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email">Titulo do Post *</label>
                                    <input id="form_email" type="text" name="title" class="form-control"
                                        placeholder="coloque um titulo *" required="required">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email">Categoria</label>
                                    <select class="form-control" name="category" id="">
                                        <option value="">Selecione</option>   
<?php
                                        if ($result_category->num_rows > 0) {
                                           while ($rowCategory = $result_category->fetch_assoc()) {
                                                $id = $rowCategory['id'];
                                                $category_name = $rowCategory['category_name'];
                                                ?>
                                                <option value="<?=$id?>"><?=$category_name?></option>
                                                <?php
                                           }
                                        }else{
                                            echo "nada";
                                        }
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Imagem thumbnail</label>
                                    <input type="file" name="file" class="form-control" accept="image/png,image/jpeg,image/jpg" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="destaque" value="S">
                                        <label class="form-check-label" for="exampleCheck1">Destacar na home:</label>
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_message">Mensagem *</label>
                                    <textarea name="textarea" id="textarea" placeholder="escreva o texto aqui"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="sendPost" class="btn btn-success btn-send">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted">
                                    <strong>*</strong> Estes campos são obrigatórios.
                                </p>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <!-- /.8 -->

        </div>
        <!-- /.row-->
    </div>

    <script>
   
    tinymce.init({

        selector: 'textarea',
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        plugins: 'image code',
        image_advtab: true,
        forced_root_block: false,
        /* enable title field in the Image dialog*/
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
        /*
            URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
            images_upload_url: 'postAcceptor.php',
            here we add custom filepicker only to Image dialog
        */
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    /*
                      Note: Now we need to register the blob in TinyMCEs image blob
                      registry. In the next release this part hopefully won't be
                      necessary, as we are looking to handle it internally.
                    */
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                });
                reader.readAsDataURL(file);
            });

            input.click();
        },
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });
    </script>
</body>

</html>