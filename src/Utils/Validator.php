<?php

namespace App\Utils;
use App\Database\Database;

class Validator
{
    public static function validateUUID($uuid)
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid);
    }

    public static function validateLevel($level)
    {
        return is_int($level) && $level >= 1 && $level <= 5;
    }

    public static function validateLocation($location)
    {
        return is_string($location) && preg_match('/^[A-F]$/', $location);
    }

    public static function validateRequiredFields($data, $requiredFields)
    {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                return false;
            }
        }
        return true;
    }

    public static function isIdGloballyUnique($id)
    {
        $db = Database::getInstance()->getConnection();

        // Verificar se ID existe na tabela vagas
        $sql = "SELECT COUNT(*) FROM vagas WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        // Verificar se ID existe na tabela pessoas
        $sql = "SELECT COUNT(*) FROM pessoas WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        // Verificar se ID existe na tabela candidaturas
        $sql = "SELECT COUNT(*) FROM candidaturas WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        return true; // ID é único globalmente
    }
}
