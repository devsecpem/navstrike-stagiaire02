<?php
/**
 * NavStrike - Coordinate Helper
 *
 * Handles GPS coordinate conversions and distance calculations.
 */
class CoordinateHelper {
    /**
     * Convert DMS coordinates to decimal natively in PHP
     * Format attendu : 48°51'24"N 2°21'03"E
     */
    public function convertDMS($coords) {
        // Validation stricte du format DMS attendu
        if (!preg_match('/^\d{1,3}°\d{1,2}\'\d{1,2}"[NS]\s\d{1,3}°\d{1,2}\'\d{1,2}"[EW]$/', $coords)) {
            throw new InvalidArgumentException("Format de coordonnées invalide.");
        }

        // Extraction des composantes lat/lng
        preg_match('/^(\d{1,3})°(\d{1,2})\'(\d{1,2})"([NS])\s(\d{1,3})°(\d{1,2})\'(\d{1,2})"([EW])$/', $coords, $matches);

        $lat = (float)$matches[1] + ((float)$matches[2] / 60) + ((float)$matches[3] / 3600);
        $lng = (float)$matches[5] + ((float)$matches[6] / 60) + ((float)$matches[7] / 3600);

        // Appliquer le signe selon l'hémisphère
        if ($matches[4] === 'S') $lat = -$lat;
        if ($matches[8] === 'W') $lng = -$lng;

        return ['latitude' => round($lat, 6), 'longitude' => round($lng, 6)];
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance($lat1, $lng1, $lat2, $lng2) {
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

        if (!array_key_exists($missileType, $speeds)) {
            throw new InvalidArgumentException("Type de missile invalide.");
        }

        $speed = $speeds[$missileType];
        return round($distance / ($speed / 3.6), 1);
    }
}