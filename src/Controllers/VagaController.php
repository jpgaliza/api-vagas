<?php

namespace App\Controllers;

use App\Models\Vaga;
use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VagaController
{
    public function create(Request $request, Response $response)
    {
        $contentType = $request->getHeaderLine('Content-Type');

        if (strpos($contentType, 'application/json') === false) {
            return $response->withStatus(400);
        }

        $body = $request->getBody()->getContents();
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->withStatus(400);
        }

        // Gerar UUID automaticamente se não foi fornecido
        if (!isset($data['id']) || empty($data['id'])) {
            $data['id'] = Validator::generateUUID();
        }

        $vagaModel = new Vaga();
        $result = $vagaModel->create($data);

        if ($result === true) {
            $response->getBody()->write(json_encode(['id' => $data['id']]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        } else {
            return $response->withStatus(422);
        }
    }
}
