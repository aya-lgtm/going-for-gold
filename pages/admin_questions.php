<?php
session_start();

// Si la variable de session n'est pas définie, on dégage l'intrus
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<?php
require_once __DIR__ . '/../includes/functions.php';

// SUPPRIMER
if (isset($_GET['supprimer'])) {
    deleteQuestion($conn, $_GET['supprimer']);
    header("Location: admin_questions.php");
    exit;
}

// AJOUTER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    addQuestion(
        $conn,
        $_POST['intitule'],
        $_POST['choix1'], $_POST['choix2'],
        $_POST['choix3'], $_POST['choix4'],
        $_POST['reponse_correcte']
    );
    header("Location: admin_questions.php");
    exit;
}

// LIRE toutes les questions
$questions = getAllQuestions($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Questions</title>
</head>
<body>

<h1>Gestion des Questions</h1>

<!-- Formulaire ajout -->
<form method="POST">
    <input type="text" name="intitule" placeholder="Question" required>
    <input type="text" name="choix1" placeholder="Choix 1" required>
    <input type="text" name="choix2" placeholder="Choix 2" required>
    <input type="text" name="choix3" placeholder="Choix 3" required>
    <input type="text" name="choix4" placeholder="Choix 4" required>
    <select name="reponse_correcte">
        <option value="1">Choix 1</option>
        <option value="2">Choix 2</option>
        <option value="3">Choix 3</option>
        <option value="4">Choix 4</option>
    </select>
    <button type="submit" name="ajouter">Ajouter</button>
</form>

<!-- Liste des questions -->
<table border="1">
    <tr>
        <th>ID</th><th>Question</th><th>Bonne réponse</th><th>Actions</th>
    </tr>
    <?php foreach ($questions as $q): ?>
    <tr>
        <td><?= $q['id'] ?></td>
        <td><?= htmlspecialchars($q['intitule']) ?></td>
        <td>Choix <?= $q['reponse_correcte'] ?></td>
        <td>
            <a href="?supprimer=<?= $q['id'] ?>" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>