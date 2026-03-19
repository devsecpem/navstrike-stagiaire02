<?php
/**
 * NavStrike - Authentication Controller
 *
 * Handles operator login and session management.
 */

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            global $conn;
            $query = "SELECT * FROM operators WHERE callsign = '" . $username . "' AND password = '" . $password . "'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                session_start();
                $_SESSION['operator'] = $username;
                $_SESSION['clearance'] = 'SECRET';
                header('Location: ?page=home');
            } else {
                echo "<p>Identifiants incorrects - Acces refuse au poste de combat</p>";
            }
        }
        include __DIR__ . '/../../templates/layout.php';
    }
}
