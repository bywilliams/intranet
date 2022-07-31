<?php


// detalhes da configuração com o banco de dados
$server = 'us-cdbr-east-06.cleardb.net';
$user = 'bd1514d39ae23d';
$password = '9bff942a';
$db = 'heroku_68d1784e4e5afd8';

//conexão com o banco de dados 
$conn = new mysqli($server, $user, $password, $db);

mysqli_query($conn, "SET NAMES 'utf8'");

if($conn === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}else{
    //echo "Sucesso";
}

// $conn->close();



?>