<?php

namespace App\Models;

use App\Database\Database;
use App\Utils\Validator;
use App\Utils\ScoreCalculator;
use PDO;

class Candidatura
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data)
    {
        // Validar campos obrigatórios
        $requiredFields = ['id', 'id_vaga', 'id_pessoa'];
        if (!Validator::validateRequiredFields($data, $requiredFields)) {
            return false;
        }

        // Validar UUIDs
        if (!Validator::validateUUID($data['id']) || 
            !Validator::validateUUID($data['id_vaga']) || 
            !Validator::validateUUID($data['id_pessoa'])) {
            return false;
        }

        // Verificar se ID já existe
        if ($this->exists($data['id'])) {
            return false;
        }

        // Verificar se já existe candidatura para essa vaga e pessoa
        if ($this->candidaturaExists($data['id_vaga'], $data['id_pessoa'])) {
            return false;
        }

        // Verificar se vaga e pessoa existem
        $vagaModel = new Vaga();
        $pessoaModel = new Pessoa();
        
        $vaga = $vagaModel->findById($data['id_vaga']);
        $pessoa = $pessoaModel->findById($data['id_pessoa']);
        
        if (!$vaga || !$pessoa) {
            return 'not_found';
        }

        try {
            $sql = "INSERT INTO candidaturas (id, id_vaga, id_pessoa) 
                    VALUES (:id, :id_vaga, :id_pessoa)";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                ':id' => $data['id'],
                ':id_vaga' => $data['id_vaga'],
                ':id_pessoa' => $data['id_pessoa']
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function exists($id)
    {
        $sql = "SELECT COUNT(*) FROM candidaturas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function candidaturaExists($idVaga, $idPessoa)
    {
        $sql = "SELECT COUNT(*) FROM candidaturas WHERE id_vaga = :id_vaga AND id_pessoa = :id_pessoa";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_vaga' => $idVaga, ':id_pessoa' => $idPessoa]);
        return $stmt->fetchColumn() > 0;
    }

    public function getRankingByVaga($idVaga)
    {
        // Verificar se a vaga existe
        $vagaModel = new Vaga();
        if (!$vagaModel->exists($idVaga)) {
            return false;
        }

        $sql = "SELECT p.nome, p.profissao, p.localizacao, p.nivel, v.localizacao as vaga_localizacao, v.nivel as vaga_nivel
                FROM candidaturas c
                INNER JOIN pessoas p ON c.id_pessoa = p.id
                INNER JOIN vagas v ON c.id_vaga = v.id
                WHERE c.id_vaga = :id_vaga";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_vaga' => $idVaga]);
        $candidatos = $stmt->fetchAll();

        if (empty($candidatos)) {
            return false;
        }

        // Calcular score para cada candidato
        foreach ($candidatos as &$candidato) {
            $score = ScoreCalculator::calculateScore(
                $candidato['vaga_nivel'],
                $candidato['nivel'],
                $candidato['vaga_localizacao'],
                $candidato['localizacao']
            );
            $candidato['score'] = $score;
            
            // Remover campos auxiliares
            unset($candidato['vaga_localizacao'], $candidato['vaga_nivel']);
        }

        // Ordenar por score decrescente
        usort($candidatos, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $candidatos;
    }
}
