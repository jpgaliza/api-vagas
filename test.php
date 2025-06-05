<?php
// Arquivo de teste para verificar se a API está funcionando

header('Content-Type: application/json');

echo json_encode([
    'status' => 'OK',
    'message' => 'API de Vagas está funcionando!',
    'timestamp' => date('Y-m-d H:i:s'),
    'endpoints' => [
        'GET /api-vagas/vagas' => 'Listar todas as vagas',
        'GET /api-vagas/vagas/{id}' => 'Buscar vaga por ID',
        'POST /api-vagas/vagas' => 'Criar nova vaga',
        'PUT /api-vagas/vagas/{id}' => 'Atualizar vaga',
        'DELETE /api-vagas/vagas/{id}' => 'Remover vaga',
        'GET /api-vagas/candidaturas' => 'Listar candidaturas',
        'GET /api-vagas/candidaturas/{vaga_id}' => 'Listar candidaturas por vaga',
        'POST /api-vagas/candidaturas' => 'Candidatar-se a uma vaga'
    ]
]);
?>