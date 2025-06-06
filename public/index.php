<?php

use Slim\Factory\AppFactory;
use App\Controllers\VagaController;
use App\Controllers\PessoaController;
use App\Controllers\CandidaturaController;

require __DIR__ . '/../vendor/autoload.php';

// Criar a aplicação Slim
$app = AppFactory::create();

// Middleware para parsing do JSON
$app->addBodyParsingMiddleware();

// Middleware para tratamento de erros
$app->addErrorMiddleware(true, true, true);

// Middleware para CORS (se necessário)
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// Rotas da API
$app->post('/vagas', [VagaController::class, 'create']);
$app->post('/pessoas', [PessoaController::class, 'create']);
$app->post('/candidaturas', [CandidaturaController::class, 'create']);
$app->get('/vagas/{id}/candidaturas/ranking', [CandidaturaController::class, 'getRanking']);

// Executar a aplicação
$app->run();
