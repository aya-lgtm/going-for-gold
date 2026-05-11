<?php
require_once '../config.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
if (empty($action)) {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
}

// ========================= 
// INSCRIRE UN PARTICIPANT
// =========================
if ($action === 'inscrire') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nom = trim($data['nom'] ?? '');

    if (empty($nom)) {
        echo json_encode(['success' => false, 'message' => 'Nom invalide']);
        exit;
    }

    // Vérifier si le nom existe déjà
    $check = $pdo->prepare("SELECT id FROM participants WHERE nom = ?");
    $check->execute([$nom]);
    if ($check->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Ce nom est déjà utilisé !']);
        exit;
    }

    // Insérer le participant
    $stmt = $pdo->prepare("INSERT INTO participants (nom) VALUES (?)");
    $stmt->execute([$nom]);

    echo json_encode([
        'success' => true,
        'id'      => $pdo->lastInsertId(),
        'message' => 'Inscription réussie !'
    ]);
}

// =========================
// LISTER LES PARTICIPANTS
// =========================
elseif ($action === 'list') {
    $stmt = $pdo->query("
        SELECT p.id, p.nom, p.groupe_id, g.nom as groupe_nom
        FROM participants p
        LEFT JOIN groupes g ON g.id = p.groupe_id
        ORDER BY p.id ASC
    ");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// =========================
// TIRAGE AU SORT
// =========================
elseif ($action === 'tirage') {
    require_once '../includes/functions.php';

    // Créer les 3 groupes si pas encore créés
    $check = $pdo->query("SELECT COUNT(*) FROM groupes")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO groupes (nom) VALUES 
            ('First Round 1'), ('First Round 2'), ('First Round 3')");
    }

    dispatchParticipants($pdo);
    echo json_encode(['success' => true, 'message' => 'Tirage au sort effectué !']);
}

// =========================
// SÉLECTIONNER LES FINALISTES
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
}

// =========================
// SUPPRIMER UN PARTICIPANT
// =========================
elseif ($action === 'delete') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;

    $stmt = $pdo->prepare("DELETE FROM participants WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
}

// =========================
// COMPTER LES PARTICIPANTS
// =========================
elseif ($action === 'count') {
    $count = $pdo->query("SELECT COUNT(*) FROM participants")->fetchColumn();
    echo json_encode(['count' => $count]);
}
?>