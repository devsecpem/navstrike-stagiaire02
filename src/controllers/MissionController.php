<?php
/**
 * NavStrike - Mission Controller
 *
 * Handles mission planning, briefings, crew management, and exports.
 */
require_once __DIR__ . '/../models/CrewMember.php';
require_once __DIR__ . '/../helpers/ReportHelper.php';

class MissionController {
    // Liste blanche des templates autorisés
    private const ALLOWED_TEMPLATES = [
        'alpha', 'bravo', 'charlie', 'delta'
    ];

    /**
     * List active missions
     */
    public function list() {
        global $conn;
        $query = "SELECT * FROM missions ORDER BY priority DESC";
        $results = mysqli_query($conn, $query);
        include __DIR__ . '/../../templates/missions.php';
    }

    /**
     * Load mission briefing document
     */
    public function loadBriefing() {
        $template = $_GET['template'] ?? '';

        // Validation par liste blanche
        if (!in_array($template, self::ALLOWED_TEMPLATES, true)) {
            http_response_code(400);
            echo "<p>Template invalide.</p>";
            return;
        }

        // Chargement sécurisé du fichier template
        $templatePath = realpath(__DIR__ . '/../../briefings/' . $template . '.html');
        $basePath = realpath(__DIR__ . '/../../briefings/');

        // Vérification path traversal
        if (!$templatePath || !str_starts_with($templatePath, $basePath)) {
            http_response_code(400);
            echo "<p>Template invalide.</p>";
            return;
        }

        $rendered = htmlspecialchars(file_get_contents($templatePath), ENT_QUOTES, 'UTF-8');

        echo "<h2>Briefing de mission</h2>";
        echo "<div>" . $rendered . "</div>";
    }

    /**
     * Export mission report
     */
    public function export() {
        $missionId = $_GET['mission_id'] ?? '';
        $format = $_GET['format'] ?? 'pdf';
        $report = new ReportHelper();
        $report->exportReport($missionId, $format);
    }

    /**
     * Display crew assignments
     */
    public function crew() {
        $crew = new CrewMember();
        $results = $crew->getAssigned();
        include __DIR__ . '/../../templates/crew.php';
    }
}