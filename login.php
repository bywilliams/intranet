<?php 

session_start();

require_once ("./conn/config.php");

// inicia as variaceis vazias
$username = $password = "";
$username_err = $password_err = "";

// checa se username e password foram preenchidos no sibmit
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = strtolower($_POST['username']);
    $password = md5($_POST['password']);
}else{
    // variaveis para checar os campos vieram vazios
    $username_err = "Preencha o campo de usuario";
    $password_err = "Preencha o campo de senha";
}

// echo $username."<br>";
// echo $password."<br>";
// echo $username_err."<br>";

// se os campos de erros estiverem vazios, entra no bloco de codigos para checar o usuario e senha
if (empty($username_err) && empty($password_err)) {
    //echo "Entrou aqui";
    $SQL = "SELECT id, nivel_usuario, password FROM usuarios WHERE username = '$username'";
    $result = $conn->query($SQL);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $senha = $row["password"];
            $nivel_user = $row["nivel_usuario"];
        }
    }

    //echo $senha."<br>";
    if ($password === $senha) {
        session_regenerate_id();
        $_SESSION["loggedin"] = TRUE;
        $_SESSION["name"] = $username;
        $_SESSION["id"] = $id;
        $_SESSION["nivel"] = $nivel_user;
        echo "Login efetuado, bem vindo ".$username. "!";
        header("location: ./dash/index.php");
    }else{
        echo "Usuario ou senha invalidos";
       
        header("location: ./index.php");
    }
}else{
    header("location: ./index.php");
}

$conn->close();

?>
