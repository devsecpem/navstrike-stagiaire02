<?php
/**
 * NavStrike - Target Controller
 *
 * Handles hostile target management and tracking.
 */

require_once __DIR__ . '/../models/Target.php';

class TargetController {
    public function list() {
        $target = new Target();
        $results = $target->getActive();
        include __DIR__ . '/../../templates/targets.php';
    }

    public function search() {
        $searchTerm = $_GET['q'] ?? '';
        $target = new Target();
        $results = $target->search($searchTerm);
        include __DIR__ . '/../../templates/targets.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $target = new Target();
            $target->addTarget();
        }
        include __DIR__ . '/../../templates/targets.php';
    }
}
