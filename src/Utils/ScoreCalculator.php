<?php

namespace App\Utils;

class ScoreCalculator
{
    // Mapa de distâncias entre localidades (baseado em um grafo simples)
    private static $distances = [
        'A' => ['A' => 0, 'B' => 5, 'C' => 10, 'D' => 15, 'E' => 20, 'F' => 25],
        'B' => ['A' => 5, 'B' => 0, 'C' => 5, 'D' => 10, 'E' => 15, 'F' => 20],
        'C' => ['A' => 10, 'B' => 5, 'C' => 0, 'D' => 5, 'E' => 10, 'F' => 15],
        'D' => ['A' => 15, 'B' => 10, 'C' => 5, 'D' => 0, 'E' => 5, 'F' => 10],
        'E' => ['A' => 20, 'B' => 15, 'C' => 10, 'D' => 5, 'E' => 0, 'F' => 5],
        'F' => ['A' => 25, 'B' => 20, 'C' => 15, 'D' => 10, 'E' => 5, 'F' => 0],
    ];

    public static function calculateScore($nivelVaga, $nivelCandidato, $localizacaoVaga, $localizacaoCandidato)
    {
        // Calcular N
        $n = 100 - 25 * abs($nivelVaga - $nivelCandidato);

        // Calcular D
        $distancia = self::getDistance($localizacaoVaga, $localizacaoCandidato);
        $d = self::getDistanceScore($distancia);

        // Calcular Score final (apenas parte inteira)
        $score = intval(($n + $d) / 2);

        return $score;
    }

    private static function getDistance($loc1, $loc2)
    {
        if (!isset(self::$distances[$loc1]) || !isset(self::$distances[$loc1][$loc2])) {
            return 999; // Distância muito alta para localização inválida
        }

        return self::$distances[$loc1][$loc2];
    }

    private static function getDistanceScore($distance)
    {
        if ($distance <= 5) {
            return 100;
        } elseif ($distance <= 10) {
            return 75;
        } elseif ($distance <= 15) {
            return 50;
        } elseif ($distance <= 20) {
            return 25;
        } else {
            return 0;
        }
    }
}
