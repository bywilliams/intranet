<?php 

session_start();

require_once ("./conn/config.php");


// checa se username e passwrod foram pegos no submit 
if (!isset($_POST['username'], $_POST['password'])) {
    exit("Por favor preencha o campo de usuario e senha");
}

// Prepara o SQL para a execução 
if ($stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE username = ?")) {
    //defini qual é o placeholder que esta no select
    $stmt->bind_param("s", $_POST['username']);
    //executa a query
    $stmt->execute();

    // guarda a execução para checar se a conta existe no BD
    $stmt->store_result();

    // se a consulta SQL retornou resultados 
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // ao fim da linha achima a conta já existe 

        if($_POST['password'] === $password){
            // neste ponto a verificação foi um sucesso e tanto o username quando o passwrod existem
            // próximo passo criar a sessão

            session_regenerate_id();
            $_SESSION["loggedin"] = TRUE;
            $_SESSION["name"] = $_POST['username'];
            $_SESSION["id"] = $id;
            echo "Bem vindo ". $_SESSION["name"]. "!";
        }else{
            echo "Usuario ou senha invalidos";
        }

    }else{
        echo "Usuario ou senha invalidos";
    }

    $stmt->close();

}



?>
 