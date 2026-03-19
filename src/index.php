<?php
/**
 * NavStrike - FREMM Missile Targeting System

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'targets':
        require_once __DIR__ . '/controllers/TargetController.php';
        $controller = new TargetController();
        $controller->list();
        break;
    case 'search-targets':
        require_once __DIR__ . '/controllers/TargetController.php';
        $controller = new TargetController();
        $controller->search();
        break;
    case 'add-target':
        require_once __DIR__ . '/controllers/TargetController.php';
        $controller = new TargetController();
        $controller->add();
        break;
    case 'missiles':
        require_once __DIR__ . '/controllers/MissileController.php';
        $controller = new MissileController();
        $controller->inventory();
        break;
    case 'launch':
        require_once __DIR__ . '/controllers/MissileController.php';
        $controller = new MissileController();
        $controller->prepareLaunch();
        break;
    case 'radar':
        require_once __DIR__ . '/controllers/RadarController.php';
        $controller = new RadarController();
        $controller->scan();
        break;
    case 'radar-remote':
        require_once __DIR__ . '/controllers/RadarController.php';
        $controller = new RadarController();
        $controller->scanRemote();
        break;
    case 'missions':
        require_once __DIR__ . '/controllers/MissionController.php';
        $controller = new MissionController();
        $controller->list();
        break;
    case 'mission-briefing':
        require_once __DIR__ . '/controllers/MissionController.php';
        $controller = new MissionController();
        $controller->loadBriefing();
        break;
    case 'mission-export':
        require_once __DIR__ . '/controllers/MissionController.php';
        $controller = new MissionController();
        $controller->export();
        break;
    case 'crew':
        require_once __DIR__ . '/controllers/MissionController.php';
        $controller = new MissionController();
        $controller->crew();
        break;
    case 'login':
        require_once __DIR__ . '/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
    default:
        echo "<h1>NavStrike - Systeme de Ciblage FREMM</h1>";
        echo "<p>Bienvenue sur le systeme de ciblage et de tir de missiles.</p>";
        echo "<p>Fregate multi-missions FREMM - Marine Nationale</p>";
        break;
}
