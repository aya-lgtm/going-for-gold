<?php
// On démarre la session pour pouvoir la manipuler
session_start();

// On vide toutes les variables de session
$_SESSION = array();

// On détruit physiquement la session sur le serveur
session_destroy();

// On redirige vers la page d'accueil ou de login
header("Location: ../pages/index.php");
exit;
?>