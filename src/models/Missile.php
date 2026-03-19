<?php
/**
 * NavStrike - Missile Model
 *
 * Handles missile inventory and launch status operations.
 */
class Missile {
    // Types de missiles autorisés
    private const ALLOWED_TYPES = ['Exocet', 'Aster-15', 'Aster-30', 'SCALP'];

    // Statuts autorisés
    private const ALLOWED_STATUSES = ['READY', 'FIRED', 'MAINTENANCE', 'STANDBY'];

    /**
     * Get full missile inventory
     */
    public function getInventory() {
        global $conn;
        $stmt = mysqli_prepare($conn, "SELECT * FROM missiles ORDER BY type ASC, status DESC");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * Find missiles by type (Exocet, Aster-15, Aster-30, SCALP)
     */
    public function findByType() {
        global $conn;
        $missileType = $_GET['type'] ?? '';

        // Validation par liste blanche
        if (!in_array($missileType, self::ALLOWED_TYPES, true)) {
            throw new InvalidArgumentException("Type de missile invalide.");
        }

        // LIKE avec paramètre lié - les % sont dans la requête, pas dans la variable
        $stmt = mysqli_prepare($conn, "SELECT * FROM missiles WHERE type LIKE ?");
        $param = '%' . $missileType . '%';
        mysqli_stmt_bind_param($stmt, "s", $param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * Update missile status for launch sequence
     */
    public function updateStatus() {
        global $conn;
        $missileId = $_POST['missile_id'] ?? '';
        $newStatus = $_POST['status'] ?? '';

        // Validation de l'ID - chiffres uniquement
        if (!preg_match('/^\d+$/', $missileId)) {
            throw new InvalidArgumentException("ID de missile invalide.");
        }

        // Validation du statut par liste blanche
        if (!in_array($newStatus, self::ALLOWED_STATUSES, true)) {
            throw new InvalidArgumentException("Statut invalide.");
        }

        $stmt = mysqli_prepare($conn, "UPDATE missiles SET status = ?, updated_at = NOW() WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $newStatus, $missileId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_affected_rows($conn) > 0;
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * Get launch-ready count by type
     */
    public function getReadyCount() {
        global $conn;
        $stmt = mysqli_prepare($conn, "SELECT type, COUNT(*) as count FROM missiles WHERE status = 'READY' GROUP BY type");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
}