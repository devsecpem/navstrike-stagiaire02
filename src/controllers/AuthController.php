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

            // Requête préparée - protection injection SQL
            $stmt = mysqli_prepare($conn, "SELECT * FROM operators WHERE callsign = ?");
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            // Vérification sécurisée du mot de passe
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['operator'] = $username;
                $_SESSION['clearance'] = 'SECRET';
                header('Location: ?page=home');
                exit();
            } else {
                echo "<p>Identifiants incorrects - Acces refuse au poste de combat</p>";
            }
        }
        include __DIR__ . '/../../templates/layout.php';
    }
}