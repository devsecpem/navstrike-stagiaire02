<?php
/**
 * NavStrike - Report Helper
 *
 * Generates mission reports and tactical exports.
 */

use Dompdf\Dompdf;
use Dompdf\Options;

class ReportHelper {
    // Formats autorisés
    private const ALLOWED_FORMATS = ['pdf', 'html'];

    /**
     * Export mission report to specified format
     */
    public function exportReport($missionId, $format) {
        // Validation de l'ID mission - chiffres uniquement
        if (!preg_match('/^\d+$/', $missionId)) {
            throw new InvalidArgumentException("ID de mission invalide.");
        }

        // Validation du format par liste blanche
        if (!in_array($format, self::ALLOWED_FORMATS, true)) {
            throw new InvalidArgumentException("Format invalide.");
        }

        $inputFile = realpath("/var/www/html/reports/" . $missionId . ".html");
        $basePath  = realpath("/var/www/html/reports/");

        // Protection path traversal
        if (!$inputFile || !str_starts_with($inputFile, $basePath)) {
            throw new InvalidArgumentException("Fichier de rapport introuvable.");
        }

        $htmlContent = file_get_contents($inputFile);
        $outputFile  = "/tmp/mission_report_" . $missionId . "." . $format;

        if ($format === 'pdf') {
            // Génération PDF via Dompdf - sans appel système
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', false);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            file_put_contents($outputFile, $dompdf->output());
        } else {
            // Export HTML direct
            file_put_contents($outputFile, $htmlContent);
        }

        echo "<p>Rapport exporte : " . htmlspecialchars($outputFile, ENT_QUOTES, 'UTF-8') . "</p>";
    }

    /**
     * Generate tactical summary
     */
    public function generateSummary($missionId) {
        global $conn;

        $stmt = mysqli_prepare($conn, "SELECT * FROM missions WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $missionId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $mission = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if (!$mission) {
            throw new InvalidArgumentException("Mission introuvable.");
        }

        $summary  = "RAPPORT TACTIQUE - Mission: " . htmlspecialchars($mission['name'] ?? 'N/A', ENT_QUOTES, 'UTF-8') . "\n";
        $summary .= "Date: " . date('Y-m-d H:i:s') . "\n";
        $summary .= "Zone: " . htmlspecialchars($mission['zone'] ?? 'N/A', ENT_QUOTES, 'UTF-8') . "\n";

        return $summary;
    }
}