<?php

include_once('../conexao.php');

if(isset($_POST['submit'])) {

    $codigo = $_POST['id_Aluguer'];
    $dataP = isset($_POST['data_Pagamento']) && !empty($_POST['data_Pagamento']) ? $_POST['data_Pagamento'] : NULL;
    $dataL = isset($_POST['data_Limite']) && !empty($_POST['data_Limite']) ? $_POST['data_Limite'] : NULL;
    $valorP = $_POST['valorPagamento'];
    $multa = isset($_POST['multa']) && !empty($_POST['multa']) ? $_POST['multa'] : NULL;
    $estado = $_POST['estadoPagamento'];

    $query = "INSERT INTO pagamentos (id_Aluguer, data_Pagamento, data_Limite, valorPagamento, multa, estadoPagamento) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($query);
    
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }

    $stmt->bind_param("issdss", $codigo, $dataP, $dataL, $valorP, $multa, $estado); 

    if ($stmt->execute()) {
        header("Location: formPagamentos.php?success=1");
    } else {
        echo "Erro ao inserir o pagamento: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
}
?>
