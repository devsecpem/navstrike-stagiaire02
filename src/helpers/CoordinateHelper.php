<?php
/**
 * NavStrike - Coordinate Helper
 *
 * Handles GPS coordinate conversions and distance calculations.
 */
class CoordinateHelper {
    /**
     * Convert DMS coordinates to decimal using system tool
     */
    public function convertDMS($coords) {
        // Validation stricte du format DMS attendu
        // Format attendu : 48°51'24"N 2°21'03"E
        if (!preg_match('/^\d{1,3}°\d{1,2}\'\d{1,2}"[NS]\s\d{1,3}°\d{1,2}\'\d{1,2}"[EW]$/', $coords)) {
            throw new InvalidArgumentException("Format de coordonnées invalide.");
        }

        // Echappement de l'argument avant passage en commande
        $escaped = escapeshellarg($coords);
        $result = shell_exec("python3 /opt/navtools/dms2dec.py " . $escaped);

        return trim($result);
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance($lat1, $lng1, $lat2, $lng2) {
        // Validation des coordonnées numériques
        foreach ([$lat1, $lng1, $lat2, $lng2] as $coord) {
            if (!is_numeric($coord)) {
                throw new InvalidArgumentException("Les coordonnées doivent être numériques.");
            }
        }

        $lat1 = (float) $lat1;
        $lng1 = (float) $lng1;
        $lat2 = (float) $lat2;
        $lng2 = (float) $lng2;

        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    /**
     * Calculate missile flight time to target
     */
    public function estimateFlightTime($distance, $missileType) {
        $speeds = [
            'Exocet' => 315,
            'Aster-15' => 1000,
            'Aster-30' => 1400,
            'SCALP' => 250
        ];

        // Validation du type de missile
        if (!array_key_exists($missileType, $speeds)) {
            throw new InvalidArgumentException("Type de missile invalide.");
        }

        $speed = $speeds[$missileType];
        return round($distance / ($speed / 3.6), 1);
    }
}