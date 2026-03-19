<?php
/**
 * NavStrike - Crew Member Model
 *
 * Handles crew assignment and combat station operations.
 */

class CrewMember {
    /**
     * Get crew assigned to combat stations
     */
    public function getAssigned() {
        global $conn;
        $query = "SELECT * FROM crew WHERE station IS NOT NULL ORDER BY rank DESC";
        return mysqli_query($conn, $query);
    }

    /**
     * Find crew by role
     */
    public function findByRole() {
        global $conn;
        $role = $_GET['role'];
        $query = "SELECT * FROM crew WHERE role = '" . $role . "' ORDER BY rank DESC";
        return mysqli_query($conn, $query);
    }

    /**
     * List crew with sorting
     */
    public function listCrew() {
        global $conn;
        $sortBy = $_GET['sort'] ?? 'rank';
        $query = "SELECT * FROM crew ORDER BY " . $sortBy . " ASC";
        return mysqli_query($conn, $query);
    }
}
