<?php

include_once('../conexao.php');

if(isset($_POST['submit'])) {

    $nif = $_POST['nif_Cliente'];
    $codigo = $_POST['cod_Matricula'];
    $dataA = $_POST['data_aluguer'];
    $dataD = isset($_POST['data_devolucao']) && !empty($_POST['data_devolucao']) ? $_POST['data_devolucao'] : NULL;
    
    if ($dataD === NULL) {
        $result = mysqli_query($conexao, "INSERT INTO alugueres (nif_Cliente, cod_Matricula, data_aluguer, data_devolucao) 
        VALUES ('$nif', '$codigo', '$dataA', NULL)");
    }else {
        $result = mysqli_query($conexao, "INSERT INTO alugueres (nif_Cliente, cod_Matricula, data_aluguer, data_devolucao) 
        VALUES ('$nif', '$codigo', '$dataA', '$dataD')");
    }

    header("Location: formAlugueres.php?success=1");

}
?>
