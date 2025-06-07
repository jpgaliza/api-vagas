<?php

namespace App\Models;

use App\Database\Database;
use App\Utils\Validator;
use PDO;

class Vaga
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function create($data)
    {
        // Validar campos obrigatórios
        $requiredFields = ['id', 'empresa', 'titulo', 'localizacao', 'nivel'];
        if (!Validator::validateRequiredFields($data, $requiredFields)) {
            return false;
        }

        // Validar UUID
        if (!Validator::validateUUID($data['id'])) {
            return false;
        }

        // Validar nível
        if (!Validator::validateLevel($data['nivel'])) {
            return false;
        }

        // Validar localização
        if (!Validator::validateLocation($data['localizacao'])) {
            return false;
        }

        // Verificar se ID já existe
        if ($this->exists($data['id'])) {
            return false;
        }

        try {
            $sql = "INSERT INTO vagas (id, empresa, titulo, descricao, localizacao, nivel) 
                    VALUES (:id, :empresa, :titulo, :descricao, :localizacao, :nivel)";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':id' => $data['id'],
                ':empresa' => $data['empresa'],
                ':titulo' => $data['titulo'],
                ':descricao' => $data['descricao'] ?? null,
                ':localizacao' => $data['localizacao'],
                ':nivel' => $data['nivel']
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function exists($id)
    {
        $sql = "SELECT COUNT(*) FROM vagas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM vagas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
