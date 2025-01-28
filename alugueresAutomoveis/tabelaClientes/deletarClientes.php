<?php
include '../conexao.php';

if (isset($_GET['nif'])) {
    $nif = $_GET['nif'];

    $stmt = $conexao->prepare("DELETE FROM clientes WHERE nif = ?");
    $stmt->bind_param("s", $nif);

    if ($stmt->execute()) {
        header("Location: formClientes.php?success=1");
    } else {
        echo "Erro ao excluir o cliente: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "NIF não fornecido!";
}
?>
