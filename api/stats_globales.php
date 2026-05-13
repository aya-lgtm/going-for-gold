<?php
require_once '../config.php';
header('Content-Type: application/json');

// Récupérer la session active
$session = $pdo->query("
    SELECT id FROM sessions 
    WHERE statut IN ('waiting', 'active') 
    ORDER BY id DESC LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

$session_id = $session['id'] ?? 0;

// Total réponses de la session courante
$total = $pdo->prepare("
    SELECT COUNT(*) FROM reponses r
    JOIN participants p ON p.id = r.participant_id
    WHERE p.session_id = ?
");
$total->execute([$session_id]);
$total = $total->fetchColumn();

// Taux de réussite
$bonnes = $pdo->prepare("
    SELECT COUNT(*) FROM reponses r
    JOIN questions q ON q.id = r.question_id
    JOIN participants p ON p.id = r.participant_id
    WHERE r.reponse_donnee = q.bonne_reponse
    AND p.session_id = ?
");
$bonnes->execute([$session_id]);
$bonnes = $bonnes->fetchColumn();

$taux = $total > 0 ? round($bonnes / $total * 100) : 0;

// Temps moyen
$temps = $pdo->prepare("
    SELECT AVG(r.temps_reponse) FROM reponses r
    JOIN participants p ON p.id = r.participant_id
    WHERE p.session_id = ?
");
$temps->execute([$session_id]);
$temps = $temps->fetchColumn();

// Stats par question
$stmt = $pdo->prepare("
    SELECT q.id, q.texte,
        COUNT(r.id) as nb_reponses,
        AVG(r.temps_reponse) as temps_moyen,
        SUM(CASE WHEN r.reponse_donnee = q.bonne_reponse THEN 1 ELSE 0 END) as bonnes
    FROM questions q
    LEFT JOIN reponses r ON r.question_id = q.id
    LEFT JOIN participants p ON p.id = r.participant_id
    WHERE p.session_id = ? OR r.id IS NULL
    GROUP BY q.id
    ORDER BY q.id
");
$stmt->execute([$session_id]);
$par_question = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($par_question as &$q) {
    $q['taux'] = $q['nb_reponses'] > 0
        ? round($q['bonnes'] / $q['nb_reponses'] * 100) : 0;
    $q['temps_moyen'] = round($q['temps_moyen'] ?? 0, 1);
}

echo json_encode([
    'total_reponses' => $total,
    'taux_reussite'  => $taux,
    'temps_moyen'    => round($temps ?? 0, 1),
    'par_question'   => $par_question
]);
?>