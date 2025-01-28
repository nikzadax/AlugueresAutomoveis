<?php
include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_Pagamento = $_POST['id_Pagamento'];
    $id_Aluguer = $_POST['id_Aluguer'];
    $data_Pagamento = $_POST['data_Pagamento'];
    $data_Limite = $_POST['data_Limite'];
    $valorPagamento = $_POST['valorPagamento'];
    $multa = $_POST['multa'];
    $estadoPagamento = $_POST['estadoPagamento'];

    if ($estadoPagamento == '2') {
        $data_Pagamento = null;
    } else {
        $data_Limite = null;
        $multa = null;
    }

    $stmt = $conexao->prepare("UPDATE pagamentos SET id_Aluguer = ?, data_Pagamento = ?, data_Limite = ?, valorPagamento = ?, multa = ?, estadoPagamento = ? WHERE id_Pagamento = ?");
    $stmt->bind_param("issdsii", $id_Aluguer, $data_Pagamento, $data_Limite, $valorPagamento, $multa, $estadoPagamento, $id_Pagamento);

    if ($stmt->execute()) {
        header("Location: formPagamentos.php?success=1");
        exit;
    } else {
        echo "Erro ao atualizar pagamento: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "Método de requisição inválido.";
    exit;
}
?>
