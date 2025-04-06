<?php
require_once 'config/database.php';
require_once 'models/Repository.php';

$studentRepo = new Repository('student');
$students = $studentRepo->findAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des étudiants</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .role-admin { background-color: #e3f2fd; }
        .role-user { background-color: #fff; }
    </style>
</head>
<body>
    <table id="studentsTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Date de naissance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['id']) ?></td>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= date('d/m/Y', strtotime($student['birthday'])) ?></td>
                <td>
                    <a href="detail.php?id=<?= $student['id'] ?>">Détails</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#studentsTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf'],
                pageLength: 25,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                }
            });
        });
    </script>
</body>
</html>