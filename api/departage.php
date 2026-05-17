<?php
require_once '../config.php';
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? $_GET['action'] ?? '';

// LANCER UNE QUESTION DE DÉPARTAGE

if ($action === 'lancer') {
    $session_id = $data['session_id'] ?? null;
    $participants = $data['participants'] ?? [];
    
    if (!$session_id || count($participants) < 2) {
        echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
        exit;
    }
    
    // Exclure les questions déjà posées en finale
    $stmt = $pdo->prepare("
        SELECT questions_ids FROM sessions_quiz 
        WHERE type_round = 'finale' 
        ORDER BY id DESC LIMIT 1
    ");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $dejaPosees = $row ? json_decode($row['questions_ids'], true) : [];
    
    // Prendre une question non encore posée
    $placeholders = count($dejaPosees) > 0 
        ? 'AND id NOT IN (' . implode(',', array_map('intval', $dejaPosees)) . ')' 
        : '';
    
    $stmt = $pdo->query("
        SELECT * FROM questions 
        WHERE 1=1 $placeholders 
        ORDER BY RAND() LIMIT 1
    ");
    $question = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$question) {
        echo json_encode(['success' => false, 'error' => 'Aucune question disponible']);
        exit;
    }
    
    // Créer la session_quiz de départage
    $stmt = $pdo->prepare("
        INSERT INTO sessions_quiz 
            (statut, type_round, questions_ids, chrono_demarre, question_actuelle) 
        VALUES 
            ('en_cours', 'departage', ?, 0, ?)
    ");
    $stmt->execute([json_encode([$question['id']]), $question['id']]);
    
    echo json_encode([
        'success'      => true,
        'question'     => $question,
        'participants' => $participants
    ]);
    exit;
}

// ========================
// TOP CHRONO DÉPARTAGE
// ========================
if ($action === 'top_chrono') {
    $question_id = $data['question_id'] ?? null;
    
    // Mettre à jour la session_quiz de départage active
    $stmt = $pdo->prepare("
        UPDATE sessions_quiz 
        SET chrono_demarre = 1, chrono_debut = NOW()
        WHERE type_round = 'departage' AND statut = 'en_cours'
        ORDER BY id DESC LIMIT 1
    ");
    $stmt->execute();
    
    echo json_encode(['success' => true, 'message' => 'Chrono lancé']);
    exit;
}

// ========================
// VÉRIFIER LE RÉSULTAT DU DÉPARTAGE
// ========================
if ($action === 'verifier') {
    $question_id     = $data['question_id'] ?? null;
    $participant_ids = $data['participant_ids'] ?? [];
    
    if (!$question_id || count($participant_ids) < 2) {
        echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
        exit;
    }
    
    $stmt = $pdo->prepare("
        SELECT r.participant_id, r.reponse_donnee as reponse, 
               r.temps_reponse, p.nom
        FROM reponses r
        JOIN participants p ON r.participant_id = p.id
        WHERE r.question_id = ? 
        AND r.participant_id IN (?, ?)
        ORDER BY r.temps_reponse ASC
    ");
    $stmt->execute([$question_id, $participant_ids[0], $participant_ids[1]]);
    $reponses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("SELECT bonne_reponse FROM questions WHERE id = ?");
    $stmt->execute([$question_id]);
    $bonne_reponse = $stmt->fetchColumn();
    
    $resultat = [
        'success'      => true,
        'bonne_reponse'=> $bonne_reponse,
        'reponses'     => $reponses,
        'termine'      => false
    ];
    
    if (count($reponses) >= 2) {
        $resultat['termine'] = true;
        $p1 = $reponses[0];
        $p2 = $reponses[1];
        $p1_correct = ($p1['reponse'] == $bonne_reponse);
        $p2_correct = ($p2['reponse'] == $bonne_reponse);
        
        if ($p1_correct && !$p2_correct) {
            $resultat['gagnant'] = $p1;
            $resultat['raison']  = 'bonne_reponse';
        } elseif (!$p1_correct && $p2_correct) {
            $resultat['gagnant'] = $p2;
            $resultat['raison']  = 'bonne_reponse';
        } elseif ($p1_correct && $p2_correct) {
            $gagnant = ($p1['temps_reponse'] <= $p2['temps_reponse']) ? $p1 : $p2;
            $resultat['gagnant'] = $gagnant;
            $resultat['raison']  = 'temps';
        } else {
            $resultat['gagnant'] = null;
            $resultat['raison']  = 'aucun';
        }
        
        // Clôturer la session_quiz de départage
        $pdo->prepare("
            UPDATE sessions_quiz SET statut = 'termine'
            WHERE type_round = 'departage' AND statut = 'en_cours'
        ")->execute();
    }
    
    echo json_encode($resultat);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Action inconnue']);