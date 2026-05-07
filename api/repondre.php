
<?php
require_once '../config.php';
require_once '../includes/functions.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$participant_id = $data['participant_id'];
$question_id    = $data['question_id'];
$reponse        = $data['reponse'];
$temps          = $data['temps_de_reponse'];

// Vérifier bonne réponse
$stmt = $pdo->prepare("SELECT bonne_reponse FROM questions WHERE id = ?");
$stmt->execute([$question_id]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

// Calculer points
$points = 0;
if ($reponse == $question['bonne_reponse']) {
    $points = calculateScore($temps);
}

// Enregistrer la réponse
$stmt = $pdo->prepare("INSERT INTO reponses 
    (participant_id, question_id, reponse_donnee, temps_reponse, points_obtenus)
    VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$participant_id, $question_id, $reponse, $temps, $points]);

// Mettre à jour le score
$stmt = $pdo->prepare("INSERT INTO scores (participant_id, total_points) 
    VALUES (?, ?) 
    ON DUPLICATE KEY UPDATE total_points = total_points + ?");
$stmt->execute([$participant_id, $points, $points]);

echo json_encode([
    'points' => $points,
    'bonne_reponse' => $question['bonne_reponse']
]);