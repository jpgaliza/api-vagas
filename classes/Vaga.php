<?php
require_once 'config/database.php';

class Vaga
{
    private $conn;
    private $table_name = "vagas";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listarTodas()
    {
        $query = "SELECT 
                    id, titulo, descricao, empresa, localizacao, 
                    salario, tipo_contrato, requisitos, beneficios, 
                    data_publicacao, status 
                  FROM " . $this->table_name . " 
                  WHERE status = 'ativa' 
                  ORDER BY data_publicacao DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $vagas = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vagas[] = $row;
        }

        return [
            'sucesso' => true,
            'dados' => $vagas,
            'total' => count($vagas)
        ];
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return [
                'sucesso' => true,
                'dados' => $row
            ];
        } else {
            return [
                'sucesso' => false,
                'erro' => 'Vaga não encontrada'
            ];
        }
    }
    public function criar($data)
    {
        // Validação mais precisa
        if (
            !isset($data['titulo']) || !isset($data['descricao']) || !isset($data['empresa']) ||
            trim($data['titulo']) === '' || trim($data['descricao']) === '' || trim($data['empresa']) === ''
        ) {
            return [
                'sucesso' => false,
                'erro' => 'Título, descrição e empresa são obrigatórios'
            ];
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  (titulo, descricao, empresa, localizacao, salario, tipo_contrato, 
                   requisitos, beneficios, data_publicacao, status) 
                  VALUES 
                  (:titulo, :descricao, :empresa, :localizacao, :salario, :tipo_contrato, 
                   :requisitos, :beneficios, NOW(), 'ativa')";
        $stmt = $this->conn->prepare($query);

        // Bind dos parâmetros - criar variáveis para evitar erro de referência
        $titulo = $data['titulo'];
        $descricao = $data['descricao'];
        $empresa = $data['empresa'];
        $localizacao = isset($data['localizacao']) ? $data['localizacao'] : '';
        $salario = isset($data['salario']) ? $data['salario'] : null;
        $tipo_contrato = isset($data['tipo_contrato']) ? $data['tipo_contrato'] : '';
        $requisitos = isset($data['requisitos']) ? $data['requisitos'] : '';
        $beneficios = isset($data['beneficios']) ? $data['beneficios'] : '';

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':localizacao', $localizacao);
        $stmt->bindParam(':salario', $salario);
        $stmt->bindParam(':tipo_contrato', $tipo_contrato);
        $stmt->bindParam(':requisitos', $requisitos);
        $stmt->bindParam(':beneficios', $beneficios);

        if ($stmt->execute()) {
            $id = $this->conn->lastInsertId();
            return [
                'sucesso' => true,
                'mensagem' => 'Vaga criada com sucesso',
                'id' => $id
            ];
        } else {
            return [
                'sucesso' => false,
                'erro' => 'Erro ao criar vaga'
            ];
        }
    }

    public function atualizar($id, $data)
    {
        // Verificar se a vaga existe
        $check_query = "SELECT id FROM " . $this->table_name . " WHERE id = ?";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(1, $id);
        $check_stmt->execute();

        if ($check_stmt->rowCount() == 0) {
            return [
                'sucesso' => false,
                'erro' => 'Vaga não encontrada'
            ];
        }

        $query = "UPDATE " . $this->table_name . " SET 
                  titulo = :titulo, 
                  descricao = :descricao, 
                  empresa = :empresa, 
                  localizacao = :localizacao, 
                  salario = :salario, 
                  tipo_contrato = :tipo_contrato, 
                  requisitos = :requisitos, 
                  beneficios = :beneficios 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Criar variáveis para evitar erro de referência
        $titulo = $data['titulo'];
        $descricao = $data['descricao'];
        $empresa = $data['empresa'];
        $localizacao = isset($data['localizacao']) ? $data['localizacao'] : '';
        $salario = isset($data['salario']) ? $data['salario'] : null;
        $tipo_contrato = isset($data['tipo_contrato']) ? $data['tipo_contrato'] : '';
        $requisitos = isset($data['requisitos']) ? $data['requisitos'] : '';
        $beneficios = isset($data['beneficios']) ? $data['beneficios'] : '';

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':localizacao', $localizacao);
        $stmt->bindParam(':salario', $salario);
        $stmt->bindParam(':tipo_contrato', $tipo_contrato);
        $stmt->bindParam(':requisitos', $requisitos);
        $stmt->bindParam(':beneficios', $beneficios);

        if ($stmt->execute()) {
            return [
                'sucesso' => true,
                'mensagem' => 'Vaga atualizada com sucesso'
            ];
        } else {
            return [
                'sucesso' => false,
                'erro' => 'Erro ao atualizar vaga'
            ];
        }
    }

    public function deletar($id)
    {
        // Soft delete - apenas muda o status
        $query = "UPDATE " . $this->table_name . " SET status = 'inativa' WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return [
                'sucesso' => true,
                'mensagem' => 'Vaga removida com sucesso'
            ];
        } else {
            return [
                'sucesso' => false,
                'erro' => 'Vaga não encontrada ou erro ao remover'
            ];
        }
    }
}
?>