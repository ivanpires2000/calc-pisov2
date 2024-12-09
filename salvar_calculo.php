<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeCliente = $_POST['nomeCliente'];
    $larguraAmbiente = $_POST['larguraAmbiente'];
    $comprimentoAmbiente = $_POST['comprimentoAmbiente'];
    $larguraPeca = $_POST['larguraPeca'];
    $comprimentoPeca = $_POST['comprimentoPeca'];

    // Calcula a área do ambiente e das peças
    $areaAmbiente = $larguraAmbiente * $comprimentoAmbiente;
    $areaPeca = $larguraPeca * $comprimentoPeca;
    $numPecas = ceil($areaAmbiente / $areaPeca);

    // Cálculo de argamassa
    $areaCoberturaArgamassa = 4.5; // Área coberta por um saco de argamassa em m²
    $numSacosArgamassa = ceil($areaAmbiente / $areaCoberturaArgamassa);

    // Salva os dados em um arquivo JSON
    $historico = json_decode(file_get_contents('historico.json'), true) ?: [];

    $historico[] = [
        'nomeCliente' => $nomeCliente,
        'larguraAmbiente' => $larguraAmbiente,
        'comprimentoAmbiente' => $comprimentoAmbiente,
        'larguraPeca' => $larguraPeca,
        'comprimentoPeca' => $comprimentoPeca,
        'numPecas' => $numPecas,
        'numSacosArgamassa' => $numSacosArgamassa
    ];

    file_put_contents('historico.json', json_encode($historico, JSON_PRETTY_PRINT));

    // Redireciona para a página de histórico
    header('Location: historico.php');
    exit;
}
