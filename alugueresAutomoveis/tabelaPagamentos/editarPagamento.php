<?php
include '../conexao.php';

if (isset($_GET['id'])) {
    $id_Pagamento = $_GET['id'];

    $stmt = $conexao->prepare("SELECT * FROM pagamentos WHERE id_Pagamento = ?");
    $stmt->bind_param("i", $id_Pagamento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pagamento = $result->fetch_assoc();
    } else {
        echo "Pagamento não encontrado!";
        exit;
    }
    $stmt->close();
} else {
    echo "ID de pagamento não fornecido!";
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
    <title>Editar Pagamento</title>

    <style>
        .centralizar {
            text-align: center;
        }
        .hidden {
            display: none;
        }

        .form-container {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .form-container form {
            width: 50%;
            border: 1px solid #000;
            padding: 20px;
            background-color: #f2f2f2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container form .form-group {
            margin-bottom: 15px;
        }

        .form-container form label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container form input, .form-container form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #000;
            border-radius: 4px;
        }

        .form-container form input[type="submit"] {
            width: auto;
            background-color: #000;
            color: #fff;
            cursor: pointer;
        }

        .form-container form input[type="submit"]:hover {
            background-color: #444;
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

<br>

<div class="form-container">
    <form action="../tabelaPagamentos/atualizarPagamentos.php?id=<?php echo $id_Pagamento; ?>" method="POST">
        <h2 class="centralizar">Editar Pagamento</h2>

        <input type="hidden" name="id_Pagamento" value="<?php echo $pagamento['id_Pagamento']; ?>">

        <div class="form-group">
            <label for="idAluguer">Aluguer a pagar</label>
            <select name="id_Aluguer" id="idAluguer" required>
                <option value="" class="centralizar">-------- Selecione --------</option>
                <option value="" class="centralizar"> Nif ----- Matricula ----- Data aluguer ----- Data devolucao</option>
                
                <?php
                $sql = "SELECT * FROM alugueres";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $selected = $row["id_Aluguer"] == $pagamento['id_Aluguer'] ? "selected" : "";
                        echo "<option value='".$row["id_Aluguer"]."' $selected>".$row["nif_Cliente"]." - ".$row["cod_Matricula"]." - ".$row["data_aluguer"]." ".$row["data_devolucao"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum veículo encontrado</option>";
                }
                ?>
            </select>
        </div>

        <br>

        <div class="form-group">
            <label for="estadoP">Estado do pagamento</label>
            <select name="estadoPagamento" id="estadoP" required onchange="toggleFields()">
                <option value="">----- Selecione -----</option>
                
                <?php
                $sql = "SELECT * FROM estadopagamento";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $selected = $row["id_estado"] == $pagamento['estadoPagamento'] ? "selected" : "";
                        echo "<option value='".$row["id_estado"]."' $selected>".$row["estado"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum estado encontrado</option>";
                }
                ?>
            </select>
        </div>

        <br>

        <div id="dataPDiv" class="form-group">
            <label for="dataP">Data do pagamento</label>
            <input type="date" name="data_Pagamento" id="dataP" value="<?php echo $pagamento['data_Pagamento']; ?>">
        </div>

        <br>

        <div id="dataLimiteDiv" class="form-group hidden">
            <label for="dataL">Data limite</label>
            <input type="date" name="data_Limite" id="dataL" value="<?php echo $pagamento['data_Limite']; ?>">
        </div>

        <br>

        <div id="multaDiv" class="form-group hidden">
            <label for="multa">Multa</label>
            <input type="number" name="multa" id="multa" value="<?php echo $pagamento['multa']; ?>">
        </div>

        <br>

        <div class="form-group">
            <label for="valorP">Valor do total do pagamento</label>
            <input type="number" name="valorPagamento" id="valorP" value="<?php echo $pagamento['valorPagamento']; ?>" required>
        </div>

        <br>

        <input type="submit" value="Atualizar">
    </form>
</div>

<script>
    function toggleFields() {
        const estado = document.getElementById('estadoP').value;
        const dataPDiv = document.getElementById('dataPDiv');
        const dataP = document.getElementById('dataP');
        const dataLimiteDiv = document.getElementById('dataLimiteDiv');
        const dataL = document.getElementById('dataL');
        const multaDiv = document.getElementById('multaDiv');

        if (estado === '2') {
            dataP.value = '';
            dataP.setAttribute('disabled', 'disabled');
            dataP.removeAttribute('required');
            dataL.removeAttribute('disabled');
            dataL.setAttribute('required', 'required');
            dataLimiteDiv.classList.remove('hidden');
            multaDiv.classList.remove('hidden');
        } else {
            dataP.removeAttribute('disabled');
            dataP.setAttribute('required', 'required');
            dataL.value = '';
            dataL.setAttribute('disabled', 'disabled');
            dataLimiteDiv.classList.add('hidden');
            multaDiv.classList.add('hidden');
        }
    }

    toggleFields();
</script>

</body>
</html>
