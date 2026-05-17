<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Going For Gold - Premium Edition</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style-index.css" rel="stylesheet">
<link rel="icon" type="image/png" href="../assets/img/favicon.png">

</head>

<body>

<!-- ========================= -->
<!-- NAVBAR -->
<!-- ========================= -->

<nav>

    <img
        id="logo-nav"
        src="../assets/img/logo.png"
        alt="Logo"
        style="height:42px;"
    >

    <div class="nav-links">
        <a href="#">Compétition</a>
        <a href="#">Classement Live</a>
        <a href="#">Technologie</a>
    </div>

    <button
        class="btn-theme"
        onclick="toggleTheme()"
        id="themeBtn"
    >
        🌙
    </button>

</nav>

<!-- ========================= -->
<!-- HERO -->
<!-- ========================= -->

<div class="hero" id="hero">

    <!-- TECH PANEL -->

    <div class="tech-monitoring">

        <div class="raspy-widget">
            <div style="margin-bottom:6px;">
                <span class="status-dot"></span>
                SERVEUR LIVE
            </div>

            <div style="color:var(--gold);font-weight:700;">
                RASPBERRY PI 4
            </div>

            <div style="font-size:10px;opacity:0.6;margin-top:5px;">
                LATENCE : 12ms | WIFI ACTIVE
            </div>
        </div>

        <div class="raspy-widget">
            <div style="margin-bottom:6px;">
                <span class="status-dot dot-session"></span>
                JOUEURS EN LIGNE
            </div>

            <div
                id="onlineCount"
                style="font-size:16px;font-weight:700;"
            >
                18 / 25
            </div>
        </div>

    </div>

    <!-- LOGO -->

    <img
        id="logo-hero"
        src="../assets/img/logo.png"
        alt="Going For Gold"
    >

    <div class="school-name">
        HEM ENGINEERING SCHOOL
    </div>

    <div class="subtitle">
        L’EXCELLENCE EN MOUVEMENT • ÉDITION 2026
    </div>

    <!-- CARDS -->

    <div class="selection-container">

        <!-- PARTICIPANT -->

        <div class="action-card participant">

    <h3>Participant</h3>

    <p style="font-size:12px;color:var(--text-muted);margin-bottom:22px;">
        Entrez le code affiché sur l'écran
    </p>

    <!-- Champs code style Kahoot -->
    <div style="display:flex;gap:8px;justify-content:center;margin-bottom:16px;">
    <input type="text" class="code-digit" inputmode="numeric" maxlength="1" placeholder="·"
    style="width:46px;height:58px;background:rgba(255,255,255,0.06);
           border:2px solid rgba(245,166,35,0.3);border-radius:12px;
           color:#fff;font-size:24px;font-weight:800;text-align:center;
           outline:none;transition:.2s;">
        <input type="text" class="code-digit" inputmode="numeric" maxlength="1" placeholder="·"
    style="width:46px;height:58px;background:rgba(255,255,255,0.06);
           border:2px solid rgba(245,166,35,0.3);border-radius:12px;
           color:#fff;font-size:24px;font-weight:800;text-align:center;
           outline:none;transition:.2s;">
       <input type="text" class="code-digit" inputmode="numeric" maxlength="1" placeholder="·"
    style="width:46px;height:58px;background:rgba(255,255,255,0.06);
           border:2px solid rgba(245,166,35,0.3);border-radius:12px;
           color:#fff;font-size:24px;font-weight:800;text-align:center;
           outline:none;transition:.2s;">
        <input type="text" class="code-digit" inputmode="numeric" maxlength="1" placeholder="·"
    style="width:46px;height:58px;background:rgba(255,255,255,0.06);
           border:2px solid rgba(245,166,35,0.3);border-radius:12px;
           color:#fff;font-size:24px;font-weight:800;text-align:center;
           outline:none;transition:.2s;">
        <input type="text" class="code-digit" inputmode="numeric" maxlength="1" placeholder="·"
    style="width:46px;height:58px;background:rgba(255,255,255,0.06);
           border:2px solid rgba(245,166,35,0.3);border-radius:12px;
           color:#fff;font-size:24px;font-weight:800;text-align:center;
           outline:none;transition:.2s;">
        <input type="text" class="code-digit" inputmode="numeric" maxlength="1" placeholder="·"
    style="width:46px;height:58px;background:rgba(255,255,255,0.06);
           border:2px solid rgba(245,166,35,0.3);border-radius:12px;
           color:#fff;font-size:24px;font-weight:800;text-align:center;
           outline:none;transition:.2s;">
    </div>

    <input
        type="text"
        id="playerName"
        class="name-input"
        placeholder="Votre prénom et nom"
        maxlength="40"
        autocomplete="off"
    >

    <div id="error-msg" style="display:none;background:rgba(255,75,75,0.1);
         border:1px solid rgba(255,75,75,0.3);color:#FF4B4B;border-radius:12px;
         padding:10px 14px;font-size:12px;margin-bottom:12px;">
    </div>

    <button class="btn-main btn-join" onclick="startParticipant()">
        🚀 Rejoindre la compétition
    </button>

    <div id="sessionIndicator">● SESSION OUVERTE</div>

</div>

        <!-- ORGANIZER -->

        <div class="action-card organizer">

            <h3>Organisateur</h3>

            <p
                style="
                font-size:12px;
                color:var(--text-muted);
                margin-bottom:20px;
                "
            >
                Gérer les questions et les rounds
            </p>

            <div class="lock-badge">
                🔒 Accès sécurisé staff & jury
            </div>

            <button class="btn-main btn-create" onclick="window.location.href='login.php'">
    Créer / Gérer
</button>

        </div>

    </div>

    <!-- STATS -->

    <div class="stat-grid">

        <div class="stat-box">
            <div class="stat-num">3</div>
            <div class="stat-lbl">Groupes</div>
        </div>

        <div class="stat-box">
            <div class="stat-num">25</div>
            <div class="stat-lbl">Par Round</div>
        </div>

        <div class="stat-box">
            <div class="stat-num">10s</div>
            <div class="stat-lbl">Réflexe</div>
        </div>

        <div class="stat-box">
            <div class="stat-num">Gold</div>
            <div class="stat-lbl">Finale</div>
        </div>

    </div>

    <!-- RULES -->

    <div class="rules-section">

        <div class="rule-card">

            <div class="rule-icon">⚡</div>

            <div class="rule-title">
                10 Secondes
            </div>

            <div class="rule-text">
                Chaque question doit être répondue rapidement.
                La vitesse fait la différence.
            </div>

        </div>

        <div class="rule-card">

            <div class="rule-icon">🏆</div>

            <div class="rule-title">
                Rounds Progressifs
            </div>

            <div class="rule-text">
                3 rounds éliminatoires avant la grande finale Gold.
            </div>

        </div>

        <div class="rule-card">

            <div class="rule-icon">📡</div>

            <div class="rule-title">
                Live Competition
            </div>

            <div class="rule-text">
                Synchronisation temps réel via Raspberry Pi.
            </div>

        </div>

    </div>

</div>

<!-- ========================= -->
<!-- SCRIPT -->
<!-- ========================= -->

<script>

let currentPlayers = 18;

setInterval(() => {

    if(currentPlayers < 25){

        currentPlayers++;

        document.getElementById('onlineCount').innerText =
        currentPlayers + " / 25";
    }

},8000);

/* ========================= */
/* JOIN */
/* ========================= */


// Gestion des champs code
const digits = document.querySelectorAll('.code-digit');
digits.forEach((inp, idx) => {
    inp.addEventListener('input', () => {
        inp.value = inp.value.replace(/\D/g,'').slice(0,1);
        inp.style.borderColor = inp.value ? 'var(--gold)' : 'rgba(245,166,35,0.3)';
        inp.style.color = inp.value ? 'var(--gold)' : '#fff';
        if (inp.value && idx < digits.length - 1) digits[idx+1].focus();
    });
    inp.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !inp.value && idx > 0) digits[idx-1].focus();
        if (e.key === 'Enter') startParticipant();
    });
    inp.addEventListener('paste', e => {
        e.preventDefault();
        const text = e.clipboardData.getData('text').replace(/\D/g,'');
        digits.forEach((d, i) => {
            d.value = text[i] || '';
            d.style.borderColor = d.value ? 'var(--gold)' : 'rgba(245,166,35,0.3)';
        });
        document.getElementById('playerName').focus();
    });
});

function getCode() {
    return Array.from(digits).map(d => d.value).join('');
}

function showError(msg) {
    const el = document.getElementById('error-msg');
    el.textContent = '❌ ' + msg;
    el.style.display = 'block';
    setTimeout(() => el.style.display = 'none', 4000);
}

function startParticipant() {
    const code = getCode();
    const nom  = document.getElementById('playerName').value.trim();

    if (code.length < 6) { showError('Entrez les 6 chiffres du code.'); return; }
    if (nom.length < 2)  { showError('Entrez votre prénom et nom.'); return; }

    fetch('../api/session.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ action: 'rejoindre', code, nom })
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) { showError(data.error); return; }

        localStorage.setItem('participantId', data.participant_id);
        localStorage.setItem('participantNom', nom);
        localStorage.setItem('sessionId', data.session_id);
        localStorage.setItem('sessionCode', code);

        window.location.href = 'participant.php';
    })
    .catch(() => showError('Erreur réseau. Vérifiez votre connexion.'));
}

/* ========================= */
/* THEME */
/* ========================= */

function updateAssets(isLight){

    const logoHero =
    document.getElementById('logo-hero');

    const logoNav =
    document.getElementById('logo-nav');

    const hero =
    document.getElementById('hero');

    logoHero.style.opacity='0';

    logoNav.style.opacity='0';

    setTimeout(()=>{

        logoHero.src =
        isLight
        ? '../assets/img/logo-light.png'
        : '../assets/img/logo.png';

        logoNav.src =
        isLight
        ? '../assets/img/logo-light.png'
        : '../assets/img/logo.png';

        hero.style.backgroundImage =
        isLight
        ? "url('../assets/img/bg-hero-light.png')"
        : "url('../assets/img/bg-hero.png')";

        logoHero.style.opacity='1';

        logoNav.style.opacity='1';

    },250);
}

function toggleTheme(){

    document.body.classList.toggle('light');

    const isLight =
    document.body.classList.contains('light');

    document.getElementById('themeBtn').textContent =
    isLight ? '☀️' : '🌙';

    updateAssets(isLight);

    localStorage.setItem(
        'theme',
        isLight ? 'light' : 'dark'
    );
}

window.onload = function() {
    // 1. GESTION DU THÈME
    const savedTheme = localStorage.getItem('theme');
    if(savedTheme === 'light'){
        document.body.classList.add('light');
        document.getElementById('themeBtn').textContent='☀️';
        updateAssets(true);
    }

    // 2. TENTATIVE DE RECONNEXION AUTO
    const savedId = localStorage.getItem('participantId');
    const savedNom = localStorage.getItem('participantNom');
    
    // On ne tente la reconnexion QUE si on a les deux infos
    if (savedId && savedNom) {
        console.log("Session trouvée pour : " + savedNom);
        
        fetch('../api/session.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ 
                action: 'verifier_statut', 
                participant_id: savedId 
            })
        })
        .then(r => r.json())
        .then(data => {
            // Si l'API confirme que le participant existe encore en BDD
            if (data.success && data.actif) {
                console.log("Redirection vers la salle d'attente...");
                window.location.replace('participant.php'); // replace est mieux pour éviter le bouton "retour"
            } else {
                // Si la session est expirée côté serveur, on nettoie tout
                console.warn("Session expirée côté serveur, nettoyage...");
                localStorage.removeItem('participantId');
                localStorage.removeItem('participantNom');
                localStorage.removeItem('sessionId');
                localStorage.removeItem('sessionCode');
            }
        })
        .catch(err => {
            console.error("Erreur réseau lors de la vérification", err);
        });
    }
};

</script>

</body>
</html>