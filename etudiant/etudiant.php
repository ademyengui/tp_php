<?php
class Etudiant {
    private $nom;
    private $notes;

    public function __construct($nom, $notes) {
        $this->nom = $nom;
        $this->notes = $notes;
    }

    public function afficherNotes() {
        echo "<div class='notes-container'>";
        echo "<h3>$this->nom</h3>";
        foreach ($this->notes as $note) {
            $classe = 'note';
            if ($note < 10) $classe .= ' note-red';
            elseif ($note > 10) $classe .= ' note-green';
            else $classe .= ' note-orange';
            echo "<span class='$classe'>$note</span>";
        }
        echo "</div>";
    }

    public function calculerMoyenne() {
        return count($this->notes) ? number_format(array_sum($this->notes)/count($this->notes), 2) : 0;
    }

    public function statutAdmission() {
        return $this->calculerMoyenne() >= 10 ? "<span class='admis'>ADMIS</span>" : "<span class='non-admis'>NON ADMIS</span>";
    }
}

$etudiants = [
    new Etudiant("Aymen", [11, 13, 18, 7, 10, 13, 2, 5, 1]),
    new Etudiant("Skander", [15, 9, 8, 16]),
    new Etudiant("Yassine", [12, 14, 9, 11]),
    new Etudiant("Hedi", [8, 7, 6, 5]),
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f0f0f0;
        }
        .notes-container {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .note {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 4px;
            font-weight: bold;
            color: white;
        }
        .note-red { background: #ff4757; }
        .note-green { background: #2ed573; }
        .note-orange { background: #ffa502; }
        .admis { color: #2ed573; }
        .non-admis { color: #ff4757; }
        h3 {
            margin-top: 0;
            color: #2f3542;
        }
    </style>
</head>
<body>
    <?php foreach ($etudiants as $etudiant): ?>
        <?php $etudiant->afficherNotes(); ?>
        <p>Moyenne: <?= $etudiant->calculerMoyenne() ?> - Statut: <?= $etudiant->statutAdmission() ?></p>
    <?php endforeach; ?>
</body>
</html>