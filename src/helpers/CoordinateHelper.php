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
        $result = system("python3 /opt/navtools/dms2dec.py " . $coords);
        return $result;
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance($lat1, $lng1, $lat2, $lng2) {
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
        $speed = $speeds[$missileType] ?? 300;
        return round($distance / ($speed / 3.6), 1);
    }
}
