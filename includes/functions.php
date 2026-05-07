<?php

/**
 * --- CRUD : GESTION DES QUESTIONS ---
 */

function getAllQuestions($pdo) {
    $stmt = $pdo->query("SELECT * FROM questions");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addQuestion($pdo, $label, $opt1, $opt2, $opt3, $opt4, $correct) {
    $stmt = $pdo->prepare("INSERT INTO questions 
        (texte, choix_1, choix_2, choix_3, choix_4, bonne_reponse) 
        VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$label, $opt1, $opt2, $opt3, $opt4, $correct]);
}

function updateQuestion($pdo, $id, $label, $opt1, $opt2, $opt3, $opt4, $correct) {
    $stmt = $pdo->prepare("UPDATE questions SET 
        texte=?, choix_1=?, choix_2=?, choix_3=?, choix_4=?, bonne_reponse=? 
        WHERE id=?");
    return $stmt->execute([$label, $opt1, $opt2, $opt3, $opt4, $correct, $id]);
}

function deleteQuestion($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
    return $stmt->execute([$id]);
}

function getQuestionById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * --- LOGIQUE DE SCORE ---
 */

 function calculateScore($tempsDeReponse) {
    // tempsDeReponse = combien de secondes le participant a mis pour répondre
    // Ex: répond en 2s → (10-2)*100 = 800 pts
    // Ex: répond en 9s → (10-9)*100 = 100 pts
    // Ex: répond en 10s ou plus → 0 pts
    if ($tempsDeReponse >= 10) return 0;
    if ($tempsDeReponse <= 0) return 1000;
    return (10 - $tempsDeReponse) * 100;
}

/**
 * --- TIRAGE AU SORT ---
 */

function dispatchParticipants($pdo) {
    $stmt = $pdo->query("SELECT id FROM participants LIMIT 75");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    shuffle($users);

    $groupes = array_chunk($users, 25);

    foreach ($groupes as $index => $groupe) {
        $groupe_id = $index + 1;
        foreach ($groupe as $user) {
            $stmt = $pdo->prepare("UPDATE participants SET groupe_id = ? WHERE id = ?");
            $stmt->execute([$groupe_id, $user['id']]);
        }
    }
    return true;
}


// Importer questions depuis Excel
function importQuestionsExcel($pdo, $fichier) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fichier);
    $rows = $spreadsheet->getActiveSheet()->toArray();
    
    foreach ($rows as $index => $row) {
        if ($index === 0) continue; // ignorer l'en-tête
        addQuestion($pdo, $row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
    }
    return true;
}

function exportQuestionsExcel($pdo) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $questions = getAllQuestions($pdo);
    
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // En-têtes
    $sheet->fromArray(['Question', 'Choix 1', 'Choix 2', 'Choix 3', 'Choix 4', 'Bonne réponse'], null, 'A1');
    
    // Données
    $row = 2;
    foreach ($questions as $q) {
        $sheet->fromArray([
            $q['texte'], $q['choix_1'], $q['choix_2'],
            $q['choix_3'], $q['choix_4'], $q['bonne_reponse']
        ], null, 'A' . $row);
        $row++;
    }
    
    // Télécharger
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="questions.xlsx"');
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
}


function getStatistiquesQuestion($pdo, $question_id) {
    $stmt = $pdo->prepare("
        SELECT reponse_donnee, COUNT(*) as nb
        FROM reponses
        WHERE question_id = ?
        GROUP BY reponse_donnee
    ");
    $stmt->execute([$question_id]);
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare("
        SELECT AVG(temps_reponse) as temps_moyen
        FROM reponses
        WHERE question_id = ?
    ");
    $stmt2->execute([$question_id]);
    $temps = $stmt2->fetch(PDO::FETCH_ASSOC);

    // ✅ Correction : éviter le null
    $temps_moyen = $temps['temps_moyen'] ?? 0;

    return [
        'repartition' => $stats,
        'temps_moyen' => round($temps_moyen, 2)
    ];
}

function selectionnerFinalistes($pdo) {
    // Récupère le meilleur de chaque groupe (groupe_id 1, 2, 3)
    $finalistes = [];
    for ($groupe = 1; $groupe <= 3; $groupe++) {
        $stmt = $pdo->prepare("
            SELECT p.id, p.nom, s.total_points 
            FROM scores s
            JOIN participants p ON p.id = s.participant_id
            WHERE p.groupe_id = ?
            ORDER BY s.total_points DESC
            LIMIT 1
        ");
        $stmt->execute([$groupe]);
        $finalistes[] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $finalistes;
}



function getQuestionsAleatoires($pdo, $nombre, $exclure_ids = []) {
    if (!empty($exclure_ids)) {
        $placeholders = implode(',', array_fill(0, count($exclure_ids), '?'));
        $stmt = $pdo->prepare("SELECT * FROM questions 
            WHERE id NOT IN ($placeholders)
            ORDER BY RAND() 
            LIMIT $nombre");
        $stmt->execute($exclure_ids);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM questions 
            ORDER BY RAND() 
            LIMIT $nombre");
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}