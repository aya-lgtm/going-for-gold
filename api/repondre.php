<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once '../config.php';

$data = json_decode(file_get_contents('php://input'), true);

$participant_id   = $data['participant_id']   ?? 0;
$question_id      = $data['question_id']      ?? 0;
$reponse          = $data['reponse']          ?? 0;
$temps_de_reponse = $data['temps_de_reponse'] ?? 10;

if (!$participant_id || !$question_id) {
    echo json_encode(['error' => 'Données manquantes']);
    exit;
}

// Récupérer la bonne réponse
$stmt = $pdo->prepare("SELECT bonne_reponse FROM questions WHERE id = ?");
$stmt->execute([$question_id]);
$question = $stmt->fetch();

if (!$question) {
    echo json_encode(['error' => 'Question introuvable']);
    exit;
}

$bonne_reponse = $question['bonne_reponse'];
$correct = ($reponse == $bonne_reponse);

// Calculer les points 
$points = 0;
if ($correct) {
    $points = max(100, round(1000 - ($temps_de_reponse * 90)));
}

// Vérifier si déjà répondu
$stmt = $pdo->prepare("SELECT id FROM reponses WHERE participant_id = ? AND question_id = ?");
$stmt->execute([$participant_id, $question_id]);
if ($stmt->fetch()) {
    echo json_encode([
        'success'       => false,
        'error'         => 'Déjà répondu',
        'bonne_reponse' => $bonne_reponse,
        'points'        => 0
    ]);
    exit;
}

// Enregistrer la réponse
$stmt = $pdo->prepare("
    INSERT INTO reponses (participant_id, question_id, reponse, correct, points, temps_de_reponse)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->execute([
    $participant_id,
    $question_id,
    $reponse,
    $correct ? 1 : 0,
    $points,
    $temps_de_reponse
]);

// Mettre à jour le score total du participant
$stmt = $pdo->prepare("
    UPDATE participants 
    SET total_points = total_points + ? 
    WHERE id = ?
");
$stmt->execute([$points, $participant_id]);

echo json_encode([
    'success'       => true,
    'correct'       => $correct,
    'bonne_reponse' => $bonne_reponse,
    'points'        => $points
]);