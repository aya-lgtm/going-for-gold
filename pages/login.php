<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Staff - Going For Gold</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <link href="../assets/css/style-index.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; margin: 0; position: relative;">

    <div id="hero-bg" class="hero" style="
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background-image: url('../assets/img/bg-hero.png'); 
        background-size: cover;
        background-position: center;
        z-index: -1;
        transition: 0.4s;
    "></div>

    <button class="theme-btn" onclick="toggleTheme()" id="themeBtn" 
        style="
            position: fixed !important; 
            top: 20px !important; 
            right: 20px !important; 
            z-index: 9999 !important;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid rgba(245, 166, 35, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 20px;
            backdrop-filter: blur(5px);
        ">
        🌙
    </button>

    <div class="selection-container">
        <div class="action-card participant">
            <h3 class="text-center">Accès Staff</h3>
            <form action="auth_check.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="name-input" placeholder="Identifiant" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="name-input" placeholder="Mot de passe" required>
                </div>
                <button type="submit" class="btn-main btn-create w-100">Se connecter</button>
            </form>
            <?php if(isset($_GET['error'])): ?>
                <p style="color: #FF4B4B; font-size: 12px; margin-top: 10px; text-align: center;">❌ Identifiants invalides.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleTheme() {
            // 1. Basculer la classe light sur le body (pour les couleurs des cartes/inputs)
            document.body.classList.toggle('light');
            const isLight = document.body.classList.contains('light');
            
            // 2. Changer l'icône du bouton
            const btn = document.getElementById('themeBtn');
            btn.innerText = isLight ? '☀️' : '🌙';
            
            // 3. CHANGER L'IMAGE DE FOND SANS TOUCHER AU CSS
            const hero = document.getElementById('hero-bg');
            if (isLight) {
                // Chemin vers ton image CLAIRE
                hero.style.backgroundImage = "url('../assets/img/bg-hero-light.png')";
                btn.style.color = "#1B1B30";
                btn.style.background = "rgba(0, 0, 0, 0.05)";
            } else {
                // Chemin vers ton image SOMBRE
                hero.style.backgroundImage = "url('../assets/img/bg-hero.png')";
                btn.style.color = "white";
                btn.style.background = "rgba(255, 255, 255, 0.1)";
            }

            localStorage.setItem('theme', isLight ? 'light' : 'dark');
        }

        // Garder le thème au rechargement
        window.onload = () => {
            if (localStorage.getItem('theme') === 'light') {
                toggleTheme();
            }
        };
    </script>
</body>
</html>