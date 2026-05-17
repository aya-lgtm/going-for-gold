<?php
session_start();
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère ce que l'utilisateur a tapé dans le formulaire
    $login_input = $_POST['username'] ?? ''; // 'username' est le nom du champ dans ton HTML
    $pass_input = $_POST['password'] ?? '';

    // ATTENTION : On interroge la table 'utilisateurs' et la colonne 'login'
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? AND role = 'admin'");
    $stmt->execute([$login_input]);
    $user = $stmt->fetch();

    // ATTENTION : On vérifie la colonne 'mot_de_passe'
    if ($user && password_verify($pass_input, $user['mot_de_passe'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_nom'] = $user['nom'];
        
        header('Location: admin.php');
        exit();
    } else {
        header('Location: login.php?error=1');
        exit();
    }}