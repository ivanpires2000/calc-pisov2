<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Cálculos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Histórico de Cálculos</h1>

        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Cômodo</th>
                    <th>Área do Ambiente (m²)</th>
                    <th>Área da Peça (m²)</th>
                    <th>Quantidade de Peças</th>
                    <th>Quantidade de Sacos de Argamassa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $historicoJSON = file_get_contents('historico.json');
                    $historicoArray = json_decode($historicoJSON, true);
                    
                    if (empty($historicoArray)) {
                        echo "<tr><td colspan='6'>Nenhum cálculo registrado.</td></tr>";
                    } else {
                        foreach ($historicoArray as $registro) {
                            echo "<tr>
                                    <td>{$registro['nomeCliente']}</td>
                                    <td>{$registro['comodo']}</td>
                                    <td>" . number_format($registro['areaAmbiente'], 2) . "</td>
                                    <td>" . number_format($registro['areaPeca'], 2) . "</td>
                                    <td>{$registro['numPecas']}</td>
                                    <td>{$registro['numSacosArgamassa']}</td>
                                  </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>

        <button onclick="window.location.href='index.php'">Voltar para o Formulário</button>
    </div>

    <footer>
        Copy © 2024 Ivan P. S. Ferreira
    </footer>

</body>
</html>
