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

function calculateScore($tempsRestant) {
    if ($tempsRestant <= 0) return 0;
    return $tempsRestant * 100;
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