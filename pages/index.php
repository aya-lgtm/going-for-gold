<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Going For Gold - Premium Edition</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --gold:#F5A623;
    --gold2:#FFD700;

    --dark:#050510;
    --dark2:#0B0B18;

    --card-bg:rgba(255,255,255,0.05);

    --border:rgba(245,166,35,0.22);

    --text-muted:#9191B5;

    --nav-bg:rgba(5,5,15,0.72);

    --body-text:#ffffff;

    --transition:0.45s ease;

    --gold-glow:rgba(245,166,35,0.35);

    --success:#00ff88;
}

body.light{
    --dark:#F8F7F2;
    --dark2:#FFFFFF;

    --card-bg:rgba(255,255,255,0.72);

    --border:rgba(180,120,0,0.22);

    --text-muted:#666680;

    --nav-bg:rgba(255,255,255,0.72);

    --body-text:#1B1B30;
}

body{
    font-family:'Poppins',sans-serif;
    background:var(--dark);
    color:var(--body-text);
    min-height:100vh;
    overflow-x:hidden;
    transition:var(--transition);
}

/* ========================= */
/* NAVBAR */
/* ========================= */

nav{
    position:fixed;
    top:0;
    left:0;
    right:0;

    z-index:1000;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:16px 50px;

    background:var(--nav-bg);

    backdrop-filter:blur(18px);

    border-bottom:1px solid var(--border);

    transition:var(--transition);
}

nav::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-1px;

    width:100%;
    height:1px;

    background:linear-gradient(
        90deg,
        transparent,
        rgba(245,166,35,0.8),
        transparent
    );

    animation:navGlow 4s linear infinite;
}

@keyframes navGlow{
    0%{opacity:0.2;}
    50%{opacity:1;}
    100%{opacity:0.2;}
}

.nav-links a{
    color:var(--text-muted);
    text-decoration:none;

    font-size:14px;
    font-weight:600;

    margin-right:30px;

    transition:0.3s ease;
}

.nav-links a:hover{
    color:var(--gold);
}

.btn-theme{
    background:var(--card-bg);

    border:1px solid var(--border);

    border-radius:50px;

    padding:8px 16px;

    color:inherit;

    cursor:pointer;

    transition:0.3s ease;
}

.btn-theme:hover{
    transform:translateY(-2px);
    border-color:var(--gold);
}

/* ========================= */
/* HERO */
/* ========================= */

.hero{
    position:relative;

    min-height:100vh;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    text-align:center;

    background-image:url('../assets/img/bg-hero.png');
    background-size:cover;
    background-position:center;

    padding-top:120px;
    padding-bottom:60px;

    overflow:hidden;
}

.hero::before{
    content:'';

    position:absolute;
    inset:0;

    background:
    radial-gradient(
        circle at center,
        rgba(245,166,35,0.08),
        rgba(0,0,0,0.76)
    );

    backdrop-filter:blur(3px);
}

body.light .hero::before{
    background:
    radial-gradient(
        circle at center,
        rgba(245,166,35,0.08),
        rgba(255,255,255,0.82)
    );
}

.hero > *{
    position:relative;
    z-index:1;
}

/* ========================= */
/* LOGO */
/* ========================= */

#logo-hero{
    width:clamp(220px,30vw,420px);

    margin-bottom:15px;

    animation:logoFloat 5s ease-in-out infinite;

    filter:
    drop-shadow(0 0 30px rgba(245,166,35,0.3))
    drop-shadow(0 0 70px rgba(245,166,35,0.12));

    transition:0.4s ease;
}

@keyframes logoFloat{
    0%{transform:translateY(0px);}
    50%{transform:translateY(-8px);}
    100%{transform:translateY(0px);}
}

.school-name{
    font-size:12px;

    letter-spacing:4px;

    font-weight:600;

    color:var(--text-muted);

    margin-top:5px;
}

.subtitle{
    margin-top:14px;
    margin-bottom:45px;

    color:var(--gold);

    letter-spacing:4px;

    font-size:13px;
    font-weight:700;

    opacity:0.9;
}

/* ========================= */
/* TECH PANEL */
/* ========================= */

.tech-monitoring{
    position:absolute;

    top:110px;
    right:40px;

    display:flex;
    flex-direction:column;
    gap:12px;

    opacity:0.9;
}

.raspy-widget{
    background:var(--card-bg);

    border:1px solid var(--border);

    border-radius:18px;

    padding:16px;

    backdrop-filter:blur(18px);

    min-width:220px;

    text-align:left;

    transition:0.35s ease;
}

.raspy-widget:hover{
    transform:translateY(-5px);
}

.status-dot{
    width:8px;
    height:8px;

    border-radius:50%;

    background:var(--success);

    display:inline-block;

    margin-right:8px;

    box-shadow:0 0 10px var(--success);
}

.dot-session{
    background:var(--gold);

    box-shadow:0 0 10px var(--gold);
}

/* ========================= */
/* CARDS */
/* ========================= */

.selection-container{
    width:90%;
    max-width:950px;

    display:flex;
    gap:25px;

    align-items:stretch;
}

.action-card{
    background:var(--card-bg);

    border:1px solid var(--border);

    border-radius:26px;

    padding:40px 30px;

    backdrop-filter:blur(18px);

    transition:0.4s cubic-bezier(0.175,0.885,0.32,1.275);

    display:flex;
    flex-direction:column;
    align-items:center;
}

.action-card:hover{
    transform:translateY(-10px);

    border-color:rgba(245,166,35,0.45);
}

.action-card.participant{
    flex:1.3;

    transform:scale(1.02);

    border:1px solid rgba(245,166,35,0.35);

    box-shadow:
    0 0 45px rgba(245,166,35,0.08),
    inset 0 0 20px rgba(255,255,255,0.02);
}

.action-card.organizer{
    flex:0.85;

    opacity:0.92;
}

.action-card h3{
    color:var(--gold);

    font-size:14px;
    font-weight:800;

    letter-spacing:2px;

    text-transform:uppercase;

    margin-bottom:15px;
}

/* ========================= */
/* INPUT */
/* ========================= */

.name-input{
    width:100%;

    height:56px;

    background:rgba(255,255,255,0.05)!important;

    border:1px solid var(--border)!important;

    border-radius:50px!important;

    color:var(--body-text)!important;

    text-align:center;

    font-size:14px;
    font-weight:600;

    margin-bottom:18px;

    transition:0.35s ease;
}

body.light .name-input{
    background:rgba(255,255,255,0.45)!important;
}

.name-input:focus{
    outline:none;

    border-color:var(--gold)!important;

    transform:translateY(-2px);

    box-shadow:
    0 0 0 4px rgba(245,166,35,0.08),
    0 0 30px rgba(245,166,35,0.18);
}

/* ========================= */
/* BUTTONS */
/* ========================= */

.btn-main{
    width:100%;

    border-radius:50px;

    padding:15px;

    font-size:13px;
    font-weight:800;

    letter-spacing:1px;

    text-transform:uppercase;

    transition:0.35s ease;

    cursor:pointer;
}

.btn-join{
    position:relative;

    overflow:hidden;

    border:none;

    color:#000;

    background:
    linear-gradient(
        135deg,
        var(--gold2) 0%,
        var(--gold) 100%
    );

    box-shadow:
    0 10px 30px rgba(245,166,35,0.22);
}

.btn-join:hover{
    transform:translateY(-3px) scale(1.02);

    box-shadow:
    0 15px 45px rgba(245,166,35,0.38);
}

.btn-join::before{
    content:'';

    position:absolute;

    top:0;
    left:-120%;

    width:80%;
    height:100%;

    background:linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,0.5),
        transparent
    );

    transform:skewX(-25deg);
}

.btn-join:hover::before{
    animation:shine 1s;
}

@keyframes shine{
    100%{
        left:140%;
    }
}

.btn-create{
    background:transparent;

    border:2px solid var(--gold);

    color:var(--gold);
}

.btn-create:hover{
    background:var(--gold);

    color:#000;

    transform:translateY(-2px);
}

.lock-badge{
    margin-top:auto;
    margin-bottom:18px;

    color:var(--text-muted);

    font-size:11px;
}

/* ========================= */
/* SESSION */
/* ========================= */

#sessionIndicator{
    margin-top:14px;

    font-size:10px;
    font-weight:700;

    color:var(--success);

    letter-spacing:1px;
}

/* ========================= */
/* STATS */
/* ========================= */

.stat-grid{
    margin-top:35px;

    width:100%;
    max-width:800px;

    display:grid;
    grid-template-columns:repeat(4,1fr);

    gap:15px;
}

.stat-box{
    background:var(--card-bg);

    border:1px solid var(--border);

    border-radius:18px;

    padding:18px;

    backdrop-filter:blur(14px);

    transition:0.35s ease;
}

.stat-box:hover{
    transform:translateY(-6px);

    border-color:rgba(245,166,35,0.45);

    box-shadow:
    0 12px 30px rgba(245,166,35,0.12);
}

.stat-num{
    font-size:28px;
    font-weight:800;

    color:var(--gold);

    transition:0.3s ease;
}

.stat-box:hover .stat-num{
    transform:scale(1.08);
}

.stat-lbl{
    font-size:10px;

    text-transform:uppercase;

    color:var(--text-muted);
}

/* ========================= */
/* RULES SECTION */
/* ========================= */

.rules-section{
    width:90%;
    max-width:950px;

    margin-top:60px;

    display:grid;
    grid-template-columns:repeat(3,1fr);

    gap:20px;
}

.rule-card{
    background:var(--card-bg);

    border:1px solid var(--border);

    border-radius:22px;

    padding:28px;

    backdrop-filter:blur(15px);

    transition:0.35s ease;
}

.rule-card:hover{
    transform:translateY(-5px);

    border-color:rgba(245,166,35,0.4);
}

.rule-icon{
    font-size:32px;

    margin-bottom:16px;
}

.rule-title{
    color:var(--gold);

    font-weight:700;

    margin-bottom:10px;
}

.rule-text{
    font-size:13px;

    color:var(--text-muted);

    line-height:1.6;
}

/* ========================= */
/* RESPONSIVE */
/* ========================= */

@media(max-width:768px){

    nav{
        padding:14px 20px;
    }

    .nav-links{
        display:none;
    }

    .tech-monitoring{
        display:none;
    }

    .selection-container{
        flex-direction:column;
    }

    .action-card.participant{
        transform:none;
    }

    .stat-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .rules-section{
        grid-template-columns:1fr;
    }

    .hero{
        padding-top:140px;
    }
}

</style>
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

            <button
                class="btn-main btn-create"
               onclick="window.location.href='admin.php'"
            >
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

window.onload=function(){

    const savedTheme =
    localStorage.getItem('theme');

    if(savedTheme === 'light'){

        document.body.classList.add('light');

        document.getElementById('themeBtn').textContent='☀️';

        updateAssets(true);
    }
}

</script>

</body>
</html>