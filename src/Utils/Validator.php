<?php

namespace App\Utils;

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
}
