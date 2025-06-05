<?php
header('Content-Type: application/json');

// Simular dados de uma vaga para teste
$data = [
    'titulo' => 'Desenvolvedor PHP Senior',
    'descricao' => 'Vaga para desenvolvedor PHP com experiência em Laravel',
    'empresa' => 'Tech Solutions',
    'localizacao' => 'São Paulo, SP',
    'salario' => 8000.00,
    'tipo_contrato' => 'CLT',
    'requisitos' => 'PHP, Laravel, MySQL, Git',
    'beneficios' => 'Vale alimentação, Plano de saúde'
];

// Fazer requisição POST para testar
$url = 'http://localhost/api-vagas/vagas.php';
$json_data = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_data)
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $http_code\n";
echo "Response: $response\n";

// Tentar decodificar e exibir de forma mais legível
$decoded = json_decode($response, true);
if ($decoded) {
    echo "\nResposta formatada:\n";
    echo json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
