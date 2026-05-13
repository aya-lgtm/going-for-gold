<?php
require_once '../config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$data   = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? $action;

/* =========================================================
   QUESTION ACTUELLE
========================================================= */
if ($action === 'question_actuelle') {

    $session = $pdo->query("
        SELECT * FROM sessions_quiz 
        WHERE statut = 'en_cours' 
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    if (!$session) {
        echo json_encode(['question' => null]);
        exit;
    }

    $questions = json_decode($session['questions_ids'] ?? '[]', true);
    $index     = $session['question_actuelle'] ?? 0;

    if (!$questions || $index >= count($questions)) {
        echo json_encode(['question' => null]);
        exit;
    }

    $qid = $questions[$index];

    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$qid]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    unset($question['bonne_reponse']);

    echo json_encode([
        'question' => $question,
        'numero'   => $index + 1,
        'total'    => count($questions)
    ]);
    exit;
}


/* =========================================================
   DEMARRER ROUND + SESSION (UNIFIÉ)
========================================================= */
elseif ($action === 'demarrer_round_unifie') {

    // Définir $round EN PREMIER
    $round = $data['round'] ?? 1;
    $session_id = $data['session_id'] ?? 0;

    // Vérifier si ce round est déjà en cours
    $type_round_check = ($round === 'finale') ? 'finale' : 'first_round_' . $round;
    $enCours = $pdo->prepare("
        SELECT COUNT(*) FROM sessions_quiz 
        WHERE statut = 'en_cours' AND type_round = ?
    ");
    $enCours->execute([$type_round_check]);
    if ($enCours->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'error' => 'Ce round est déjà en cours !']);
        exit;
    }

    // Activer session principale
    if ($session_id) {
        $pdo->prepare("UPDATE sessions SET statut = 'active' WHERE id = ?")
            ->execute([$session_id]);
    }

    // Générer questions
    require_once '../includes/functions.php';
    $nb_questions = ($round === 'finale') ? 5 : 10;
    $questions = getQuestionsAleatoires($pdo, $nb_questions);
    $ids = array_column($questions, 'id');

    // Fermer uniquement le même type de round
    $pdo->prepare("UPDATE sessions_quiz SET statut = 'termine' WHERE statut = 'en_cours' AND type_round = ?")
        ->execute([$type_round_check]);

    // Créer nouveau round
    $pdo->prepare("
        INSERT INTO sessions_quiz (statut, question_actuelle, type_round, questions_ids, chrono_demarre)
        VALUES ('en_cours', 0, ?, ?, 0)
    ")->execute([$type_round_check, json_encode($ids)]);

   
// Compter participants du groupe ET de la session courante
$groupe_id = ($round === 'finale') ? null : (int)$round;

// Récupérer la session active
$session_active = $pdo->query("
    SELECT id FROM sessions 
    WHERE statut IN ('waiting','active') 
    ORDER BY id DESC LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

$nb_stmt = $pdo->prepare("
    SELECT COUNT(*) FROM participants 
    WHERE groupe_id = ? AND session_id = ?
");
$nb_stmt->execute([$groupe_id, $session_active['id'] ?? 0]);
$nb_participants = $nb_stmt->fetchColumn();

echo json_encode([
    'success'         => true,
    'session_started' => true,
    'questions'       => $questions,
    'nb_participants' => (int)$nb_participants
]);
exit;
    
}


/* =========================================================
   TOP CHRONO
========================================================= */
elseif ($action === 'top_chrono') {

    // Chercher d'abord la finale en cours
    $session = $pdo->query("
        SELECT * FROM sessions_quiz 
        WHERE statut = 'en_cours' AND type_round = 'finale'
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    // Sinon prendre n'importe quelle session en cours
    if (!$session) {
        $session = $pdo->query("
            SELECT * FROM sessions_quiz 
            WHERE statut = 'en_cours' 
            ORDER BY id DESC LIMIT 1
        ")->fetch(PDO::FETCH_ASSOC);
    }

    if ($session) {
        $pdo->prepare("
            UPDATE sessions_quiz 
            SET chrono_demarre = 1, chrono_debut = NOW() 
            WHERE id = ?
        ")->execute([$session['id']]);
    }

    echo json_encode(['success' => true]);
    exit;
}

/* =========================================================
   QUESTION SUIVANTE
========================================================= */
elseif ($action === 'suivante') {

    $session = $pdo->query("
        SELECT * FROM sessions_quiz 
        WHERE statut = 'en_cours' 
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    if ($session) {

        $index = $session['question_actuelle'] + 1;
        $questions = json_decode($session['questions_ids'], true);

        if ($index >= count($questions)) {

            $pdo->exec("UPDATE sessions_quiz SET statut = 'termine' WHERE statut = 'en_cours'");

            echo json_encode([
                'success' => true,
                'termine' => true
            ]);
        } else {

            $stmt = $pdo->prepare("
                UPDATE sessions_quiz 
                SET question_actuelle = ?, chrono_demarre = 0 
                WHERE id = ?
            ");

            $stmt->execute([$index, $session['id']]);

            echo json_encode([
                'success' => true,
                'termine' => false
            ]);
        }
    }

    exit;
}


/* =========================================================
   STATUT SESSION ROUND
========================================================= */
elseif ($action === 'statut') {

    $session = $pdo->query("
        SELECT * FROM sessions_quiz 
        WHERE statut = 'en_cours' 
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'actif'  => (bool)$session,
        'statut' => $session['statut'] ?? 'en_attente',
        'round'  => $session['type_round'] ?? null
    ]);
    exit;
}


/* =========================================================
   STATS QUESTION
========================================================= */
elseif ($action === 'stats_question') {

    $question_id = $data['question_id'] ?? $_GET['question_id'] ?? 0;

    $stmt = $pdo->prepare("
        SELECT reponse, COUNT(*) as nb
        FROM reponses 
        WHERE question_id = ?
        GROUP BY reponse
    ");
    $stmt->execute([$question_id]);

    $stmt2 = $pdo->prepare("SELECT bonne_reponse FROM questions WHERE id = ?");
    $stmt2->execute([$question_id]);
    $q = $stmt2->fetch();

    echo json_encode([
        'repartition'   => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'bonne_reponse' => $q['bonne_reponse'] ?? null
    ]);
    exit;
}


/* =========================================================
   CRÉER SESSION (CODE)
========================================================= */
elseif ($action === 'creer') {

    $pdo->exec("UPDATE sessions SET statut = 'done' WHERE statut = 'waiting'");
    
    // Terminer tous les anciens rounds
    $pdo->exec("UPDATE sessions_quiz SET statut = 'termine' WHERE statut = 'en_cours'");
    
    // Supprimer les questions et les réponses
    $pdo->exec("DELETE FROM reponses");
    $pdo->exec("DELETE FROM questions");
    $pdo->exec("DELETE FROM scores");

    do {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $stmt = $pdo->prepare("SELECT id FROM sessions WHERE code = ?");
        $stmt->execute([$code]);
    } while ($stmt->fetch());

    $stmt = $pdo->prepare("
        INSERT INTO sessions (code, statut)
        VALUES (?, 'waiting')
    ");
    $stmt->execute([$code]);

    echo json_encode([
        'success'    => true,
        'code'       => $code,
        'session_id' => $pdo->lastInsertId()
    ]);
    exit;
}
/* =========================================================
   STATUT PAR CODE
========================================================= */
elseif ($action === 'statut_code') {

    $code = trim($_GET['code'] ?? '');

    if (!$code) {
        echo json_encode(['success' => false]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM sessions WHERE code = ?");
    $stmt->execute([$code]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$session) {
        echo json_encode(['success' => false]);
        exit;
    }

    $stmt2 = $pdo->prepare("SELECT COUNT(*) as nb FROM participants WHERE session_id = ?");
    $stmt2->execute([$session['id']]);
    $nb = $stmt2->fetch()['nb'];

    echo json_encode([
        'success' => true,
        'statut' => $session['statut'],
        'nb_participants' => (int)$nb,
        'session_id' => $session['id']
    ]);
    exit;
}


/* =========================================================
   PARTICIPANTS LIVE
========================================================= */
elseif ($action === 'participants_session') {

    $session_id = $_GET['session_id'] ?? 0;

    $stmt = $pdo->prepare("
        SELECT id, nom, created_at 
        FROM participants 
        WHERE session_id = ?
        ORDER BY created_at ASC
    ");

    $stmt->execute([$session_id]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}


/* =========================================================
   REJOINDRE SESSION
========================================================= */
/* =========================================================
   REJOINDRE SESSION
========================================================= */
elseif ($action === 'rejoindre') {

    $code = trim($data['code'] ?? '');
    $nom  = trim($data['nom'] ?? '');

    if (!$code || !$nom) {
        echo json_encode(['success' => false]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM sessions WHERE code = ?");
    $stmt->execute([$code]);
    $session = $stmt->fetch();

    if (!$session || $session['statut'] !== 'waiting') {
        echo json_encode(['success' => false, 'error' => 'Session non disponible']);
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO participants (nom, session_id, session_code, created_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$nom, $session['id'], $code]);
    $participant_id = $pdo->lastInsertId();

    // Sauvegarder en session PHP
    session_start();
    $_SESSION['participant_id'] = $participant_id;
    $_SESSION['nom']            = $nom;
    $_SESSION['session_id']     = $session['id'];
    $_SESSION['groupe_nom']     = null;

    echo json_encode([
        'success'        => true,
        'participant_id' => $participant_id,
        'session_id'     => $session['id']
    ]);
    exit;
}

/* =========================================================
   DÉMARRER SESSION (fermer l'inscription)
========================================================= */
elseif ($action === 'demarrer_session') {

    $session_id = $data['session_id'] ?? 0;

    if (!$session_id) {
        echo json_encode(['success' => false, 'error' => 'session_id manquant']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE sessions SET statut = 'active' WHERE id = ?");
    $stmt->execute([$session_id]);

    echo json_encode(['success' => true]);
    exit;
}




elseif ($action === 'statut_round') {
    $round = $data['round'] ?? 1;
    $type_round = 'first_round_' . $round;

    // Chercher uniquement les sessions de la compétition en cours
    $stmt = $pdo->prepare("
        SELECT statut, questions_ids, question_actuelle 
        FROM sessions_quiz 
        WHERE type_round = ?
        AND created_at >= (
            SELECT created_at FROM sessions 
            WHERE statut IN ('waiting','active') 
            ORDER BY id DESC LIMIT 1
        )
        ORDER BY id DESC LIMIT 1
    ");
    $stmt->execute([$type_round]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$session) {
        echo json_encode(['statut' => 'en_attente']);
        exit;
    }

    $total = count(json_decode($session['questions_ids'] ?? '[]', true));
    echo json_encode([
        'statut' => $session['statut'],
        'total'  => $total
    ]);
    exit;
}
/* =========================================================
   DEFAULT
========================================================= */
echo json_encode(['error' => 'Action inconnue']);