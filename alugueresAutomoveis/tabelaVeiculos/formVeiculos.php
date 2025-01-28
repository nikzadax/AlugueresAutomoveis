<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styleTabelas.css">
    <title>Inserir Veículos</title>

    <style>
        .centralizar {
            text-align: center;
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

<form action="../tabelaVeiculos/inserirVeiculos.php" method="POST" class="form-container">
    <div>
        <label for="cod_Matricula">Código de Matrícula</label>
        <input type="text" name="cod_Matricula" id="cod_Matricula" placeholder="12345" required>
    </div>

    <br>

    <div>
        <label for="tipoVeiculo">Tipo de veículo</label>
        <select name="tipo_Veiculo" id="tipoVeiculo" required>
            <option value="" class="centralizar">----- Selecione -----</option>

            <?php
            include '../conexao.php';
            $sql = "SELECT * FROM tipoveiculos";
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row["id_tipoVeiculo"]."'>".$row["veiculos"]."</option>";
                }
            } else {
                echo "<option value=''>Nenhum veículo encontrado</option>";
            }
            ?>

        </select>
    </div>

    <br>

    <div>
        <label for="marca">Marca</label>
        <input type="text" name="marca" id="marca" required>
    </div>

    <br>

    <div>
        <label for="modelo">Modelo</label>
        <input type="text" name="modelo" id="modelo" required>
    </div>

    <br>

    <div>
        <label for="ano">Ano</label>
        <input type="number" name="ano" id="ano" required>
    </div>

    <br>

    <div>
        <label for="quilometragem">Quilometragem</label>
        <input type="number" name="Quilometragem" id="quilometragem" required>
    </div>

    <br>

    <div>
        <label for="estado">Estado do veículo</label>
        <select name="estado" id="estado" required>
            <option value="" class="centralizar">----- Selecione -----</option>

            <?php
            include '../conexao.php';
            $sql = "SELECT * FROM estadoveiculos";
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

    <div>
        <label for="valor">Preço do veículo: </label>
        <input type="text" name="valorVeiculo" id="valor" required>
    </div>

    <br>

    <input type="submit" name="submit" id="submit" value="Enviar">
</form>

<div class="table-container">
    
    <div class="filter-buttons">
        <form method="GET" action="">
            <button type="submit" name="filter" value="true">Filtrar Veículos por Ano (2000-2024)</button>
        </form>

        <form method="GET" action="">
            <button type="submit" name="Disponivel" value="true">Filtrar estado 'Disponivel'</button>
        </form>

        <form method="GET" action="">
            <button type="submit" name="Alugado" value="true">Filtrar estado 'Alugado'</button>
        </form>

        <form method="GET" action="">
            <button type="submit" name="Manutencao" value="true">Filtrar estado 'Manutenção'</button>
        </form>

        <form method="GET" action="">
            <button type="submit" name="reset" value="true">Remover Filtro</button>
        </form>
    </div>

    <table border="1">
        <tr>
            <th>Matrícula</th>
            <th>Tipo de veículo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Ano</th>
            <th>Quilometragem</th>
            <th>Estado</th>
            <th>Valor do veículo</th>
            <th>...</th>
        </tr>

        <?php

        $sql = "SELECT * FROM veiculos";

        if (isset($_GET['filter']) && $_GET['filter'] == 'true') {
            $sql .= "WHERE ano >= 2000 AND ano <= 2024";
        }

        if (isset($_GET['Disponivel']) && $_GET['Disponivel'] == 'true') {
            $sql .= "WHERE estado = '1' ";
        }

        if (isset($_GET['Alugado']) && $_GET['Alugado'] == 'true') {
            $sql .= "WHERE estado = '2' ";
        }

        if (isset($_GET['Manutencao']) && $_GET['Manutencao'] == 'true') {
            $sql .= "WHERE estado = '3' ";
        }

        $result = $conexao->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["cod_Matricula"] . "</td>";
            echo "<td>" . $row["tipo_Veiculo"] . "</td>";
            echo "<td>" . $row["marca"] . "</td>";
            echo "<td>" . $row["modelo"] . "</td>";
            echo "<td>" . $row["ano"] . "</td>";
            echo "<td>" . $row["Quilometragem"] . "</td>";
            echo "<td>" . $row["estado"] . "</td>";
            echo "<td>" . $row["valorVeiculo"] . "</td>";
            echo "<td>";
            echo "<button class='icon-button' onclick=\"location.href='editarVeiculos.php?cod_Matricula=".$row['cod_Matricula']."'\"><i class='bi bi-pencil-square'></i></button>";
            echo "<button class='icon-button' onclick=\"if(confirm('Tem certeza que deseja excluir este veículo?')) location.href='deletarVeiculos.php?matricula=".$row['cod_Matricula']."'\"><i class='bi bi-trash'></i></button>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
