<?php 
require_once ("../../conn/config.php");
require_once ("act_users/email_send.php");


//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;
$id = $_SESSION["id"];



if (isset($_POST["sendmail"])) {
    //echo "entrou aqui";
    $para = $_POST['email_to'];
    $assunto = $_POST['subject'];
    $corpo = $_POST['textarea'];
   
    inc_envia_email($para, $assunto, $corpo); 
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <?php include_once("../../helpers/url.php");?>
    <script src="<?=$BASE_URL?>css/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$BASE_URL?>../css/bootstrap-icons-1.8.3/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?=$BASE_URL?>../css/style_local.css">
    <script src="<?=$BASE_URL?>js/tinymce/tinymce.min.js"></script>
    
</head>

<body>
    <div class="container-fluid dashboard-content">

        <div class="row">

            <div class="col-xl-8 offset-xl-2 ">

                <form id="contact-form" method="post" action="e-mail.php" role="form">

                    <div class="messages"></div>

                    <div class="controls">

                       
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Para *</label>
                                    <input id="form_email" type="email" name="email_to" class="form-control"
                                        placeholder="Entre com seu e-mail *" required="required"
                                        data-error="Valid email is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email">Assunto *</label>
                                    <input id="form_email" type="text" name="subject" class="form-control"
                                        placeholder="coloque um assunto *" required="required"
                                        data-error="Valid email is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email">Anexo</label>
                                    <input type="file" name="file" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_message">Message *</label>
                                    <textarea name="textarea" id="textarea" ></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" name="sendmail" class="btn btn-success btn-send" value="Enviar e-mail">
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