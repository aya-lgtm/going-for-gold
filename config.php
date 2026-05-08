<?php
$host = '127.0.0.1';
$dbname = 'quiz_app';
$user = 'root';
$password = 'GNG123';

try {
    $pdo = new PDO("mysql:host=$host;port=8889;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
