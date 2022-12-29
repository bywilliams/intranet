<?php


// detalhes da configuração com o banco de dados
$server = 'localhost';
$user = 'root';
$password = '';
$db = 'intranet';

//conexão com o banco de dados 
$conn = new mysqli($server, $user, $password, $db);

mysqli_query($conn, "SET NAMES 'utf8'");

if($conn === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}else{
    //echo "Sucesso";
}

//  $conn->close();



?>