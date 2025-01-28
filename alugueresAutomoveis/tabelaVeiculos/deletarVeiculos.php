<?php
include_once('../conexao.php');

if (isset($_GET['matricula'])) {
    $cod_Matricula = $_GET['matricula'];

    $query = "DELETE FROM veiculos WHERE cod_Matricula = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }

    $stmt->bind_param("i", $cod_Matricula);

    if ($stmt->execute()) {
        header("Location: formVeiculos.php?success=1");

    $stmt->close();
    }
}
$conexao->close();
?>
