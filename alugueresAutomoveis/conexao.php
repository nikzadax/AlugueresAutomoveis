<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alugueresviaturas";

// Criar conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
?>
