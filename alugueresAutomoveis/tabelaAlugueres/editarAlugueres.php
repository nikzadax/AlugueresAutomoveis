<?php
include '../conexao.php';

if (isset($_GET['id_Aluguer'])) {
    $id_Aluguer = $_GET['id_Aluguer'];

    $stmt = $conexao->prepare("SELECT * FROM alugueres WHERE id_Aluguer = ?");
    $stmt->bind_param("s", $id_Aluguer);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $aluguer = $result->fetch_assoc();
    } else {
        echo "Aluguer não encontrado!";
        exit;
    }
    $stmt->close();
} else {
    echo "ID de Aluguer não fornecido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluguer</title>
    <link rel="stylesheet" href="../styleTabelas.css">

</head>
<body>
    
    <div class="navbar">
        <a href="../tabelaClientes/formClientes.php">Clientes</a>
        <a href="../tabelaVeiculos/formVeiculos.php">Veiculos</a>
        <a href="../tabelaAlugueres/formAlugueres.php">Alugueres</a>
        <a href="../tabelaPagamentos/formPagamentos.php">Pagamentos</a>
    </div>

    <form action="../tabelaAlugueres/atualizarAluguer.php" method="POST" class="form-container">

        <h2 class="centralizar">Atualizar Aluguer</h2>

        <input type="hidden" name="id_Aluguer" value="<?php echo $aluguer['id_Aluguer']; ?>">

        <div class="form-group">
            <label for="nif">NIF do Cliente</label>
            <select name="nif_Cliente" id="nif" required>
                <option value="">Selecione o cliente</option>
                
                <?php
                include '../conexao.php';
                $sql = "SELECT * FROM clientes";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $selected = ($row["nif"] == $aluguer['nif_Cliente']) ? "selected" : "";
                        echo "<option value='".$row["nif"]."' $selected>".$row["nif"]." ".$row["nome"]." ".$row["email"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum cliente encontrado</option>";
                }
                ?>

            </select>
        </div>

        <br>

        <div class="form-group">
            <label for="codigoMatricula">Código da Matrícula</label>
            <select name="cod_Matricula" id="codigoMatricula" required>
                <option value="">Selecione a matrícula</option>
                
                <?php
                include '../conexao.php';
                $sql = "SELECT cod_Matricula, tipo_Veiculo, marca, modelo, ano, Quilometragem, estado, valorVeiculo FROM veiculos";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $selected = ($row["cod_Matricula"] == $aluguer['cod_Matricula']) ? "selected" : "";
                        echo "<option value='".$row["cod_Matricula"]."' $selected>".$row["cod_Matricula"]." ".$row["marca"]." ".$row["modelo"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum veículo encontrado</option>";
                }
                ?>

            </select>
        </div>

        <br>

        <div class="form-group">
            <label for="data_aluguer">Data de Aluguer</label>
            <input type="date" class="form-control" id="data_aluguer" name="data_aluguer" value="<?php echo $aluguer['data_aluguer']; ?>" required>
        </div>

        <div class="form-group">
            <label> Já tem uma data para a devolução?</label>
            <br>
            <label for="radioNao">Não</label>
            <input type="radio" name="temDataDevolucao" id="radioNao" value="nao" onchange="ativarDataDevolucao()">
            <label for="radioSim">Sim</label>
            <input type="radio" name="temDataDevolucao" id="radioSim" value="sim" onchange="ativarDataDevolucao()" checked>
        </div>

        <div class="dataDevolucao" id="data_devolucao">
            <label for="data-Devolucao">Data de devolução</label>
            <input type="date" name="data_devolucao" id="data-Devolucao">
        </div>

        <input type="submit" class="btn btn-primary" value="Atualizar"></input>
    </form>

    <script>
        function ativarDataDevolucao() {
            var radioSim = document.getElementById("radioSim");
            var dataDevolucao = document.getElementById("data_devolucao");

            if (radioSim.checked) {
                dataDevolucao.style.display = "block";
            } else {
                dataDevolucao.style.display = "none";
            }
        }
    </script>

</body>
</html>

