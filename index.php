
<!doctype html>
<html lang="pt-br">

<head>
    <title>Login Intranet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" href="css/style.css">

    <script>
        function valida(){
            var username = document.getElementById('username');
            var password = document.getElementById('password');
    
            if (username.value == "" || password.value == "") {
                
                swal("Preencha o campo usuário e senha!");
                return false;
            }else{
                return true;
            }

        }
    </script>

</head>

<body>
    <section class="ftco-section login-body" style="background-color: teal !important; height: 100vh;">
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
                                    <button type="submit" name="btn_salvar"
                                        class="form-control btn btn-primary rounded submit px-3" onclick="return valida();" >Entrar</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-100 text-center">
                                        <a href="#">Esqueci a Senha</a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>