<?php
include '../conexao.php';

if (isset($_GET['nif'])) {
    $nif = $_GET['nif'];

    $stmt = $conexao->prepare("SELECT * FROM clientes WHERE nif = ?");
    $stmt->bind_param("s", $nif);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
    } else {
        echo "Cliente não encontrado!";
        exit;
    }
    $stmt->close();
} else {
    echo "NIF não fornecido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../styleTabelas.css">

    <style>
        .centralizar {
            text-align: center;
        }
    </style>

</head>
<body>
    
    <div class="navbar">
        <a href="../tabelaClientes/formClientes.php">Clientes</a>
        <a href="../tabelaVeiculos/formVeiculos.php">Veiculos</a>
        <a href="../tabelaAlugueres/formAlugueres.php">Alugueres</a>
        <a href="../tabelaPagamentos/formPagamentos.php">Pagamentos</a>
    </div>

    <form action="../tabelaClientes/atualizarClientes.php" method="POST" class="form-container">

    <h2 class="centralizar"> Atualizar clientes </h2>

        <input type="hidden" name="nif" value="<?php echo $cliente['nif']; ?>">

        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>" required>
        </div>

        <div class="form-group">
            <label for="morada">Morada</label>
            <input type="text" class="form-control" id="morada" name="morada" value="<?php echo $cliente['morada']; ?>" required>
        </div>

        <div class="form-group">
            <label for="contacto">Contacto</label>
            <input type="text" class="form-control" id="contacto" name="contacto" value="<?php echo $cliente['contacto']; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $cliente['email']; ?>" required>
        </div>

        <input type="submit" class="btn btn-primary" value="Atualizar"></input>
    </form>


</body>
</html>
