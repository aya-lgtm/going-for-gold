<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config.php'; // ou '../config/db.php' selon votre fichier

// Lire l'action
$action = $_GET['action'] ?? '';
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    
    if (strpos($contentType, 'application/json') !== false) {
        // Requête JSON (ajouter, supprimer)
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true) ?? [];
        $action = $data['action'] ?? $action;
    } else {
        // Requête multipart/form-data (import Excel)
        $action = $_POST['action'] ?? $action;
    }
}

switch ($action) {

    case 'list':
        $stmt = $pdo->query("SELECT * FROM questions ORDER BY id ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'add':
        // Vérification que les données existent
        if (empty($data['texte']) || empty($data['choix_1'])) {
            echo json_encode(['success' => false, 'error' => 'Données manquantes', 'recu' => $data]);
            break;
        }
        
        $stmt = $pdo->prepare("
            INSERT INTO questions (texte, choix_1, choix_2, choix_3, choix_4, bonne_reponse)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['texte'],
            $data['choix_1'],
            $data['choix_2'],
            $data['choix_3'],
            $data['choix_4'],
            $data['bonne_reponse']
        ]);
        echo json_encode(['success' => true]);
        break;

    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
        $stmt->execute([$data['id']]);
        echo json_encode(['success' => true]);
        break;

    case 'import':
        require_once '../vendor/autoload.php';
        $file = $_FILES['file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        $count = 0;
        $stmt = $pdo->prepare("
            INSERT INTO questions (texte, choix_1, choix_2, choix_3, choix_4, bonne_reponse)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        foreach ($rows as $i => $row) {
            if ($i === 0 || empty($row[0])) continue;
            $stmt->execute([$row[0], $row[1], $row[2], $row[3], $row[4], $row[5]]);
            $count++;
        }
        echo json_encode(['success' => true, 'message' => "$count questions importées !"]);
        break;

    case 'export':
        require_once '../vendor/autoload.php';
        $stmt = $pdo->query("SELECT * FROM questions ORDER BY id ASC");
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(['Question','Choix 1','Choix 2','Choix 3','Choix 4','Bonne réponse'], null, 'A1');
        $row = 2;
        foreach ($questions as $q) {
            $sheet->fromArray([$q['texte'],$q['choix_1'],$q['choix_2'],$q['choix_3'],$q['choix_4'],$q['bonne_reponse']], null, 'A'.$row);
            $row++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="questions.xlsx"');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;

    default:
        echo json_encode(['error' => 'Action inconnue: ' . $action]);
}