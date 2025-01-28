<?php
include '../conexao.php';

if (isset($_POST['cod_Matricula'])) {
    $cod_Matricula = $_POST['cod_Matricula'];
    $tipo_Veiculo = $_POST['tipo_Veiculo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $quilometragem = $_POST['quilometragem'];
    $estado = $_POST['estado'];
    $valorVeiculo = $_POST['valorVeiculo'];

    $query = "UPDATE veiculos SET tipo_Veiculo = ?, marca = ?, modelo = ?, ano = ?, Quilometragem = ?, estado = ?, valorVeiculo = ? WHERE cod_Matricula = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }

    $stmt->bind_param("ssssssss", $tipo_Veiculo, $marca, $modelo, $ano, $quilometragem, $estado, $valorVeiculo, $cod_Matricula);

    if ($stmt->execute()) {
        header("Location: formVeiculos.php?success=1");
    } else {
        echo "Erro ao atualizar o veículo: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "Código de Matrícula não fornecido!";
}
?>
