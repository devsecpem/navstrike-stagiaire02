<?php
/**
 * NavStrike - Missile Controller
 *
 * Manages missile inventory and launch sequences.
 */

require_once __DIR__ . '/../models/Missile.php';

class MissileController {
    public function inventory() {
        $missile = new Missile();
        $results = $missile->getInventory();
        include __DIR__ . '/../../templates/missiles.php';
    }

    public function prepareLaunch() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $missile = new Missile();
            $missile->updateStatus();
        }
        $missile = new Missile();
        $results = $missile->getInventory();
        include __DIR__ . '/../../templates/missiles.php';
    }
}
