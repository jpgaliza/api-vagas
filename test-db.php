<?php
header('Content-Type: application/json');

require_once 'config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        // Testar se as tabelas existem
        $tables = [];

        // Verificar tabela vagas
        $query = "SHOW TABLES LIKE 'vagas'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $tables[] = 'vagas';

            // Contar registros
            $count_query = "SELECT COUNT(*) as total FROM vagas";
            $count_stmt = $conn->prepare($count_query);
            $count_stmt->execute();
            $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
            $tables['vagas_count'] = $count['total'];
        }

        // Verificar tabela candidaturas
        $query = "SHOW TABLES LIKE 'candidaturas'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $tables[] = 'candidaturas';

            // Contar registros
            $count_query = "SELECT COUNT(*) as total FROM candidaturas";
            $count_stmt = $conn->prepare($count_query);
            $count_stmt->execute();
            $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
            $tables['candidaturas_count'] = $count['total'];
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Conexão com banco de dados estabelecida',
            'database' => 'api_vagas',
            'tables' => $tables
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Falha na conexão com o banco de dados'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro: ' . $e->getMessage()
    ]);
}
?>