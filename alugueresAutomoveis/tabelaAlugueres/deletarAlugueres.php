<?php
include_once('../conexao.php');

if (isset($_GET['id'])) {
    $id_Aluguer = $_GET['id'];

    $query = "DELETE FROM alugueres WHERE id_Aluguer = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }

    $stmt->bind_param("i", $id_Aluguer);

    if ($stmt->execute()) {
        header("Location: formAlugueres.php?success=1");

    $stmt->close();
    }
}
$conexao->close();
?>
