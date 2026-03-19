<?php
/**
 * NavStrike - Crew Member Model
 *
 * Handles crew assignment and combat station operations.
 */
class CrewMember {
    // Colonnes autorisées pour le tri
    private const ALLOWED_SORT_COLUMNS = ['rank', 'name', 'role', 'station'];

    // Rôles autorisés
    private const ALLOWED_ROLES = ['officier', 'matelot', 'ingenieur', 'navigateur', 'commandant'];

    /**
     * Get crew assigned to combat stations
     */
    public function getAssigned() {
        global $conn;
        $stmt = mysqli_prepare($conn, "SELECT * FROM crew WHERE station IS NOT NULL ORDER BY rank DESC");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * Find crew by role
     */
    public function findByRole() {
        global $conn;
        $role = $_GET['role'] ?? '';

        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            throw new InvalidArgumentException("Rôle invalide.");
        }

        $stmt = mysqli_prepare($conn, "SELECT * FROM crew WHERE role = ? ORDER BY rank DESC");
        mysqli_stmt_bind_param($stmt, "s", $role);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    /**
     * List crew with sorting
     */
    public function listCrew() {
        global $conn;
        $sortBy = $_GET['sort'] ?? 'rank';

        // Mapping vers des constantes littérales - aucune variable dans la requête
        $query = match($sortBy) {
            'name'    => "SELECT * FROM crew ORDER BY name ASC",
            'role'    => "SELECT * FROM crew ORDER BY role ASC",
            'station' => "SELECT * FROM crew ORDER BY station ASC",
            default   => "SELECT * FROM crew ORDER BY rank ASC",
        };

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
}