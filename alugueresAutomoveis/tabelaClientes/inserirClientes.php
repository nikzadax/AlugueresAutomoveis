<?php

include_once('../conexao.php');

if(isset($_POST['submit'])) {

    $nome = $_POST['nome'];
    $nif = $_POST['nif'];
    $morada = $_POST['morada'];
    $contacto = $_POST['contacto'];
    $email = $_POST['email'];

    $result = mysqli_query($conexao, " INSERT INTO clientes (nome, nif, morada, contacto, email) 
    VALUES ('$nome', '$nif', '$morada', '$contacto', '$email')");

    header("Location: formClientes.php?success=1");
}
?>
