<?php
require_once '../config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$data   = [];

if (empty($action) || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data   = json_decode(file_get_contents('php://input'), true) ?? [];
    $action = $data['action'] ?? $action;
}

// =========================
// QUESTION ACTUELLE
// =========================
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

    if (empty($questions) || $index >= count($questions)) {
        echo json_encode(['question' => null]);
        exit;
    }

    
    

    $qid  = $questions[$index];
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$qid]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ne pas envoyer la bonne réponse au participant !
    unset($question['bonne_reponse']);

    echo json_encode([
        'question' => $question,
        'numero'   => $index + 1,
        'total'    => count($questions)
    ]);
    exit;
}

// =========================
// DÉMARRER UN ROUND
// =========================
elseif ($action === 'demarrer') {

    $round = $data['round'] ?? 1;
    require_once '../includes/functions.php';

    $nb_questions = ($round === 'finale') ? 5 : 10;
    $questions    = getQuestionsAleatoires($pdo, $nb_questions);
    $ids          = array_column($questions, 'id');

    // Fermer sessions précédentes
    $pdo->exec("UPDATE sessions_quiz SET statut = 'termine' WHERE statut = 'en_cours'");

    // Créer nouvelle session
    $stmt = $pdo->prepare("
        INSERT INTO sessions_quiz 
        (statut, question_actuelle, type_round, questions_ids, chrono_demarre) 
        VALUES ('en_cours', 0, ?, ?, 0)
    ");
    $stmt->execute([
        $round === 'finale' ? 'finale' : 'first_round_' . $round,
        json_encode($ids)
    ]);

    echo json_encode([
        'success'   => true,
        'questions' => $questions,  // ← renvoyer les questions à l'admin
        'message'   => 'Round ' . $round . ' démarré !'
    ]);
    exit;
}

// =========================
// TOP CHRONO
// =========================
elseif ($action === 'top_chrono') {

    $session = $pdo->query("
        SELECT * FROM sessions_quiz 
        WHERE statut = 'en_cours' 
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

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

// =========================
// QUESTION SUIVANTE
// =========================
elseif ($action === 'suivante') {

    $session = $pdo->query("
        SELECT * FROM sessions_quiz 
        WHERE statut = 'en_cours' 
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    if ($session) {
        $nouveau_index = $session['question_actuelle'] + 1;
        $questions     = json_decode($session['questions_ids'], true);

        if ($nouveau_index >= count($questions)) {
            $pdo->exec("UPDATE sessions_quiz SET statut = 'termine' WHERE statut = 'en_cours'");
            echo json_encode(['success' => true, 'termine' => true]);
        } else {
            $pdo->prepare("
                UPDATE sessions_quiz 
                SET question_actuelle = ?, chrono_demarre = 0 
                WHERE id = ?
            ")->execute([$nouveau_index, $session['id']]);
            echo json_encode(['success' => true, 'termine' => false]);
        }
    }
    exit;
}

// =========================
// STATUT DE LA SESSION
// =========================
elseif ($action === 'statut') {

    $session = $pdo->query("
        SELECT * FROM sessions_quiz 
        WHERE statut = 'en_cours' 
        ORDER BY id DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'actif'  => (bool)$session,
        'statut' => $session ? $session['statut'] : 'en_attente',
        'round'  => $session ? $session['type_round'] : null
    ]);
    exit;
}

// =========================
// AFFICHER STATS QUESTION
// =========================
elseif ($action === 'stats_question') {

    $question_id = $data['question_id'] ?? $_GET['question_id'] ?? 0;

    $stmt = $pdo->prepare("
        SELECT reponse, COUNT(*) as nb
        FROM reponses 
        WHERE question_id = ?
        GROUP BY reponse
    ");
    $stmt->execute([$question_id]);
    $repartition = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare("SELECT bonne_reponse FROM questions WHERE id = ?");
    $stmt2->execute([$question_id]);
    $q = $stmt2->fetch();

    echo json_encode([
        'repartition'   => $repartition,
        'bonne_reponse' => $q['bonne_reponse'] ?? null
    ]);
    exit;
}


// =========================
// CRÉER UNE SESSION (code Kahoot)
// =========================
elseif ($action === 'creer') {

    // Invalider les anciennes sessions en attente
    $pdo->exec("UPDATE sessions SET statut = 'done' WHERE statut = 'waiting'");

    // Générer un code unique à 6 chiffres
    do {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $stmt = $pdo->prepare("SELECT id FROM sessions WHERE code = ?");
        $stmt->execute([$code]);
    } while ($stmt->fetch());

    $stmt = $pdo->prepare("INSERT INTO sessions (code, statut) VALUES (?, 'waiting')");
    $stmt->execute([$code]);

    echo json_encode([
        'success'    => true,
        'code'       => $code,
        'session_id' => $pdo->lastInsertId()
    ]);
    exit;
}

// =========================
// STATUT SESSION PAR CODE (polling participants)
// =========================
elseif ($action === 'statut_code') {

    $code = trim($_GET['code'] ?? '');
    if (!$code) {
        echo json_encode(['success' => false, 'error' => 'Code manquant']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM sessions WHERE code = ?");
    $stmt->execute([$code]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$session) {
        echo json_encode(['success' => false, 'error' => 'Code invalide']);
        exit;
    }

    $stmt2 = $pdo->prepare("SELECT COUNT(*) as nb FROM participants WHERE session_id = ?");
    $stmt2->execute([$session['id']]);
    $nb = $stmt2->fetch(PDO::FETCH_ASSOC)['nb'];

    echo json_encode([
        'success'         => true,
        'statut'          => $session['statut'],
        'nb_participants' => (int)$nb,
        'session_id'      => $session['id']
    ]);
    exit;
}

// =========================
// PARTICIPANTS D'UNE SESSION (admin live)
// =========================
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

// =========================
// DÉMARRER LA SESSION (organisateur)
// =========================
elseif ($action === 'demarrer_session') {

    $session_id = $data['session_id'] ?? 0;
    if (!$session_id) {
        echo json_encode(['success' => false, 'error' => 'session_id requis']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE sessions SET statut = 'active' WHERE id = ?");
    $stmt->execute([$session_id]);

    echo json_encode(['success' => true, 'message' => 'Session démarrée !']);
    exit;
}

// =========================
// REJOINDRE UNE SESSION (participant)
// =========================
elseif ($action === 'rejoindre') {

    $code = trim($data['code'] ?? '');
    $nom  = trim($data['nom'] ?? '');

    if (!$code || !$nom) {
        echo json_encode(['success' => false, 'error' => 'Code et nom requis']);
        exit;
    }

    // Vérifier la session
    $stmt = $pdo->prepare("SELECT * FROM sessions WHERE code = ?");
    $stmt->execute([$code]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$session) {
        echo json_encode(['success' => false, 'error' => 'Code invalide. Vérifiez le code affiché.']);
        exit;
    }
    if ($session['statut'] === 'done') {
        echo json_encode(['success' => false, 'error' => 'Cette session est terminée.']);
        exit;
    }
    if ($session['statut'] === 'active') {
        echo json_encode(['success' => false, 'error' => 'La compétition a déjà commencé.']);
        exit;
    }

    // Nom déjà pris dans cette session ?
    $stmt2 = $pdo->prepare("SELECT id FROM participants WHERE session_id = ? AND nom = ?");
    $stmt2->execute([$session['id'], $nom]);
    if ($stmt2->fetch()) {
        echo json_encode(['success' => false, 'error' => 'Ce nom est déjà utilisé.']);
        exit;
    }

    // Insérer le participant
    $stmt3 = $pdo->prepare("
        INSERT INTO participants (nom, session_id, session_code, created_at) 
        VALUES (?, ?, ?, NOW())
    ");
    $stmt3->execute([$nom, $session['id'], $code]);

    $stmt4 = $pdo->prepare("SELECT COUNT(*) as nb FROM participants WHERE session_id = ?");
    $stmt4->execute([$session['id']]);
    $nb = $stmt4->fetch(PDO::FETCH_ASSOC)['nb'];

    echo json_encode([
        'success'         => true,
        'participant_id'  => $pdo->lastInsertId(),
        'session_id'      => $session['id'],
        'nb_participants' => (int)$nb
    ]);
    exit;
}

echo json_encode(['error' => 'Action inconnue: ' . $action]);