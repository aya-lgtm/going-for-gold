<?php
require_once '../config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$data   = []; // initialiser à vide
if (empty($action)) {
    $data   = json_decode(file_get_contents('php://input'), true) ?? [];
    $action = $data['action'] ?? '';
} else {
    // Lire le body même si action est en GET
    $body = file_get_contents('php://input');
    if ($body) $data = json_decode($body, true) ?? [];
}
// =========================
// STATUS — polling salle d'attente
// =========================
if ($action === 'status') {

    $participant_id = $_GET['participant_id'] ?? 0;
    if ($participant_id > 0) {
        $pdo->prepare("UPDATE participants SET last_activity = NOW() WHERE id = ?")
            ->execute([$participant_id]);
    }
    $stmt = $pdo->prepare("
        SELECT p.*, g.nom as groupe_nom
        FROM participants p
        LEFT JOIN groupes g ON g.id = p.groupe_id
        WHERE p.id = ?
    ");
    $stmt->execute([$participant_id]);
    $participant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$participant) {
        echo json_encode(['success' => false, 'error' => 'Participant introuvable']);
        exit;
    }

$pdo->exec("DELETE FROM participants WHERE last_activity < DATE_SUB(NOW(), INTERVAL 1 MINUTE) AND id NOT IN (SELECT DISTINCT participant_id FROM reponses)");

    $stmt_nb = $pdo->prepare("
        SELECT COUNT(*) FROM participants 
        WHERE session_id = ?
    ");
    $stmt_nb->execute([$participant['session_id']]);
    $nb = $stmt_nb->fetchColumn();

        $groupe_id = $participant['groupe_id'];

    // Chercher d'abord si une finale est en cours
    $stmt_finale = $pdo->prepare("
        SELECT * FROM sessions_quiz
        WHERE statut = 'en_cours'
        AND type_round = 'finale'
        ORDER BY id DESC LIMIT 1
    ");
    $stmt_finale->execute();
    $session_finale = $stmt_finale->fetch(PDO::FETCH_ASSOC);

    if ($participant_id > 0) {
        $stmt_upd = $pdo->prepare("UPDATE participants SET last_activity = NOW() WHERE id = ?");
        $stmt_upd->execute([$participant_id]);
    }

    if ($session_finale) {
        // Vérifier que CE participant est bien finaliste
        $stmt_check = $pdo->prepare("
            SELECT COUNT(*) FROM (
                SELECT p2.id,
                       COALESCE(s2.total_points, 0) as pts,
                       MAX(COALESCE(s2.total_points, 0)) OVER (PARTITION BY p2.groupe_id) as max_pts
                FROM participants p2
                LEFT JOIN scores s2 ON s2.participant_id = p2.id
                WHERE p2.session_id = ? AND p2.groupe_id = ?
            ) t
            WHERE t.id = ? AND t.pts = t.max_pts
        ");
        $stmt_check->execute([$participant['session_id'], $groupe_id, $participant_id]);
        $est_finaliste = $stmt_check->fetchColumn() > 0;

        if ($est_finaliste) {
            $session = $session_finale;
        } else {
            $session = null;
        }
    } else {
        // Pas de finale — chercher le round du groupe
        $type_round = 'first_round_' . $groupe_id;
        $stmt_session = $pdo->prepare("
            SELECT * FROM sessions_quiz
            WHERE statut = 'en_cours'
            AND type_round = ?
            ORDER BY id DESC LIMIT 1
        ");
        $stmt_session->execute([$type_round]);
        $session = $stmt_session->fetch(PDO::FETCH_ASSOC);

       
// uniquement si ce participant est impliqué dans le départage
if (!$session) {
    $stmt_dep = $pdo->prepare("
        SELECT * FROM sessions_quiz
        WHERE statut = 'en_cours'
        AND type_round = 'departage'
        AND groupe_id = ?
        ORDER BY id DESC LIMIT 1
    ");
    $stmt_dep->execute([$groupe_id]);
    $session = $stmt_dep->fetch(PDO::FETCH_ASSOC);
}
    }

    if (!$session) {
        echo json_encode([
            'session_phase'   => 'attente',
            'nb_participants' => (int)$nb,
            'groupe_nom'      => $participant['groupe_nom']
        ]);
        exit;
    }

    if (!$session['chrono_demarre']) {
        echo json_encode([
            'session_phase'   => 'attente',
            'nb_participants' => (int)$nb,
            'groupe_nom'      => $participant['groupe_nom']
        ]);
        exit;
    }

    $questions = json_decode($session['questions_ids'] ?? '[]', true);
    $index     = (int)($session['question_actuelle'] ?? 0);

   if (!$questions || $index >= count($questions)) {
    // Si c'était un départage, renvoyer vers l'écran de fin normal
    if ($session['type_round'] === 'departage') {
        echo json_encode([
            'session_phase' => 'attente',
            'nb_participants' => (int)$nb,
            'groupe_nom' => $participant['groupe_nom']
        ]);
    } else {
        echo json_encode(['session_phase' => 'termine', 'score_total' => 0]);
    }
    exit;
}

    $qid  = $questions[$index];
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$qid]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);
    unset($question['bonne_reponse']);

    echo json_encode([
        'session_phase'   => 'en_cours',
        'question'        => $question,
        'question_index'  => $index + 1,
        'total_questions' => count($questions),
        'round'           => $session['type_round'] === 'finale' ? 'finale' : str_replace('first_round_', '', $session['type_round']),
        'nb_participants' => (int)$nb,
        'groupe_nom'      => $participant['groupe_nom'],
        'chrono_demarre'  => (bool)$session['chrono_demarre']
    ]);
    exit;
}

// =========================
// RÉPONDRE
// =========================
elseif ($action === 'repondre') {

    $participant_id = $data['participant_id'] ?? 0;
    $question_id    = $data['question_id']    ?? 0;
    $reponse        = $data['reponse']        ?? 0;
    $temps_reponse  = (float)($data['temps_reponse'] ?? 10);

    // 1. Sécurité : Vérifier l'ID
    if ($participant_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'ID Participant manquant']);
        exit;
    }

    // 2. Mise à jour de l'activité
    $pdo->prepare("UPDATE participants SET last_activity = NOW() WHERE id = ?")
        ->execute([$participant_id]);

    // 3. Vérifier si déjà répondu
    $check = $pdo->prepare("SELECT id FROM reponses WHERE participant_id = ? AND question_id = ?");
    $check->execute([$participant_id, $question_id]);
    if ($check->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Déjà répondu']);
        exit;
    }

    // 4. Récupérer la bonne réponse
    $stmt = $pdo->prepare("SELECT bonne_reponse FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    $q = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$q) {
        echo json_encode(['success' => false, 'error' => 'Question introuvable']);
        exit;
    }

    // 5. Calcul des points
    $correct = ((int)$reponse === (int)$q['bonne_reponse']);
    // Formule : 1000 pts max, -90 par seconde, minimum 100 si juste
    $points = $correct ? max(100, round(1000 - ($temps_reponse * 90))) : 0;

    // 6. Insertion de la réponse avec capture d'erreur
    try {
        $stmt = $pdo->prepare("
            INSERT INTO reponses (participant_id, question_id, reponse_donnee, points_obtenus, temps_reponse, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$participant_id, $question_id, (int)$reponse, (int)$points, $temps_reponse]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur SQL Reponse : ' . $e->getMessage()]);
        exit;
    }

    // 7. Vérifier si c'est une question de finale (via PHP pour éviter l'erreur 1064)
    $stmt_finale = $pdo->prepare("SELECT questions_ids FROM sessions_quiz WHERE type_round = 'finale' ORDER BY id DESC LIMIT 1");
    $stmt_finale->execute();
    $res_finale = $stmt_finale->fetch(PDO::FETCH_ASSOC);

    $est_question_finale = false;
    if ($res_finale) {
        $ids_finale = json_decode($res_finale['questions_ids'], true) ?: [];
        if (in_array($question_id, $ids_finale)) {
            $est_question_finale = true;
        }
    }

    // 8. Mettre à jour la table 'scores' 
    if (!$est_question_finale) {
        try {
            $stmt_score = $pdo->prepare("
                INSERT INTO scores (participant_id, total_points)
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE total_points = total_points + ?
            ");
            $stmt_score->execute([$participant_id, (int)$points, (int)$points]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => 'Erreur SQL Score : ' . $e->getMessage()]);
            exit;
        }
    }

    // 9. Succès
    echo json_encode([
        'success'       => true,
        'correct'       => $correct,
        'bonne_reponse' => (int)$q['bonne_reponse'],
        'points'        => (int)$points
    ]);
    exit;
}
// =========================
// PROCHAINE QUESTION — polling après réponse
// =========================
elseif ($action === 'prochaine_question') {
    $participant_id = $_GET['participant_id'] ?? 0;

    // Récupérer le groupe ET la session du participant
    $stmt_p = $pdo->prepare("SELECT groupe_id, session_id FROM participants WHERE id = ?");
    $stmt_p->execute([$participant_id]);
    $participant = $stmt_p->fetch(PDO::FETCH_ASSOC);
    $groupe_id  = $participant['groupe_id']  ?? null;
    $session_id = $participant['session_id'] ?? null;

   // Chercher d'abord si une finale est en cours
$stmt_finale = $pdo->prepare("
SELECT * FROM sessions_quiz
WHERE statut = 'en_cours'
AND type_round = 'finale'
ORDER BY id DESC LIMIT 1
");
$stmt_finale->execute();
$session_finale = $stmt_finale->fetch(PDO::FETCH_ASSOC);

$session = null;

if ($session_finale) {
// Vérifier que CE participant est bien finaliste (meilleur de son groupe)
$stmt_check = $pdo->prepare("
    SELECT COUNT(*) FROM (
        SELECT p2.id,
               COALESCE(s2.total_points, 0) as pts,
               MAX(COALESCE(s2.total_points, 0)) OVER (PARTITION BY p2.groupe_id) as max_pts
        FROM participants p2
        LEFT JOIN scores s2 ON s2.participant_id = p2.id
        WHERE p2.session_id = ? AND p2.groupe_id = ?
    ) t
    WHERE t.id = ? AND t.pts = t.max_pts
");
$stmt_check->execute([$session_id, $groupe_id, $participant_id]);
$est_finaliste = $stmt_check->fetchColumn() > 0;

if ($est_finaliste) {
    $session = $session_finale;
}
}

if (!$session) {
// Chercher le round du groupe (en cours ou terminé)
$type_round = 'first_round_' . $groupe_id;
$stmt_s = $pdo->prepare("
    SELECT * FROM sessions_quiz
    WHERE statut = 'en_cours' AND type_round = ?
    ORDER BY id DESC LIMIT 1
");
$stmt_s->execute([$type_round]);
$session = $stmt_s->fetch(PDO::FETCH_ASSOC);

}

    // Déterminer si c'est la finale
    $est_finale = ($session && $session['type_round'] === 'finale');

    // Fonction helper pour calculer score et rang
    $questions_session = $session ? json_decode($session['questions_ids'] ?? '[]', true) : [];

    if (!$session) {

    // Vérifier un départage RÉCENT (créé après le début de la session courante)
$stmt_dep = $pdo->prepare("
    SELECT questions_ids, groupe_id FROM sessions_quiz 
    WHERE type_round = 'departage'
    AND groupe_id = ?
    ORDER BY id DESC LIMIT 1
");
$stmt_dep->execute([$groupe_id]);
$dep = $stmt_dep->fetch(PDO::FETCH_ASSOC);

// Vérifier que CE participant a répondu à la question du départage
$a_participe_departage = false;
if ($dep) {
    $questions_dep_check = json_decode($dep['questions_ids'], true);
    if (!empty($questions_dep_check)) {
        $stmt_check_dep = $pdo->prepare("
            SELECT COUNT(*) FROM reponses 
            WHERE participant_id = ? 
            AND question_id = ?
        ");
        $stmt_check_dep->execute([$participant_id, $questions_dep_check[0]]);
        $a_participe_departage = $stmt_check_dep->fetchColumn() > 0;
    }
}

if ($dep && $a_participe_departage) {
        $questions_dep = json_decode($dep['questions_ids'], true);
        $placeholders  = implode(',', array_fill(0, count($questions_dep), '?'));

        $stmt = $pdo->prepare("
            SELECT COALESCE(SUM(points_obtenus), 0)
            FROM reponses
            WHERE participant_id = ?
            AND question_id IN ($placeholders)
        ");
        $stmt->execute(array_merge([$participant_id], $questions_dep));
        $score = $stmt->fetchColumn();

        $stmt_rang = $pdo->prepare("
            SELECT COUNT(*) + 1 FROM (
                SELECT r.participant_id, SUM(r.points_obtenus) as total
                FROM reponses r
                WHERE r.question_id IN ($placeholders)
                GROUP BY r.participant_id
            ) t WHERE t.total > ?
        ");
        $stmt_rang->execute(array_merge($questions_dep, [$score]));
        $mon_rang = $stmt_rang->fetchColumn();

        echo json_encode([
            'phase'       => 'fin',
            'round'       => 'departage',
            'score_total' => (int)$score,
            'mon_rang'    => (int)$mon_rang,
            'qualifie'    => ($mon_rang == 1)
        ]);
        exit;
    }

        // Récupérer les questions du round terminé
        $type_round_fini = 'first_round_' . $groupe_id;
        $stmt_sq = $pdo->prepare("
            SELECT questions_ids FROM sessions_quiz 
            WHERE type_round = ? 
            ORDER BY id DESC LIMIT 1
        ");
        $stmt_sq->execute([$type_round_fini]);
        $sq = $stmt_sq->fetch(PDO::FETCH_ASSOC);
        $questions_round = json_decode($sq['questions_ids'] ?? '[]', true);
    
        if (!empty($questions_round)) {
            // Score uniquement des questions du round
            $placeholders = implode(',', array_fill(0, count($questions_round), '?'));
            $stmt = $pdo->prepare("
                SELECT COALESCE(SUM(points_obtenus), 0)
                FROM reponses
                WHERE participant_id = ?
                AND question_id IN ($placeholders)
            ");
            $stmt->execute(array_merge([$participant_id], $questions_round));
            $score = $stmt->fetchColumn();
    
            // Rang uniquement sur les questions du round
            $stmt_rang = $pdo->prepare("
                SELECT COUNT(*) + 1 FROM (
                    SELECT r2.participant_id, SUM(r2.points_obtenus) as total
                    FROM reponses r2
                    JOIN participants p2 ON p2.id = r2.participant_id
                    WHERE r2.question_id IN ($placeholders)
                    AND p2.groupe_id  = ?
                    AND p2.session_id = ?
                    GROUP BY r2.participant_id
                ) t WHERE t.total > ?
            ");
            $stmt_rang->execute(array_merge($questions_round, [$groupe_id, $session_id, $score]));
            $mon_rang = $stmt_rang->fetchColumn();
        } else {
            $score    = 0;
            $mon_rang = 1;
        }
    
        $qualifie = ($mon_rang == 1);
    
        echo json_encode([
            'phase'       => 'fin',
            'score_total' => (int)$score,
            'mon_rang'    => (int)$mon_rang,
            'qualifie'    => $qualifie
        ]);
        exit;
    }

    $questions = json_decode($session['questions_ids'] ?? '[]', true);
    $index     = (int)($session['question_actuelle'] ?? 0);
    $qid       = $questions[$index] ?? null;

    if (!$qid) {
        if ($est_finale) {
            // En finale : ne declarer "fin" que si la session est vraiment terminee en base
            $stmt_statut = $pdo->prepare("SELECT statut FROM sessions_quiz WHERE id = ?");
            $stmt_statut->execute([$session['id']]);
            $statut_session = $stmt_statut->fetchColumn();

            if ($statut_session !== 'termine') {
                // La question_actuelle depasse le tableau temporairement entre 2 questions
                // On attend que l'admin valide la fin officielle
                echo json_encode(['phase' => 'attente_suivante', 'score_total' => 0, 'mon_rang' => 0]);
                exit;
            }

            $placeholders = implode(',', array_fill(0, count($questions), '?'));
            $stmt = $pdo->prepare("
                SELECT COALESCE(SUM(points_obtenus), 0) 
                FROM reponses 
                WHERE participant_id = ? 
                AND question_id IN ($placeholders)
            ");
            $stmt->execute(array_merge([$participant_id], $questions));
            $score = $stmt->fetchColumn();

            $stmt_rang = $pdo->prepare("
                SELECT COUNT(*) + 1 FROM (
                    SELECT r.participant_id, SUM(r.points_obtenus) as total
                    FROM reponses r
                    JOIN participants p2 ON p2.id = r.participant_id
                    WHERE r.question_id IN ($placeholders)
                    AND p2.session_id = ?
                    GROUP BY r.participant_id
                ) t WHERE t.total > ?
            ");
            $stmt_rang->execute(array_merge($questions, [$session_id, $score]));
            $mon_rang = $stmt_rang->fetchColumn();

        } else {
            $stmt = $pdo->prepare("SELECT COALESCE(SUM(points_obtenus),0) FROM reponses WHERE participant_id = ?");
            $stmt->execute([$participant_id]);
            $score = $stmt->fetchColumn();

            $stmt_rang = $pdo->prepare("
                SELECT COUNT(*) + 1 FROM (
                    SELECT p2.id, SUM(r2.points_obtenus) as total
                    FROM reponses r2
                    JOIN participants p2 ON p2.id = r2.participant_id
                    WHERE p2.groupe_id  = ?
                    AND   p2.session_id = ?
                    GROUP BY p2.id
                ) t WHERE t.total > ?
            ");
            $stmt_rang->execute([$groupe_id, $session_id, $score]);
            $mon_rang = $stmt_rang->fetchColumn();
        }

        $qualifie = ($mon_rang == 1);

        echo json_encode([
            'phase'       => 'fin',
            'round'       => $est_finale ? 'finale' : 'round',
            'score_total' => (int)$score,
            'mon_rang'    => (int)$mon_rang,
            'qualifie'    => $qualifie
        ]);
        exit;
    }

    // Le participant a-t-il déjà répondu à cette question ?
    $stmt = $pdo->prepare("
        SELECT r.reponse_donnee as reponse, r.points_obtenus as points, q.bonne_reponse
        FROM reponses r
        JOIN questions q ON q.id = r.question_id
        WHERE r.participant_id = ? AND r.question_id = ?
    ");
    $stmt->execute([$participant_id, $qid]);
    $reponse = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reponse) {

        if ($est_finale) {
            // Score uniquement des questions de la finale
            $placeholders = implode(',', array_fill(0, count($questions), '?'));
            $stmt2 = $pdo->prepare("
                SELECT COALESCE(SUM(points_obtenus), 0) 
                FROM reponses 
                WHERE participant_id = ? 
                AND question_id IN ($placeholders)
            ");
            $stmt2->execute(array_merge([$participant_id], $questions));
            $scoreTotal = $stmt2->fetchColumn();

            // Rang finale
            $stmt_rang = $pdo->prepare("
                SELECT COUNT(*) + 1 FROM (
                    SELECT r.participant_id, SUM(r.points_obtenus) as total
                    FROM reponses r
                    JOIN participants p2 ON p2.id = r.participant_id
                    WHERE r.question_id IN ($placeholders)
                    AND p2.session_id = ?
                    GROUP BY r.participant_id
                ) t WHERE t.total > ?
            ");
            $stmt_rang->execute(array_merge($questions, [$session_id, $scoreTotal]));
            $rang = $stmt_rang->fetchColumn();

        } else {
            $stmt2 = $pdo->prepare("SELECT COALESCE(SUM(points_obtenus),0) FROM reponses WHERE participant_id = ?");
            $stmt2->execute([$participant_id]);
            $scoreTotal = $stmt2->fetchColumn();

            $stmt_rang = $pdo->prepare("
                SELECT COUNT(*) + 1 FROM (
                    SELECT p2.id, SUM(r2.points_obtenus) as total
                    FROM reponses r2
                    JOIN participants p2 ON p2.id = r2.participant_id
                    WHERE p2.groupe_id  = ?
                    AND   p2.session_id = ?
                    GROUP BY p2.id
                ) t WHERE t.total > ?
            ");
            $stmt_rang->execute([$groupe_id, $session_id, $scoreTotal]);
            $rang = $stmt_rang->fetchColumn();
        }

        $correct = ((int)$reponse['reponse'] === (int)$reponse['bonne_reponse']);

        echo json_encode([
            'phase'           => 'attente_suivante',
            'correct'         => $correct,
            'points_question' => (int)$reponse['points'],
            'score_total'     => (int)$scoreTotal,
            'mon_rang'        => (int)$rang,
            'bonne_reponse'   => (int)$reponse['bonne_reponse']
        ]);

    } else {
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$qid]);
        $question = $stmt->fetch(PDO::FETCH_ASSOC);
        unset($question['bonne_reponse']);

        echo json_encode([
            'phase'           => 'question',
            'question'        => $question,
            'question_id'     => $qid,
            'question_index'  => $index + 1,
            'total_questions' => count($questions),
            'round'           => $est_finale ? 'finale' : str_replace('first_round_', '', $session['type_round'])
        ]);
    }
    exit;
}
// =========================
// LISTER LES PARTICIPANTS
// =========================
elseif ($action === 'list') {

$pdo->exec("DELETE FROM participants WHERE last_activity < DATE_SUB(NOW(), INTERVAL 2 MINUTE)");
    // Récupérer la session active
    $session = $pdo->query("
        SELECT id FROM sessions 
        WHERE statut = 'waiting' OR statut = 'active'
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    if (!$session) {
        echo json_encode([]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT p.id, p.nom, p.groupe_id, p.created_at, g.nom as groupe_nom
        FROM participants p
        LEFT JOIN groupes g ON g.id = p.groupe_id
        WHERE p.session_id = ?
        ORDER BY p.id ASC
    ");
    $stmt->execute([$session['id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// =========================
// TIRAGE AU SORT
// =========================
elseif ($action === 'tirage') {
    require_once '../includes/functions.php';
    $check = $pdo->query("SELECT COUNT(*) FROM groupes")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO groupes (nom) VALUES 
            ('First Round 1'), ('First Round 2'), ('First Round 3')");
    }
    dispatchParticipants($pdo);
    echo json_encode(['success' => true, 'message' => 'Tirage au sort effectué !']);
    exit;
}

// =========================
// SUPPRIMER UN PARTICIPANT
// =========================
elseif ($action === 'delete') {
    $id = $data['id'] ?? 0;
    $stmt = $pdo->prepare("DELETE FROM participants WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
    exit;
}

// =========================
// FINALISTES
// =========================
elseif ($action === 'finalistes') {
    require_once '../includes/functions.php';
    $finalistes = selectionnerFinalistes($pdo);
    foreach ($finalistes as &$f) {
        $stmt = $pdo->prepare("
            SELECT g.nom FROM groupes g
            JOIN participants p ON p.groupe_id = g.id
            WHERE p.id = ?
        ");
        $stmt->execute([$f['id']]);
        $groupe = $stmt->fetch(PDO::FETCH_ASSOC);
        $f['groupe'] = $groupe ? $groupe['nom'] : '—';
    }
    echo json_encode(['finalistes' => $finalistes]);
    exit;
}

// =========================
// COMPTER
// =========================
elseif ($action === 'count') {
    $count = $pdo->query("SELECT COUNT(*) FROM participants")->fetchColumn();
    echo json_encode(['count' => $count]);
    exit;
}





elseif ($action === 'count_groupe') {
    $groupe_id = $_GET['groupe_id'] ?? 0;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM participants WHERE groupe_id = ?");
    $stmt->execute([$groupe_id]);
    echo json_encode(['count' => (int)$stmt->fetchColumn()]);
    exit;
}





elseif ($action === 'count_reponses') {
    $question_id = $_GET['question_id'] ?? 0;
    $groupe_id   = $_GET['groupe_id']   ?? 0;
    $session_id  = $_GET['session_id']  ?? 0;

    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM reponses r
        JOIN participants p ON p.id = r.participant_id
        WHERE r.question_id = ?
        AND p.groupe_id = ?
        AND p.session_id = ?
    ");
    $stmt->execute([$question_id, $groupe_id, $session_id]);
    echo json_encode(['count' => (int)$stmt->fetchColumn()]);
    exit;
}


elseif ($action === 'meilleur_round') {
    $groupe_id = $_GET['groupe_id'] ?? 0;

    $stmt = $pdo->prepare("
        SELECT p.id, p.nom, SUM(r.points_obtenus) as total_points
        FROM reponses r
        JOIN participants p ON p.id = r.participant_id
        WHERE p.groupe_id = ?
        GROUP BY p.id, p.nom
        ORDER BY total_points DESC
        LIMIT 1
    ");
    $stmt->execute([$groupe_id]);
    $participant = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['participant' => $participant ?: null]);
    exit;
}
// =========================
// DEFAULT
// =========================
echo json_encode(['error' => 'Action inconnue']);