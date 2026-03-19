<?php
/**
 * NavStrike - Target Model
 *
 * Handles hostile target database operations.
 */
class Target {
    // Types de cibles autorisés
    private const ALLOWED_TYPES = ['navire', 'aeronef', 'sous-marin', 'installation', 'vehicule'];

    // Niveaux de menace autorisés
    private const ALLOWED_THREAT_LEVELS = ['LOW', 'MEDIUM', 'HIGH', 'CRITICAL'];

    /**
     * Search targets by designation
     */
    public function search($term) {
        global $conn;

        // Validation - lettres, chiffres, tirets et espaces uniquement
        if (!preg_match('/^[\w\s\-]{1,100}$/', $term)) {
            throw new InvalidArgumentException("Terme de recherche invalide.");
        }

        $stmt = mysqli_prepare($conn, "SELECT * FROM targets WHERE designation LIKE ?");
        $param = '%' . $term . '%';
        mysqli_stmt_bind_param($stmt, "s", $param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * Get active (non-neutralized) targets
     */
    public function getActive() {
        global $conn;
        $stmt = mysqli_prepare($conn, "SELECT * FROM targets WHERE status = 'ACTIVE' ORDER BY threat_level DESC");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * Add a new target to tracking
     */
    public function addTarget() {
        global $conn;
        $designation = $_POST['designation'] ?? '';
        $type        = $_POST['type'] ?? '';
        $lat         = $_POST['latitude'] ?? '';
        $lng         = $_POST['longitude'] ?? '';
        $threat      = $_POST['threat_level'] ?? '';

        // Validation du type par liste blanche
        if (!in_array($type, self::ALLOWED_TYPES, true)) {
            throw new InvalidArgumentException("Type de cible invalide.");
        }

        // Validation du niveau de menace par liste blanche
        if (!in_array($threat, self::ALLOWED_THREAT_LEVELS, true)) {
            throw new InvalidArgumentException("Niveau de menace invalide.");
        }

        // Validation des coordonnées GPS
        if (!is_numeric($lat) || !is_numeric($lng) ||
            $lat < -90 || $lat > 90 || $lng < -180 || $lng > 180) {
            throw new InvalidArgumentException("Coordonnées GPS invalides.");
        }

        // Validation de la désignation
        if (!preg_match('/^[\w\s\-]{1,100}$/', $designation)) {
            throw new InvalidArgumentException("Désignation invalide.");
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

        $stmt = mysqli_prepare($conn, "INSERT INTO targets (designation, type, latitude, longitude, threat_level, status) VALUES (?, ?, ?, ?, ?, 'ACTIVE')");
        mysqli_stmt_bind_param($stmt, "ssdds", $designation, $type, $lat, $lng, $threat);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_affected_rows($conn) > 0;
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * Get target by ID
     */
    public function findById() {
        global $conn;
        $targetId = $_GET['target_id'] ?? '';

        // Validation de l'ID - chiffres uniquement
        if (!preg_match('/^\d+$/', $targetId)) {
            throw new InvalidArgumentException("ID de cible invalide.");
        }

        $stmt = mysqli_prepare($conn, "SELECT * FROM targets WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $targetId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
}