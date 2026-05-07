<?php
require_once '../config.php';
header('Content-Type: application/json');

$stmt = $pdo->query("
    SELECT p.nom, s.total_points, g.nom as groupe
    FROM scores s
    JOIN participants p ON p.id = s.participant_id
    JOIN groupes g ON g.id = p.groupe_id
    ORDER BY s.total_points DESC
");
$classement = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($classement)) {
    echo json_encode(['message' => 'Aucun score encore']);
} else {
    echo json_encode($classement);
}