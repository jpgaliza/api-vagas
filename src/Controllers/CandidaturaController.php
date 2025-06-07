<?php

namespace App\Controllers;

use App\Models\Candidatura;
use App\Utils\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CandidaturaController
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

        $candidaturaModel = new Candidatura();
        $result = $candidaturaModel->create($data);

        if ($result === true) {
            $response->getBody()->write(json_encode(['id' => $data['id']]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        } elseif ($result === 'not_found') {
            return $response->withStatus(404);
        } else {
            return $response->withStatus(400);
        }
    }

    public function getRanking(Request $request, Response $response, array $args)
    {
        $idVaga = $args['id'];

        $candidaturaModel = new Candidatura();
        $ranking = $candidaturaModel->getRankingByVaga($idVaga);

        if ($ranking === false) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($ranking));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
