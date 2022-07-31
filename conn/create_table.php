<?php


// detalhes da configuração com o banco de dados
$server = 'localhost';
$user = 'root';
$password = '';
$db = 'intranet';

//conexão com o banco de dados 
$conn = new mysqli($server, $user, $password, $db);

// criando tabela usuarios
$query = "CREATE TABLE usuarios(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    
)"; 

$conn->query($query);

if($conn === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

$conn->close();



?>