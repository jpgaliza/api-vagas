<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'config/database.php';
require_once 'classes/Vaga.php';

$method = $_SERVER['REQUEST_METHOD'];
$vaga = new Vaga();

// Obter ID da URL se presente
$uri = $_SERVER['REQUEST_URI'];
$uri_parts = explode('/', trim($uri, '/'));
$id = '';

// Procurar por um número (ID) na URL
foreach ($uri_parts as $part) {
    if (is_numeric($part)) {
        $id = $part;
        break;
    }
}

// Se não encontrou ID na URL, verificar query parameter
if (empty($id) && isset($_GET['id'])) {
    $id = $_GET['id'];
}

try {
    switch ($method) {
        case 'GET':
            if ($id) {
                echo json_encode($vaga->buscarPorId($id));
            } else {
                echo json_encode($vaga->listarTodas());
            }
            break;
        case 'POST':
            $raw_input = file_get_contents('php://input');
            $data = json_decode($raw_input, true);

            // Verificar se o JSON é válido
            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode([
                    'sucesso' => false,
                    'erro' => 'JSON inválido: ' . json_last_error_msg()
                ]);
                break;
            }

            // Verificar se os dados foram recebidos
            if (empty($data)) {
                http_response_code(400);
                echo json_encode([
                    'sucesso' => false,
                    'erro' => 'Nenhum dado recebido'
                ]);
                break;
            }

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
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro interno do servidor: ' . $e->getMessage()]);
}
?>