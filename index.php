<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Pisos e Revestimentos</title>
    <style>
        /* Estilo para a página index.php */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .layout {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            max-width: 1200px;
            width: 100%;
            margin: 20px auto;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input, select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }

        button {
            padding: 10px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        #resultado {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }

        canvas {
    margin-top: 20px;
    border: 2px solid #ddd;
    display: block;
    width: 100%;
    height: auto;
    max-width: 500px;
    margin: 20px auto;
}

        .qr-container {
            margin-top: 20px;
            text-align: center;
        }

        .qr-container img {
            width: 200px; /* Ajustado para um tamanho mais adequado */
            height: auto;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
            padding: 10px 0;
            background-color: #fff;
            width: 100%;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

    <div class="layout">
        <div class="container">
            <h1>Calculadora de Pisos e Revestimentos</h1>

            <form id="calcForm" action="index.php" method="POST">
                <label for="nomeCliente">Nome do Cliente:</label>
                <input type="text" id="nomeCliente" name="nomeCliente" required>

                <label for="larguraAmbiente">Largura do Ambiente (m):</label>
                <input type="number" id="larguraAmbiente" name="larguraAmbiente" step="0.01" required>

                <label for="comprimentoAmbiente">Comprimento do Ambiente (m):</label>
                <input type="number" id="comprimentoAmbiente" name="comprimentoAmbiente" step="0.01" required>

                <label for="larguraPeca">Largura da Peça de Cerâmica (m):</label>
                <input type="number" id="larguraPeca" name="larguraPeca" step="0.01" required>

                <label for="comprimentoPeca">Comprimento da Peça de Cerâmica (m):</label>
                <input type="number" id="comprimentoPeca" name="comprimentoPeca" step="0.01" required>

                <label for="comodo">Escolha o Cômodo:</label>
                <select id="comodo" name="comodo" required>
                    <option value="">Selecione um cômodo</option>
                    <option value="sala">Sala de Estar</option>
                    <option value="cozinha">Cozinha</option>
                    <option value="banheiro">Banheiro</option>
                    <option value="quarto">Quarto</option>
                    <option value="varanda">Varanda</option>
                </select>

                <button type="submit" name="calcular">Calcular</button>
                <button type="button" onclick="window.location.href='historico.php'">Histórico</button>
            </form>

            <h2 id="resultado">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcular'])) {
                        $nomeCliente = $_POST['nomeCliente'];
                        $larguraAmbiente = $_POST['larguraAmbiente'];
                        $comprimentoAmbiente = $_POST['comprimentoAmbiente'];
                        $larguraPeca = $_POST['larguraPeca'];
                        $comprimentoPeca = $_POST['comprimentoPeca'];
                        $comodo = $_POST['comodo'];

                        // Calcula a área do ambiente e das peças
                        $areaAmbiente = $larguraAmbiente * $comprimentoAmbiente;
                        $areaPeca = $larguraPeca * $comprimentoPeca;
                        $numPecas = ceil($areaAmbiente / $areaPeca);

                        // Cálculo de argamassa
                        $areaCoberturaArgamassa = 4.5;
                        $numSacosArgamassa = ceil($areaAmbiente / $areaCoberturaArgamassa);

                        echo "Cliente: $nomeCliente<br>";
                        echo "Cômodo: $comodo<br>";
                        echo "Área do Ambiente: " . number_format($areaAmbiente, 2) . " m²<br>";
                        echo "Área da Peça: " . number_format($areaPeca, 2) . " m²<br>";
                        echo "Você precisará de aproximadamente $numPecas peças de cerâmica.<br>";
                        echo "Você precisará de aproximadamente $numSacosArgamassa sacos de argamassa de 20kg.";

                        // Armazenar no histórico
                        $historico = [
                            'nomeCliente' => $nomeCliente,
                            'comodo' => $comodo,
                            'areaAmbiente' => $areaAmbiente,
                            'areaPeca' => $areaPeca,
                            'numPecas' => $numPecas,
                            'numSacosArgamassa' => $numSacosArgamassa
                        ];

                        // Salvar no arquivo JSON ou banco de dados
                        $historicoJSON = file_get_contents('historico.json');
                        $historicoArray = json_decode($historicoJSON, true);
                        $historicoArray[] = $historico;
                        file_put_contents('historico.json', json_encode($historicoArray, JSON_PRETTY_PRINT));
                    }
                ?>
            </h2>

            <canvas id="canvas" width="500" height="500"></canvas>
            <script>
                // Função para desenhar no canvas
                const canvas = document.getElementById('canvas');
                const ctx = canvas.getContext('2d');

                // Função para desenhar um retângulo representando a área do ambiente e das peças
                function desenhar() {
                    const larguraAmbiente = <?php echo isset($_POST['larguraAmbiente']) ? $_POST['larguraAmbiente'] : 0; ?>;
                    const comprimentoAmbiente = <?php echo isset($_POST['comprimentoAmbiente']) ? $_POST['comprimentoAmbiente'] : 0; ?>;
                    const larguraPeca = <?php echo isset($_POST['larguraPeca']) ? $_POST['larguraPeca'] : 0; ?>;
                    const comprimentoPeca = <?php echo isset($_POST['comprimentoPeca']) ? $_POST['comprimentoPeca'] : 0; ?>;

                    if (larguraAmbiente && comprimentoAmbiente) {
                        // Desenha o ambiente
                        ctx.fillStyle = '#e0e0e0';
                        ctx.fillRect(50, 50, larguraAmbiente * 50, comprimentoAmbiente * 50);

                        // Desenha as peças dentro do ambiente
                        ctx.fillStyle = '#008000';
                        for (let i = 0; i < Math.ceil(larguraAmbiente / larguraPeca); i++) {
                            for (let j = 0; j < Math.ceil(comprimentoAmbiente / comprimentoPeca); j++) {
                                ctx.fillRect(50 + (i * larguraPeca * 50), 50 + (j * comprimentoPeca * 50), larguraPeca * 50, comprimentoPeca * 50);
                            }
                        }
                    }
                }

                // Chama a função para desenhar
                desenhar();
            </script>

        </div>

        <div class="qr-container">
            <h2>Doação via Pix</h2>
            <p>Me ajude a continuar criando conteúdo de qualidade</p>
            <p>Chave Pix: 11 94028-0808</p>
            <img src="/qr-ivan.jpg" alt="QR Code para doação via Pix">
        </div>
    </div>

    <footer>
        Copy © 2024 Ivan P. S. Ferreira
    </footer>

</body>
</html>
