<?php
include '../conexao.php';

if (isset($_POST['nif'])) {
    $nif = $_POST['nif'];
    $nome = $_POST['nome'];
    $morada = $_POST['morada'];
    $contacto = $_POST['contacto'];
    $email = $_POST['email'];

    $query = "UPDATE clientes SET nome = ?, morada = ?, contacto = ?, email = ? WHERE nif = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }

    $stmt->bind_param("sssss", $nome, $morada, $contacto, $email, $nif);

    if ($stmt->execute()) {
        header("Location: formClientes.php?success=1");
    } else {
        echo "Erro ao atualizar o cliente: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "NIF não fornecido!";
}
?>
