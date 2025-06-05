<?php
require_once 'config/database.php';

class Candidatura
{
    private $conn;
    private $table_name = "candidaturas";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listarTodas()
    {
        $query = "SELECT 
                    c.id, c.vaga_id, c.nome_candidato, c.email, 
                    c.telefone, c.data_candidatura, c.status,
                    v.titulo as vaga_titulo, v.empresa
                  FROM " . $this->table_name . " c
                  LEFT JOIN vagas v ON c.vaga_id = v.id
                  ORDER BY c.data_candidatura DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $candidaturas = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $candidaturas[] = $row;
        }

        return [
            'sucesso' => true,
            'dados' => $candidaturas,
            'total' => count($candidaturas)
        ];
    }

    public function buscarPorVaga($vaga_id)
    {
        $query = "SELECT 
                    c.id, c.nome_candidato, c.email, c.telefone, 
                    c.data_candidatura, c.status, c.curriculo
                  FROM " . $this->table_name . " c
                  WHERE c.vaga_id = ?
                  ORDER BY c.data_candidatura DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $vaga_id);
        $stmt->execute();

        $candidaturas = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $candidaturas[] = $row;
        }

        return [
            'sucesso' => true,
            'dados' => $candidaturas,
            'total' => count($candidaturas)
        ];
    }
    public function candidatar($data)
    {
        // Validação mais precisa
        if (
            !isset($data['vaga_id']) || !isset($data['nome_candidato']) || !isset($data['email']) ||
            trim($data['vaga_id']) === '' || trim($data['nome_candidato']) === '' || trim($data['email']) === ''
        ) {
            return [
                'sucesso' => false,
                'erro' => 'Vaga ID, nome e email são obrigatórios'
            ];
        }

        // Verificar se a vaga existe e está ativa
        $vaga_query = "SELECT id FROM vagas WHERE id = ? AND status = 'ativa'";
        $vaga_stmt = $this->conn->prepare($vaga_query);
        $vaga_stmt->bindParam(1, $data['vaga_id']);
        $vaga_stmt->execute();

        if ($vaga_stmt->rowCount() == 0) {
            return [
                'sucesso' => false,
                'erro' => 'Vaga não encontrada ou inativa'
            ];
        }

        // Verificar se já existe candidatura do mesmo email para a mesma vaga
        $check_query = "SELECT id FROM " . $this->table_name . " WHERE vaga_id = ? AND email = ?";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(1, $data['vaga_id']);
        $check_stmt->bindParam(2, $data['email']);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            return [
                'sucesso' => false,
                'erro' => 'Você já se candidatou para esta vaga'
            ];
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  (vaga_id, nome_candidato, email, telefone, curriculo, data_candidatura, status) 
                  VALUES 
                  (:vaga_id, :nome_candidato, :email, :telefone, :curriculo, NOW(), 'pendente')";
        $stmt = $this->conn->prepare($query);

        // Criar variáveis para evitar erro de referência
        $vaga_id = $data['vaga_id'];
        $nome_candidato = $data['nome_candidato'];
        $email = $data['email'];
        $telefone = isset($data['telefone']) ? $data['telefone'] : '';
        $curriculo = isset($data['curriculo']) ? $data['curriculo'] : '';

        $stmt->bindParam(':vaga_id', $vaga_id);
        $stmt->bindParam(':nome_candidato', $nome_candidato);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':curriculo', $curriculo);

        if ($stmt->execute()) {
            $id = $this->conn->lastInsertId();
            return [
                'sucesso' => true,
                'mensagem' => 'Candidatura realizada com sucesso',
                'id' => $id
            ];
        } else {
            return [
                'sucesso' => false,
                'erro' => 'Erro ao realizar candidatura'
            ];
        }
    }
}
?>