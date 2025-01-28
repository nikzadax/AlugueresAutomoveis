<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styleTabelas.css">
    <title>Inserir pagamentos</title>

    <style>
        .centralizar {
            text-align: center;
        }
        .hidden {
            display: none;
        }

        .table-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 14px;
            text-align: left;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 7px;
        }

        table th {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        .icon-button {
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }

        .icon-button .bi {
            font-size: 1.2em;
            color: #000;
        }

        .icon-button .bi:hover {
            color: #555;
        }

        .filter-buttons {
            margin-bottom: 20px;
        }

        .filter-buttons form {
            display: inline-block;
            margin-right: 10px;
        }

        .filter-buttons button {
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            border: 1px solid #000;
            background-color: #000;
            color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }

        .filter-buttons button:hover {
            background-color: #fff;
            color: #000;
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

<form action="../tabelaPagamentos/inserirPagamentos.php" method="POST" class="form-container">

    <!--- Select de id aluguer (tabela aluguer) -->
    <div>
        <label for="idAluguer"> Aluguer a pagar </label>
            <select name="id_Aluguer" id="idAluguer" required>
                <option value="" class="centralizar">-------- Selecione --------</option>
                <option value="" class="centralizar"> Nif ----- Matricula ----- Data aluguer ----- Data devolucao</option>
                
                <?php
                include '../conexao.php';
                $sql = "SELECT * FROM alugueres";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["id_Aluguer"]."'>".$row["nif_Cliente"]." - ".$row["cod_Matricula"]." - ".$row["data_aluguer"]." ".$row["data_devolucao"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum veículo encontrado</option>";
                }
                ?>

            </select>
            
        </div>

        <br>

        <!--- Select do estado pagamento -->
        <div>
            <label for="estadoP">Estado do pagamento</label>
            <select name="estadoPagamento" id="estadoP" required onchange="toggleFields()">
                <option value="">----- Selecione -----</option>
                
                <?php
                $sql = "SELECT * FROM estadopagamento";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["id_estado"]."'>".$row["estado"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum estado encontrado</option>";
                }
                ?>

            </select>
            
        </div>

        <br>

        <div id="dataPDiv">
            <label for="dataP">Data do pagamento</label>
            <input type="date" name="data_Pagamento" id="dataP">
            
        </div>

        <br>

        <div id="dataLimiteDiv" class="hidden">
            <label for="dataL">Data limite</label>
            <input type="date" name="data_Limite" id="dataL">
        </div>

        <br>

        <div id="multaDiv" class="hidden">
            <label for="multa">Multa</label>
            <input type="number" name="multa" id="multa">
            
        </div>

        <br>

        <div>
            <label for="valorP">valor do total do pagamento</label>
            <input type="number" name="valorPagamento" id="valorP" required>
            
        </div>

        <br>

        <input type="submit" name="submit" id="submit" value="Enviar">

    </form>

<div class="table-container">

    <div class="filter-buttons">
        <form method="GET" action="">
            <button type="submit" name="filter" value="true">Filtrar se ha multa</button>
        </form>
        <form method="GET" action="">
            <button type="submit" name="reset" value="true">Remover Filtro</button>
        </form>
    </div>

    <table border="1">
        <tr>
            <th>Aluguer</th>
            <th>Data do pagamento</th>
            <th>Data limite</th>
            <th>Valor do pagamento</th>
            <th>Multa</th>
            <th>Estado do pagamento</th>
            <th>Deletar/Editar</th>
        </tr>

        <?php
        
        $sql = "SELECT * FROM pagamentos";

        if (isset($_GET['filter']) && $_GET['filter'] == 'true') {
            $sql .= " WHERE data_Limite IS NOT NULL AND multa IS NOT NULL";
        }

        $result = $conexao->query($sql);
        
        while ($row = $result->fetch_assoc()) { 
                echo "<tr>";
                echo "<td>" . $row["id_Aluguer"] . "</td>";
                echo "<td>" . $row["data_Pagamento"] . "</td>";
                echo "<td>" . $row["data_Limite"] . "</td>";
                echo "<td>" . $row["valorPagamento"] . "</td>";
                echo "<td>" . $row["multa"] . "</td>";
                echo "<td>" . $row["estadoPagamento"] . "</td>";
                echo "<td>";

                echo "<button class='icon-button' onclick=\"location.href='editarPagamento.php?id=".$row['id_Pagamento']."'\"><i class='bi bi-pencil-square'></i></button>";
                echo "<button class='icon-button' onclick=\"if(confirm('Tem certeza que deseja excluir este cliente?')) location.href='deletarPagamento.php?id=".$row['id_Pagamento']."'\"><i class='bi bi-trash'></i></button>";

                echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>

    <script>
        function toggleFields() {
            const estado = document.getElementById('estadoP').value;
            const dataPDiv = document.getElementById('dataPDiv');
            const multaDiv = document.getElementById('multaDiv');

            if (estado === '2') {
                dataPDiv.classList.add('hidden');
                dataLimiteDiv.classList.remove('hidden');
                multaDiv.classList.remove('hidden');
            } else {
                dataPDiv.classList.remove('hidden');
                dataLimiteDiv.classList.add('hidden');
                multaDiv.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
