<?php
include_once('../conexao.php');

if (isset($_GET['id'])) {
    $id_pagamento = $_GET['id'];

    $query = "DELETE FROM pagamentos WHERE id_Pagamento = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }

    $stmt->bind_param("i", $id_pagamento);

    if ($stmt->execute()) {
        header("Location: formPagamentos.php?success=1");

    $stmt->close();
    }
}
$conexao->close();
?>
