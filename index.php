
<!doctype html>
<html lang="pt-br">

<head>
    <title>Login Intranet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <!-- SWEET ALERT  -->
    <script src="js/sweetalert.min.js"></script>
    <!-- CSS LOCAL INDEX -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <section class="ftco-section login-body" style="background-color: #747474 !important; height: 100vh;">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(dash/images/logo.png);">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Login</h3>
                                </div>
                            </div>
                            <form action="login.php" class="signin-form" method="POST">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Usuario</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="laravel" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Senha</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="12345" required >
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="btn_salvar" class=" btn btn-outline-primary form-control rounded submit px-3" onclick="return valida();" >Entrar</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-100">
                                        <a href="#" onclick="return esqueciSenha();">Esqueci a Senha</a> | <a href="#" class=""  data-toggle="modal" data-target="#exampleModal"><strong>Inscrever-se</strong></a>
                                    </div>

                                </div>
                                <!-- <div class="row">
                                        <div class="col-md-12">
                                            <div class="container-fluid text-center">
                                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Inscrever-se</a>
                                            </div>
                                        </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Inscrever-se -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Increver-se</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Salvar Alterações</button>
                </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        function valida(){
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
    
            if (username == "") {
                swal("Preencha o campo usuário!");
                return false;
            }else if (password == "") {
                swal("Preencha o campo Senha!");
                return false;
            }else{
                return true;
            }

        }

        function esqueciSenha(){
            // var username = document.getElementById('username').value;
            // var password = document.getElementById('password').value;
    
                swal("Digite seu e-mail e clique em esqueci a senha!");

        }
    </script>


</body>

</html>