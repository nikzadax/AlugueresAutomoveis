<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styleTabelas.css">
    <title>Inserir aluguer</title>

    <style>

        .dataDevolucao {
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
    <form action="../tabelaAlugueres/inserirAluguer.php" method="POST" class="form-container">
        <div>
        <label for="nif">Nif do cliente</label>
        <select name="nif_Cliente" id="nif" required>
                <option value="">Selecione o cliente</option>
                
                <?php
                include '../conexao.php';
                $sql = "SELECT * FROM clientes";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["nif"]."'>".$row["nif"]." ".$row["nome"]." ".$row["email"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum veículo encontrado</option>";
                }
                ?>

                

            </select>
        </div>

        <br>

        <div>
            <label for="codigoMatricula">Codigo da matricula: </label>
            <select name="cod_Matricula" id="codigoMatricula" required>
                <option value="">Selecione a matrícula</option>
                
                <?php
                include '../conexao.php';
                $sql = "SELECT cod_Matricula, tipo_Veiculo, marca, modelo, ano, Quilometragem, estado, valorVeiculo FROM veiculos";
                $result = $conexao->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row["cod_Matricula"]."'>".$row["cod_Matricula"]." ".$row["marca"]." ".$row["modelo"]."</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum veículo encontrado</option>";
                }
                ?>

            </select>
        </div>

        <br>

        <div>
            <label for="dataAluguer">Data de aluguer</label>
            <input type="date" name="data_aluguer" id="dataAluguer" required>
            
        </div>

        <br>

        <label> Já tem uma data para a devolução?</label>
        
        <br>

        <label for="radioNao">Não</label>
        <input type="radio" name="temDataDevolucao" id="radioNao" value="nao" onchange="ativarDataDevolucao()" checked>
        

        <label for="radioSim">Sim</label>
        <input type="radio" name="temDataDevolucao" id="radioSim" value="sim" onchange="ativarDataDevolucao()">
        

        <br>

        <div class="dataDevolucao" id="data_devolucao">
            <label for="data-Devolucao">Data de devolução</label>
            <input type="date" name="data_devolucao" id="data-Devolucao">
            
        </div>

        <br>

        <input type="submit" name="submit" id="submit" value="Enviar">

    </form>



<div class="table-container">

    <div class="filter-buttons">
        <form method="GET" action="">
            <button type="submit" name="filter" value="true">Filtrar Alugueres se há Data de Devolução</button>
        </form>
        <form method="GET" action="">
            <button type="submit" name="filter2" value="true">Filtrar se a Data de aluguer é de 2024</button>
        </form>
        <form method="GET" action="">
            <button type="submit" name="reset" value="true">Remover Filtro</button>
        </form>
    </div>

    <table border="1">
        <tr>
            <th>NIF</th>
            <th>Matrícula</th>
            <th>Data de Aluguer</th>
            <th>Data de Devolução</th>
            <th>...</th>
        </tr>

        <?php
        
        $sql = "SELECT * FROM alugueres";

        if (isset($_GET['filter']) && $_GET['filter'] == 'true') {
            $sql .= " WHERE data_devolucao IS NOT NULL ";
        }

        if (isset($_GET['filter2']) && $_GET['filter2'] == 'true') {
            $sql .= " WHERE data_Aluguer BETWEEN '2024-01-01' AND '2024-12-31' ";
        }

        $result = $conexao->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nif_Cliente"] . "</td>";
                echo "<td>" . $row["cod_Matricula"] . "</td>";
                echo "<td>" . $row["data_aluguer"] . "</td>";
                echo "<td>" . $row["data_devolucao"] . "</td>";
                echo "<td>";
                
                echo "<button class='icon-button' onclick=\"location.href='editarAlugueres.php?id_Aluguer=".$row['id_Aluguer']."'\"><i class='bi bi-pencil-square'></i></button>";
                echo "<button class='icon-button' onclick=\"if(confirm('Tem certeza que deseja excluir este cliente?')) location.href='deletarAlugueres.php?id=".$row['id_Aluguer']."'\"><i class='bi bi-trash'></i></button>";

                echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>

    <script>
        function ativarDataDevolucao() {
            var radioSim = document.getElementById('radioSim');
            var dataDevolucao = document.getElementById('data_devolucao');
            
            if (radioSim.checked) {
                dataDevolucao.style.display = 'block';
            } else {
                dataDevolucao.style.display = 'none';
                document.getElementById('data-Devolucao').value = '';
            }
            
        }

    </script>  
</body>
</html>