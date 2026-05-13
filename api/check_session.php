<?php

require_once '../config.php';

$sql = "
SELECT *
FROM sessions
WHERE statut = 'active'
ORDER BY id DESC
LIMIT 1
";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($session) {
        echo json_encode([
            "started" => true,
            "round" => $session['round_actuel']
        ]);
    } else {
        echo json_encode([
            "started" => false
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}