<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styleTabelas.css">
    <title>Inserir Clientes</title>
    <style>
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

    <form action="../tabelaClientes/inserirClientes.php" method="POST" class="form-container">
        <div>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" required>
        </div>

        <br>

        <div>
            <label for="nif">Nif</label>
            <input type="number" name="nif" id="nif" placeholder="123456789" maxlength="9" required> 
        </div>

        <br>

        <div>
            <label for="morada">Morada</label>
            <input type="text" name="morada" id="morada" required>
            
        </div>

        <br>

        <div>
            <label for="contacto">Contacto</label>
            <input type="number" name="contacto" id="contacto" placeholder="123456789" maxlength="9" required>
            
        </div>

        <br>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="exemplo@gmail.com" required>
        </div>

        <br>

        <input type="submit" name="submit" id="submit" value="Enviar">

    </form>
<div class="table-container">

    <div class="filter-buttons">
        <form method="GET" action="">
            <button type="submit" name="decrescente" value="true">Filtrar nome por ordem Decrescente</button>
        </form>

        <form method="GET" action="">
            <button type="submit" name="reset" value="true">Remover Filtro</button>
        </form>
    </div>

    <table border="1">
        <tr>
            <th>Nome</th>
            <th>NIF</th>
            <th>Morada</th>
            <th>Contacto</th>
            <th>Email</th>
            <th>...</th>
        </tr>

        <?php
        include_once '../conexao.php';
        
        $sql = "SELECT * FROM clientes";

        if (isset($_GET['decrescente']) && $_GET['decrescente'] == 'true') {
            $sql .= " ORDER BY nome DESC";
        }

        $result = $conexao->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["nif"] . "</td>";
                echo "<td>" . $row["morada"] . "</td>";
                echo "<td>" . $row["contacto"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>";
                
                echo "<button class='icon-button' onclick=\"location.href='editarClientes.php?nif=".$row['nif']."'\"><i class='bi bi-pencil-square'></i></button>";
                echo "<button class='icon-button' onclick=\"if(confirm('Tem certeza que deseja excluir este cliente?')) location.href='deletarClientes.php?nif=".$row['nif']."'\"><i class='bi bi-trash'></i></button>";

                echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>
</body>
</html>
