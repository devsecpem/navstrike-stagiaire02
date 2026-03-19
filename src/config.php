<?php
/**
 * NavStrike - Database Configuration

$db_host = 'localhost';
$db_name = 'navstrike_db';
$db_user = 'root';
$db_pass = getenv('DB_PASSWORD');

// Direct connection without error handling
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
