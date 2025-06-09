<?php

namespace App\Controllers;
use App\Models\Vaga;
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

        $vagaModel = new Vaga();
        $result = $vagaModel->create($data);
        if ($result === true) {
            return $response->withStatus(201);
        } else {
            return $response->withStatus(422);
        }
    }
}
