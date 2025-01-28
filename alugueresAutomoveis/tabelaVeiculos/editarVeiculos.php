<?php
include '../conexao.php';

if (isset($_GET['cod_Matricula'])) {
    $cod_Matricula = $_GET['cod_Matricula'];

    $stmt = $conexao->prepare("SELECT * FROM veiculos WHERE cod_Matricula = ?");
    $stmt->bind_param("s", $cod_Matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $veiculo = $result->fetch_assoc();
    } else {
        echo "Veículo não encontrado!";
        exit;
    }
    $stmt->close();
} else {
    echo "Código de Matrícula não fornecido!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styleTabelas.css">
    <title>Editar Veículo</title>

    <style>
        .centralizar {
            text-align: center;
        }

        .form-container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="../tabelaClientes/formClientes.php">Clientes</a>
    <a href="../tabelaVeiculos/formVeiculos.php">Veículos</a>
    <a href="../tabelaAlugueres/formAlugueres.php">Aluguéis</a>
    <a href="../tabelaPagamentos/formPagamentos.php">Pagamentos</a>
</div>

<form action="../tabelaVeiculos/atualizarVeiculos.php" method="POST" class="form-container">
    <h2 class="centralizar">Editar Veículo</h2>

    <input type="hidden" name="cod_Matricula" value="<?php echo $veiculo['cod_Matricula']; ?>">

    <div class="form-group">
        <label for="tipo_Veiculo">Tipo de veículo</label>
        <select name="tipo_Veiculo" id="tipo_Veiculo" class="form-control" required>
            <option value="" class="centralizar">----- Selecione -----</option>
            <?php
            include '../conexao.php';
            $sql = "SELECT * FROM tipoveiculos";
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = $row["id_tipoVeiculo"] == $veiculo["tipo_Veiculo"] ? 'selected' : '';
                    echo "<option value='" . $row["id_tipoVeiculo"] . "' $selected>" . $row["veiculos"] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhum veículo encontrado</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="marca">Marca</label>
        <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $veiculo['marca']; ?>" required>
    </div>

    <div class="form-group">
        <label for="modelo">Modelo</label>
        <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $veiculo['modelo']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ano">Ano</label>
        <input type="number" class="form-control" id="ano" name="ano" value="<?php echo $veiculo['ano']; ?>" required>
    </div>

    <div class="form-group">
        <label for="quilometragem">Quilometragem</label>
        <input type="number" class="form-control" id="quilometragem" name="quilometragem" value="<?php echo $veiculo['Quilometragem']; ?>" required>
    </div>

    <div class="form-group">
        <label for="estado">Estado do veículo</label>
        <select name="estado" id="estado" class="form-control" required>
            <option value="" class="centralizar">----- Selecione -----</option>
            <?php
            include '../conexao.php';
            $sql = "SELECT * FROM estadoveiculos";
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = $row["id_estado"] == $veiculo["estado"] ? 'selected' : '';
                    echo "<option value='" . $row["id_estado"] . "' $selected>" . $row["estado"] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhum estado encontrado</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="valorVeiculo">Preço do veículo</label>
        <input type="text" class="form-control" id="valorVeiculo" name="valorVeiculo" value="<?php echo $veiculo['valorVeiculo']; ?>" required>
    </div>

    <input type="submit" class="btn btn-primary" value="Atualizar">
</form>

</body>
</html>
