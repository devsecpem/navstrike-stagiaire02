<?php
/**
 * NavStrike - Radar Controller
 *
 * Handles radar operations, contact tracking, and remote sensor feeds.
 */
class RadarController {
    // Liste blanche des secteurs autorisés
    private const ALLOWED_SECTORS = [
        'all', 'nord', 'sud', 'est', 'ouest'
    ];

    // Liste blanche des modules capteurs autorisés
    private const ALLOWED_MODULES = [
        'sonar', 'infrared', 'thermal', 'optical'
    ];

    /**
     * Display local radar contacts
     */
    public function scan() {
        global $conn;
        $sector = $_GET['sector'] ?? 'all';

        // Validation par liste blanche
        if (!in_array($sector, self::ALLOWED_SECTORS, true)) {
            http_response_code(400);
            echo "<p>Secteur invalide.</p>";
            return;
        }

        // Requête préparée - protection injection SQL
        if ($sector === 'all') {
            $stmt = mysqli_prepare($conn, "SELECT * FROM radar_contacts ORDER BY distance ASC");
        } else {
            $stmt = mysqli_prepare($conn, "SELECT * FROM radar_contacts WHERE sector = ? ORDER BY distance ASC");
            mysqli_stmt_bind_param($stmt, "s", $sector);
        }

        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        include __DIR__ . '/../../templates/radar.php';
    }

    /**
     * Load remote sensor module
     */
    public function scanRemote() {
        $module = $_GET['sensor_module'] ?? '';

        // Validation par liste blanche - protection LFI
        if (!in_array($module, self::ALLOWED_MODULES, true)) {
            http_response_code(400);
            echo "<p>Module invalide.</p>";
            return;
        }

        // Vérification path traversal
        $modulePath = realpath(__DIR__ . '/../../sensors/' . $module . '.php');
        $basePath = realpath(__DIR__ . '/../../sensors/');

        if (!$modulePath || !str_starts_with($modulePath, $basePath)) {
            http_response_code(400);
            echo "<p>Module invalide.</p>";
            return;
        }

        include $modulePath;
    }
}