<?php
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_Aluguer']) && isset($_POST['nif_Cliente']) && isset($_POST['cod_Matricula']) && isset($_POST['data_aluguer'])) {
        $id_Aluguer = $_POST['id_Aluguer'];
        $nif_Cliente = $_POST['nif_Cliente'];
        $cod_Matricula = $_POST['cod_Matricula'];
        $data_aluguer = $_POST['data_aluguer'];

        if (isset($_POST['temDataDevolucao']) && $_POST['temDataDevolucao'] == "sim") {
            if (isset($_POST['data_devolucao']) && !empty($_POST['data_devolucao'])) {
                $data_devolucao = $_POST['data_devolucao'];
            } else {
                $data_devolucao = NULL;
            }
        } else {
            $data_devolucao = NULL;
        }

        $stmt = $conexao->prepare("UPDATE alugueres SET nif_Cliente = ?, cod_Matricula = ?, data_aluguer = ?, data_devolucao = ? WHERE id_Aluguer = ?");
        $stmt->bind_param("ssssi", $nif_Cliente, $cod_Matricula, $data_aluguer, $data_devolucao, $id_Aluguer);

        if ($stmt->execute()) {
            header("Location: formAlugueres.php?success=1");
            exit;
        } else {
            echo "Erro ao atualizar aluguer: " . $stmt->error;
        }

        $stmt->close();
        $conexao->close();
    } else {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
    }
} else {
    echo "Apenas solicitações POST são permitidas para este script.";
}
?>
