<?php
class SessionManager {
    private $data;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['visits'])) {
            $_SESSION['visits'] = 0;
        }
        $this->data = &$_SESSION;
    }

    public function isNewVisit() {
        return $this->data['visits'] === 0;
    }

    public function incrementVisit() {
        $this->data['visits']++;
    }

    public function resetSession() {
        $this->data['visits'] = 0;
        session_regenerate_id(true);
    }

    public function getVisitCount() {
        return $this->data['visits'];
    }
}

$session = new SessionManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $session->resetSession();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (!$session->isNewVisit()) {
    $session->incrementVisit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des sessions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            text-align: center;
        }
        .message {
            font-size: 1.5rem;
            margin: 2rem 0;
            padding: 1rem;
            border-radius: 8px;
            background: #f8f9fa;
        }
        button {
            padding: 0.8rem 1.5rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message">
        <?php if ($session->isNewVisit()): ?>
            Bienvenu à notre plateforme
        <?php else: ?>
            Merci pour votre fidélité, c'est votre « <?= $session->getVisitCount() ?> » ème visite
        <?php endif; ?>
    </div>
    
    <form method="post">
        <button type="submit" name="reset">Réinitialiser la session</button>
    </form>
</body>
</html>