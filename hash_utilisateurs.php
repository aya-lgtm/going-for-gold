<?php
require_once 'config.php';

try {
    // 1. On récupère tous les utilisateurs
    $stmt = $pdo->query("SELECT id, mot_de_passe FROM utilisateurs");
    $utilisateurs = $stmt->fetchAll();

    echo "<h3>Début du hachage...</h3>";
    $count = 0;

    foreach ($utilisateurs as $user) {
        $id = $user['id'];
        $mdp_clair = $user['mot_de_passe'];

        // On vérifie si le mot de passe n'est pas déjà haché (un hash commence par $)
        if (strpos($mdp_clair, '$') !== 0) {
            $nouveau_hash = password_hash($mdp_clair, PASSWORD_BCRYPT);
            
            // 2. On met à jour la base de données
            $update = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
            $update->execute([$nouveau_hash, $id]);
            
            echo "Utilisateur ID $id : OK (Haché)<br>";
            $count++;
        } else {
            echo "Utilisateur ID $id : Déjà haché (Passé)<br>";
        }
    }

    echo "<h3>Terminé ! $count mots de passe ont été sécurisés.</h3>";
    echo "<p>Supprimer ce fichier par sécurité</p>";

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>