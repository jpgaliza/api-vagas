<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Incluir arquivo de configuração
require_once 'config/database.php';
require_once 'classes/Vaga.php';

// Obter método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Obter URL e parâmetros de forma mais robusta
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_parts = explode('/', trim($uri, '/'));

// Debug - remover depois de testar
// echo json_encode(['uri' => $uri, 'uri_parts' => $uri_parts]); exit;

// Encontrar onde está "api-vagas" na URL
$api_index = array_search('api-vagas', $uri_parts);
if ($api_index !== false) {
    $endpoint = isset($uri_parts[$api_index + 1]) ? $uri_parts[$api_index + 1] : '';
    $id = isset($uri_parts[$api_index + 2]) ? $uri_parts[$api_index + 2] : '';
} else {
    // Fallback para URLs diretas
    $endpoint = isset($uri_parts[0]) ? $uri_parts[0] : '';
    $id = isset($uri_parts[1]) ? $uri_parts[1] : '';
}

// Se não houver endpoint, verificar query parameter
if (empty($endpoint) && isset($_GET['action'])) {
    $endpoint = $_GET['action'];
    $id = isset($_GET['id']) ? $_GET['id'] : '';
}

$vaga = new Vaga();

try {
    switch ($endpoint) {
        case 'vagas':
            switch ($method) {
                case 'GET':
                    if ($id) {
                        echo json_encode($vaga->buscarPorId($id));
                    } else {
                        echo json_encode($vaga->listarTodas());
                    }
                    break;

                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    echo json_encode($vaga->criar($data));
                    break;

                case 'PUT':
                    if ($id) {
                        $data = json_decode(file_get_contents('php://input'), true);
                        echo json_encode($vaga->atualizar($id, $data));
                    } else {
                        http_response_code(400);
                        echo json_encode(['erro' => 'ID da vaga é obrigatório']);
                    }
                    break;

                case 'DELETE':
                    if ($id) {
                        echo json_encode($vaga->deletar($id));
                    } else {
                        http_response_code(400);
                        echo json_encode(['erro' => 'ID da vaga é obrigatório']);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['erro' => 'Método não permitido']);
            }
            break;

        case 'candidaturas':
            require_once 'classes/Candidatura.php';
            $candidatura = new Candidatura();

            switch ($method) {
                case 'GET':
                    if ($id) {
                        echo json_encode($candidatura->buscarPorVaga($id));
                    } else {
                        echo json_encode($candidatura->listarTodas());
                    }
                    break;

                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    echo json_encode($candidatura->candidatar($data));
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['erro' => 'Método não permitido']);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['erro' => 'Endpoint não encontrado']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro interno do servidor: ' . $e->getMessage()]);
}
?>