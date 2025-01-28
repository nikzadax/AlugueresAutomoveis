<?php

include_once('../conexao.php');

if(isset($_POST['submit'])) {

    $codigo = $_POST['cod_Matricula'];
    $tipoDeVeiculo = $_POST['tipo_Veiculo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $quilometragem = $_POST['Quilometragem'];
    $estado = $_POST['estado'];
    $valor = $_POST['valorVeiculo'];

    $result = mysqli_query($conexao, "INSERT INTO veiculos (cod_Matricula, tipo_Veiculo, marca, modelo, ano, Quilometragem, estado, valorVeiculo) 
    VALUES ('$codigo', '$tipoDeVeiculo', '$marca', '$modelo', '$ano', '$quilometragem', '$estado', '$valor')");

    header("Location: formVeiculos.php?success=1");
}
?>
