<?php
require_once '../config.php';
header('Content-Type: application/json');

$groupe_id  = $_GET['groupe_id']  ?? null;
$session_id = $_GET['session_id'] ?? null;
$type       = $_GET['type']       ?? null;

// Si pas de session_id fourni, prendre la session active
if (!$session_id) {
    $session = $pdo->query("
        SELECT id FROM sessions 
        WHERE statut IN ('waiting', 'active') 
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);
    $session_id = $session['id'] ?? 0;
}

// =========================================================
// TYPE FINALE — score UNIQUEMENT des questions de la finale
// On lit directement les questions_ids de la session finale
// =========================================================
if ($type === 'finale') {

    $sq_finale = $pdo->query("
        SELECT id, questions_ids, created_at
        FROM sessions_quiz 
        WHERE type_round = 'finale'
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    if (!$sq_finale || empty($sq_finale['questions_ids'])) {
        echo json_encode([]);
        exit;
    }

    $ids_finale   = json_decode($sq_finale['questions_ids'], true);
    $finale_debut = $sq_finale['created_at'];

    if (empty($ids_finale)) {
        echo json_encode([]);
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($ids_finale), '?'));

    $stmt = $pdo->prepare("
        SELECT 
            p.id,
            p.nom,
            p.session_id,
            SUM(r.points_obtenus) AS total_points
        FROM participants p
        INNER JOIN reponses r 
            ON r.participant_id = p.id 
            AND r.question_id IN ($placeholders)
            AND r.created_at >= ?
        WHERE p.session_id = ?
        GROUP BY p.id, p.nom, p.session_id
        HAVING COUNT(r.id) > 0
        ORDER BY total_points DESC
    ");

    $params = array_merge($ids_finale, [$finale_debut, $session_id]);
    $stmt->execute($params);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// =========================================================
// CLASSEMENT PAR GROUPE — score uniquement du round concerné
// =========================================================
if ($groupe_id) {

    $sq_round = $pdo->prepare("
        SELECT questions_ids 
        FROM sessions_quiz 
        WHERE type_round = ?
        ORDER BY id DESC LIMIT 1
    ");
    $sq_round->execute(['first_round_' . $groupe_id]);
    $sq = $sq_round->fetch(PDO::FETCH_ASSOC);
    $ids_round = $sq ? json_decode($sq['questions_ids'], true) : [];

    if (!empty($ids_round)) {
        $placeholders = implode(',', array_fill(0, count($ids_round), '?'));

        $stmt = $pdo->prepare("
            SELECT 
                p.id,
                p.nom,
                p.groupe_id,
                p.session_id,
                g.nom AS groupe,
                COALESCE(SUM(r.points_obtenus), 0) AS total_points
            FROM participants p
            LEFT JOIN reponses r 
                ON r.participant_id = p.id 
                AND r.question_id IN ($placeholders)
            LEFT JOIN groupes g ON g.id = p.groupe_id
            WHERE p.session_id = ? AND p.groupe_id = ?
            GROUP BY p.id, p.nom, p.groupe_id, p.session_id, g.nom
            ORDER BY total_points DESC
        ");

        $params = array_merge($ids_round, [$session_id, $groupe_id]);
        $stmt->execute($params);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }
}

// =========================================================
// CLASSEMENT GLOBAL — utilise la table scores (rounds uniquement)
// On exclut les points de la finale de scores grâce au
// flag dans participant.php (est_question_finale)
// =========================================================
$stmt = $pdo->prepare("
    SELECT 
        p.id,
        p.nom,
        p.groupe_id,
        p.session_id,
        g.nom AS groupe,
        COALESCE(s.total_points, 0) AS total_points
    FROM participants p
    LEFT JOIN scores s ON s.participant_id = p.id
    LEFT JOIN groupes g ON g.id = p.groupe_id
    WHERE p.session_id = ?
    ORDER BY total_points DESC
");
$stmt->execute([$session_id]);
$classement = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(empty($classement) ? [] : $classement);