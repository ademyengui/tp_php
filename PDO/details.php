<?php
require_once 'config/database.php';
require_once 'models/Repository.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: students.php');
    exit;
}

$studentRepo = new Repository('student');
$student = $studentRepo->findById($_GET['id']);

if (!$student) {
    header('Location: students.php');
    exit;
}
?>

<h1><?= htmlspecialchars($student['name']) ?></h1>
<p>Date de naissance : <?= date('d/m/Y', strtotime($student['birthday'])) ?></p>