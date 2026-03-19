<?php
/**
 * NavStrike - Radar Controller
 *
 * Handles radar operations, contact tracking, and remote sensor feeds.
 */

class RadarController {
    /**
     * Display local radar contacts
     */
    public function scan() {
        global $conn;
        $sector = $_GET['sector'] ?? 'all';
        $query = "SELECT * FROM radar_contacts WHERE sector = '" . $sector . "' ORDER BY distance ASC";
        $results = mysqli_query($conn, $query);
        include __DIR__ . '/../../templates/radar.php';
    }

    /**
     * Load remote sensor module
     */
    public function scanRemote() {
        $module = $_GET['sensor_module'];
        include("sensors/" . $module . ".php");
    }
}
