
<?php
// Pas de session PHP nécessaire — données lues depuis localStorage côté JS
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Going For Gold — Participant</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>

@keyframes borderGlow {
    0%,100% { opacity: 0.3; }
    50%      { opacity: 1; }
}
@keyframes trophyFloat {
    0%,100% { transform: translateY(0px) rotate(-2deg); }
    50%      { transform: translateY(-12px) rotate(2deg); }
}
@keyframes pulse {
    0%,100% { opacity: 1; }
    50%      { opacity: 0.3; }
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes countdownPulse {
    0%,100% { transform: scale(1); }
    50%      { transform: scale(1.15); }
}
@keyframes choixReveal {
    from { opacity: 0; transform: translateX(-10px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes correctBounce {
    0%,100% { transform: scale(1); }
    30%      { transform: scale(1.08); }
}

* { margin:0; padding:0; box-sizing:border-box; }

:root {
    --gold:   #F5A623;
    --gold2:  #FFD700;
    --bg:     #050510;
    --bg2:    #0C0C1D;
    --card:   rgba(255,255,255,0.05);
    --border: rgba(245,166,35,0.18);
    --text:   #FFFFFF;
    --muted:  #8E8EB1;
    --green:  #00FF88;
    --red:    #FF4B4B;
    --shadow: 0 10px 35px rgba(0,0,0,0.45);
}


body {
    font-family: 'Poppins', sans-serif;
    background:
        radial-gradient(circle at top, #1B1144 0%, transparent 30%),
        var(--bg);
    color: var(--text);
    min-height: 100vh;
    overflow-x: hidden;
}

/* ===============================
   TOPBAR
=============================== */
.topbar {
    height: 72px;
    padding: 0 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border);
    background: rgba(5,5,16,0.85);
    backdrop-filter: blur(14px);
    position: sticky;
    top: 0;
    z-index: 100;
}
.topbar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
}
.topbar-logo img {
    height: 40px;
    filter: drop-shadow(0 0 10px rgba(245,166,35,0.4));
}
.topbar-title { font-size: 15px; font-weight: 800; }
.topbar-title span { color: var(--gold); }

.live-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 700;
    color: var(--green);
    background: rgba(0,255,136,0.08);
    border: 1px solid rgba(0,255,136,0.2);
    border-radius: 50px;
    padding: 6px 16px;
}
.dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--green);
    box-shadow: 0 0 10px var(--green);
    animation: pulse 1.4s infinite;
}

/* ===============================
   WRAPPER & SCREENS
=============================== */
.page-wrap {
    max-width: 680px;
    margin: 0 auto;
    padding: 32px 20px 60px;
}
.screen { display: none; animation: fadeIn 0.4s ease; }
.screen.active { display: block; }

/* ===============================
   CARDS
=============================== */
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 28px;
    padding: 36px;
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
}
.card + .card { margin-top: 20px; }

.card-gold {
    background: linear-gradient(135deg, rgba(245,166,35,0.10), rgba(124,58,237,0.08));
    border: 1px solid rgba(245,166,35,0.3);
}

/* ===============================
   INPUTS
=============================== */
.input-group { margin-bottom: 16px; }
.input-group label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    color: var(--gold);
    margin-bottom: 8px;
}
.input-field {
    width: 100%;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 14px;
    padding: 16px 20px;
    color: var(--text);
    font-family: 'Poppins', sans-serif;
    font-size: 15px;
    font-weight: 600;
    outline: none;
    transition: .3s;
}
.input-field:focus {
    border-color: rgba(245,166,35,0.5);
    background: rgba(245,166,35,0.04);
    box-shadow: 0 0 0 3px rgba(245,166,35,0.08);
}
.input-field::placeholder { color: var(--muted); font-weight: 400; }

.code-input {
    font-size: 32px;
    font-weight: 900;
    text-align: center;
    letter-spacing: 10px;
    text-transform: uppercase;
}

/* ===============================
   BOUTONS
=============================== */
.btn-gold {
    width: 100%;
    background: linear-gradient(135deg, var(--gold2), var(--gold));
    color: #000;
    font-weight: 900;
    border: none;
    border-radius: 14px;
    padding: 18px;
    font-size: 15px;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    transition: .3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 20px rgba(245,166,35,0.3);
}
.btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(245,166,35,0.5);
}
.btn-gold:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.error-msg {
    background: rgba(255,75,75,0.1);
    border: 1px solid rgba(255,75,75,0.25);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13px;
    color: var(--red);
    margin-top: 12px;
    display: none;
    text-align: center;
}

/* ===============================
   DÉCORATIONS
=============================== */
.star-top {
    position: absolute;
    top: 16px; right: 20px;
    color: var(--gold);
    font-size: 16px;
    opacity: 0.5;
    animation: pulse 3s infinite;
}
.glow-line-top {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold), var(--gold2), transparent);
    animation: borderGlow 2.5s ease-in-out infinite;
}

/* ===============================
   RESPONSIVE
=============================== */
@media(max-width:480px) {
    .page-wrap { padding: 20px 14px 40px; }
    .card { padding: 24px 20px; }
    .choix-grid { grid-template-columns: 1fr; }
}


/* ===============================
   ÉCRAN 1 : CONNEXION HERO
=============================== */

.connect-hero {
    text-align: center;
    margin-bottom: 28px;
}
.connect-hero .trophy {
    width: 120px;
    margin: 0 auto 20px;
    animation: trophyFloat 3s ease-in-out infinite;
    filter: drop-shadow(0 0 20px rgba(245,166,35,0.5));
    display: block;
}
.connect-hero h1 {
    font-size: 32px;
    font-weight: 900;
    line-height: 1.2;
    margin-bottom: 10px;
}
.connect-hero h1 span {
    background: linear-gradient(135deg, var(--gold2), var(--gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.connect-hero p {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.7;
}

/* ===============================
   ÉCRAN 2 : SALLE D'ATTENTE
=============================== */
.waiting-hero { text-align: center; padding: 16px 0; }

.waiting-avatar {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gold2), var(--gold));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 900;
    color: #000;
    margin: 0 auto 20px;
    box-shadow: 0 0 30px rgba(245,166,35,0.4);
}
.waiting-name {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 6px;
}
.waiting-name span { color: var(--gold); }
.waiting-subtitle {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 28px;
}

.waiting-pulse {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 28px 0;
}
.pulse-ring {
    width: 90px; height: 90px;
    border-radius: 50%;
    border: 3px solid rgba(245,166,35,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.pulse-ring::before {
    content: '';
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    border: 2px solid rgba(245,166,35,0.15);
    animation: pulse 2s infinite;
}
.pulse-ring::after {
    content: '';
    position: absolute;
    inset: -18px;
    border-radius: 50%;
    border: 1px solid rgba(245,166,35,0.08);
    animation: pulse 2s infinite 0.5s;
}
.pulse-icon { font-size: 36px; }

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-top: 20px;
}
.info-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 18px;
    padding: 18px;
    text-align: center;
}
.info-card-val {
    font-size: 26px;
    font-weight: 900;
    color: var(--gold);
    line-height: 1;
    margin-bottom: 6px;
}
.info-card-label {
    font-size: 11px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* ===============================
   ÉCRAN 3 : QUESTION
=============================== */
.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.q-badge {
    background: rgba(245,166,35,0.1);
    border: 1px solid rgba(245,166,35,0.25);
    color: var(--gold);
    font-weight: 800;
    font-size: 13px;
    padding: 8px 18px;
    border-radius: 50px;
}
.q-round-label {
    font-size: 12px;
    color: var(--muted);
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 6px;
}

/* CHRONO CIRCULAIRE SVG */
.chrono-wrap { display: flex; justify-content: center; margin-bottom: 24px; }
.chrono-circle { width: 100px; height: 100px; position: relative; }
.chrono-svg { width: 100%; height: 100%; transform: rotate(-90deg); }
.chrono-bg   { fill: none; stroke: rgba(255,255,255,0.08); stroke-width: 6; }
.chrono-arc  {
    fill: none;
    stroke: var(--gold);
    stroke-width: 6;
    stroke-linecap: round;
    stroke-dasharray: 251;
    stroke-dashoffset: 0;
    transition: stroke-dashoffset 1s linear, stroke 0.3s;
    filter: drop-shadow(0 0 6px rgba(245,166,35,0.6));
}
.chrono-num-wrap {
    position: absolute; inset: 0;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
}
.chrono-num  { font-size: 34px; font-weight: 900; color: var(--gold); line-height: 1; }
.chrono-sec  { font-size: 10px; color: var(--muted); }

/* BARRE PROGRESSION */
.progress-bar-wrap {
    background: rgba(255,255,255,0.06);
    border-radius: 50px;
    height: 6px;
    margin-bottom: 24px;
    overflow: hidden;
}
.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--gold2), var(--gold));
    border-radius: 50px;
    transition: width 0.5s;
    box-shadow: 0 0 8px rgba(245,166,35,0.4);
}

/* TEXTE QUESTION */
.q-texte {
    background: rgba(245,166,35,0.05);
    border: 1px solid rgba(245,166,35,0.18);
    border-radius: 18px;
    padding: 22px 24px;
    font-size: 17px;
    font-weight: 700;
    line-height: 1.6;
    margin-bottom: 24px;
    text-align: center;
}

/* CHOIX */
.choix-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 20px;
}
.choix-btn {
    background: rgba(255,255,255,0.04);
    border: 2px solid rgba(255,255,255,0.1);
    border-radius: 18px;
    padding: 18px 16px;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    transition: .25s;
    display: flex;
    align-items: center;
    gap: 12px;
    text-align: left;
    animation: choixReveal 0.3s ease forwards;
    opacity: 0;
}
.choix-btn:nth-child(1) { animation-delay: 0.05s; }
.choix-btn:nth-child(2) { animation-delay: 0.10s; }
.choix-btn:nth-child(3) { animation-delay: 0.15s; }
.choix-btn:nth-child(4) { animation-delay: 0.20s; }

.choix-btn:hover:not(:disabled) {
    border-color: rgba(245,166,35,0.4);
    background: rgba(245,166,35,0.06);
    transform: translateY(-2px);
}
.choix-btn:disabled { cursor: not-allowed; }

.choix-num {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: rgba(245,166,35,0.1);
    border: 1px solid rgba(245,166,35,0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 13px;
    color: var(--gold);
    flex-shrink: 0;
}

/* ÉTATS CHOIX */
.choix-btn.selected {
    border-color: var(--gold);
    background: rgba(245,166,35,0.12);
    box-shadow: 0 0 0 3px rgba(245,166,35,0.15);
}
.choix-btn.selected .choix-num {
    background: linear-gradient(135deg, var(--gold2), var(--gold));
    color: #000; border: none;
}
.choix-btn.correct {
    border-color: var(--green);
    background: rgba(0,255,136,0.10);
    animation: correctBounce 0.5s ease;
}
.choix-btn.correct .choix-num { background: var(--green); color: #000; border: none; }
.choix-btn.wrong {
    border-color: var(--red);
    background: rgba(255,75,75,0.08);
    opacity: 0.6;
}
.choix-btn.wrong .choix-num { background: var(--red); color: #fff; border: none; }
.choix-btn.reveal-correct {
    border-color: var(--green);
    background: rgba(0,255,136,0.08);
}
.choix-btn.reveal-correct .choix-num { background: var(--green); color: #000; border: none; }

/* ===============================
   ÉCRAN 4 : RÉSULTAT QUESTION
=============================== */
.result-icon  { font-size: 72px; text-align: center; margin-bottom: 16px; animation: trophyFloat 3s ease-in-out infinite; }
.result-title { font-size: 26px; font-weight: 900; text-align: center; margin-bottom: 8px; }
.result-points {
    text-align: center;
    font-size: 48px; font-weight: 900;
    color: var(--gold);
    text-shadow: 0 0 20px rgba(245,166,35,0.4);
    line-height: 1; margin-bottom: 6px;
}
.result-temps {
    display: flex; justify-content: center;
    gap: 6px; font-size: 13px;
    color: var(--muted); margin-bottom: 20px;
    align-items: center;
}
.score-cumul {
    background: rgba(245,166,35,0.06);
    border: 1px solid rgba(245,166,35,0.2);
    border-radius: 18px;
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.score-cumul-label { font-size: 13px; color: var(--muted); font-weight: 600; }
.score-cumul-val   { font-size: 22px; font-weight: 900; color: var(--gold); }

/* ===============================
   ÉCRAN 5 : CLASSEMENT
=============================== */
.ranking-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 18px;
    border-radius: 16px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    margin-bottom: 10px;
    transition: .2s;
}
.ranking-item.is-me {
    background: rgba(245,166,35,0.07);
    border-color: rgba(245,166,35,0.3);
    box-shadow: 0 0 0 1px rgba(245,166,35,0.1);
}
.ranking-pos {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 900;
    flex-shrink: 0;
    background: rgba(255,255,255,0.06);
    color: var(--muted);
}
.ranking-pos.gold   { background: linear-gradient(135deg,var(--gold2),var(--gold)); color:#000; }
.ranking-pos.silver { background: linear-gradient(135deg,#C0C0C0,#A9A9A9); color:#000; }
.ranking-pos.bronze { background: linear-gradient(135deg,#CD7F32,#B8860B); color:#000; }

.ranking-name { flex: 1; font-size: 14px; font-weight: 600; }
.ranking-name small { display: block; font-size: 11px; color: var(--muted); font-weight: 400; }
.ranking-score { font-size: 16px; font-weight: 800; color: var(--gold); }

/* ===============================
   ÉCRAN 6 : FIN
=============================== */
.finale-screen { text-align: center; }
.finale-trophy {
    font-size: 100px;
    margin-bottom: 16px;
    filter: drop-shadow(0 0 30px rgba(245,166,35,0.5));
    animation: trophyFloat 3s ease-in-out infinite;
}

</style>

</head>
<body>

<!-- ===================== TOPBAR ===================== -->
<div class="topbar">
    <div class="topbar-logo">
        <img src="../assets/img/logo.png" alt="Logo"
             onerror="this.style.display='none'">
        <div class="topbar-title">Going For <span>Gold</span></div>
    </div>
    <div id="topbar-right">
        <div class="live-badge" id="live-badge" style="display:none;">
            <div class="dot"></div>
            <span id="badge-nom">Participant</span>
        </div>
    </div>
</div>

<!-- ===================== WRAPPER ===================== -->
<div class="page-wrap">


<!-- =========================================
     ÉCRAN 1 : CONNEXION
========================================= -->

<!-- =========================================
     ÉCRAN 2 : SALLE D'ATTENTE
========================================= -->
<div class="screen active" id="screen-attente">

    <div class="card card-gold">
        <div class="glow-line-top"></div>

        <div class="waiting-hero">

            <!-- Avatar initiale -->
            <div class="waiting-avatar" id="waiting-avatar">A</div>
            <div class="waiting-name">
                Bienvenue, <span id="waiting-name-display">—</span> !
            </div>
            <div class="waiting-subtitle">
                Vous êtes inscrit(e). La compétition va bientôt commencer.
            </div>

            <!-- Animation pulse -->
            <div class="waiting-pulse">
                <div class="pulse-ring">
                    <div class="pulse-icon">⏳</div>
                </div>
            </div>

            <!-- Statut live -->
            <div style="background:rgba(0,255,136,0.08);
                        border:1px solid rgba(0,255,136,0.2);
                        border-radius:14px;padding:14px 20px;
                        font-size:13px;font-weight:600;color:var(--green);
                        display:flex;align-items:center;gap:10px;
                        justify-content:center;margin-bottom:20px;">
                <div class="dot"></div>
                En attente du démarrage par l'organisateur
            </div>

            <!-- Infos 2x2 -->
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-val" id="attente-nb-participants">—</div>
                    <div class="info-card-label">Participants</div>
                </div>
                <div class="info-card">
                    <div class="info-card-val">10</div>
                    <div class="info-card-label">Questions</div>
                </div>
                <div class="info-card">
                    <div class="info-card-val">10s</div>
                    <div class="info-card-label">Par question</div>
                </div>
                <div class="info-card">
                    <div class="info-card-val" id="attente-groupe">—</div>
                    <div class="info-card-label">Mon groupe</div>
                </div>
            </div>

        </div>
    </div>

</div><!-- /screen-attente -->


<!-- =========================================
     ÉCRAN 3 : QUESTION EN COURS
========================================= -->
<div class="screen" id="screen-question">

    <div class="card card-gold">
        <div class="glow-line-top"></div>

        <!-- En-tête : label + chrono -->
        <div class="question-header">
            <div>
                <div class="q-round-label" id="q-round-label">FIRST ROUND 1</div>
                <div class="q-badge" id="q-badge">Q1 / 10</div>
            </div>

            <!-- Chrono SVG circulaire -->
            <div class="chrono-circle">
                <svg class="chrono-svg" viewBox="0 0 100 100">
                    <circle class="chrono-bg" cx="50" cy="50" r="40"/>
                    <circle class="chrono-arc" id="chrono-arc" cx="50" cy="50" r="40"/>
                </svg>
                <div class="chrono-num-wrap">
                    <div class="chrono-num" id="chrono-num">10</div>
                    <div class="chrono-sec">sec</div>
                </div>
            </div>
        </div>

        <!-- Barre de progression -->
        <div class="progress-bar-wrap">
            <div class="progress-bar-fill" id="q-progress-fill" style="width:10%;"></div>
        </div>

        <!-- Texte de la question -->
        <div class="q-texte" id="q-texte">
            Chargement de la question...
        </div>

        <!-- Les 4 choix -->
        <div class="choix-grid" id="choix-grid"></div>

        <!-- Message après réponse -->
        <div id="reponse-msg"
             style="display:none;text-align:center;font-size:14px;
                    font-weight:700;padding:12px;border-radius:12px;
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.08);color:var(--muted);">
            ✅ Réponse enregistrée — en attente de la correction...
        </div>

    </div>

</div><!-- /screen-question -->


<!-- =========================================
     ÉCRAN 4 : RÉSULTAT D'UNE QUESTION
========================================= -->
<div class="screen" id="screen-resultat">

    <div class="card card-gold" style="text-align:center;">
        <div class="glow-line-top"></div>
        <div class="star-top">✦</div>

        <!-- Icône résultat -->
        <div class="result-icon" id="result-icon">✅</div>
        <div class="result-title" id="result-title">Bonne réponse !</div>

        <!-- Points gagnés -->
        <div style="margin:16px 0 6px;">
            <div style="font-size:12px;color:var(--muted);letter-spacing:2px;
                        font-weight:700;margin-bottom:8px;">POINTS GAGNÉS</div>
            <div class="result-points" id="result-points">+850</div>
        </div>

        <!-- Temps de réponse -->
        <div class="result-temps">
            <span>⏱</span>
            <span>Répondu en
                <strong id="result-temps-val">3.2s</strong>
            </span>
        </div>

        <!-- Score total cumulé -->
        <div class="score-cumul">
            <div class="score-cumul-label">Score total</div>
            <div class="score-cumul-val" id="score-total-display">0 pts</div>
        </div>

        <!-- Rang actuel -->
        <div style="margin-top:14px;
                    background:rgba(124,58,237,0.08);
                    border:1px solid rgba(124,58,237,0.2);
                    border-radius:14px;padding:14px 20px;
                    display:flex;justify-content:space-between;align-items:center;">
            <div style="font-size:13px;color:var(--muted);">Votre classement</div>
            <div style="font-size:18px;font-weight:900;color:#A78BFA;"
                 id="result-rang">—</div>
        </div>

    </div>

</div><!-- /screen-resultat -->


<!-- =========================================
     ÉCRAN 5 : CLASSEMENT INTERMÉDIAIRE
========================================= -->
<div class="screen" id="screen-classement">

    <div class="card" style="margin-bottom:20px;">
        <div class="glow-line-top"></div>

        <!-- Titre -->
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
            <div style="width:40px;height:40px;border-radius:50%;
                        background:rgba(245,166,35,0.2);
                        display:flex;align-items:center;
                        justify-content:center;font-size:20px;">
                🏅
            </div>
            <div>
                <div style="font-size:18px;font-weight:900;">Classement</div>
                <div style="font-size:12px;color:var(--muted);"
                     id="classement-subtitle">Après la question —</div>
            </div>
        </div>

        <!-- Liste classement -->
        <div id="ranking-list"></div>

    </div>

    <!-- Message attente -->
    <div style="text-align:center;font-size:13px;color:var(--muted);
                display:flex;align-items:center;justify-content:center;gap:8px;">
        <div class="dot"></div>
        Prochaine question dans quelques instants...
    </div>

</div><!-- /screen-classement -->


<!-- =========================================
     ÉCRAN 6 : FIN DU ROUND / COMPÉTITION
========================================= -->
<div class="screen" id="screen-fin">

    <div class="card card-gold" style="text-align:center;">
        <div class="glow-line-top"></div>

        <div class="finale-screen">

            <!-- Emoji dynamique -->
            <div class="finale-trophy" id="fin-emoji">🏆</div>

            <div style="font-size:12px;letter-spacing:3px;color:var(--gold);
                        font-weight:700;margin-bottom:12px;"
                 id="fin-label">ROUND TERMINÉ</div>

            <div style="font-size:30px;font-weight:900;margin-bottom:10px;"
                 id="fin-title">Bien joué !</div>

            <div style="font-size:14px;color:var(--muted);line-height:1.7;
                        margin-bottom:28px;"
                 id="fin-msg">
                Votre round est terminé. Attendez les résultats finaux.
            </div>

            <!-- Score final -->
            <div style="background:linear-gradient(135deg,
                            rgba(245,166,35,0.1),rgba(124,58,237,0.08));
                        border:1px solid rgba(245,166,35,0.25);
                        border-radius:20px;padding:28px;margin-bottom:20px;">
                <div style="font-size:11px;letter-spacing:2px;
                            color:var(--muted);font-weight:700;margin-bottom:12px;">
                    VOTRE SCORE FINAL
                </div>
                <div style="font-size:64px;font-weight:900;color:var(--gold);
                            text-shadow:0 0 25px rgba(245,166,35,0.5);line-height:1;"
                     id="fin-score">0</div>
                <div style="font-size:14px;color:var(--muted);margin-top:8px;">
                    points
                </div>
            </div>

            <!-- Podium top 3 (si disponible) -->
            <div id="fin-podium" style="margin-bottom:24px;"></div>

            <!-- Statut attente -->
            <div style="font-size:13px;color:var(--muted);">
                <div class="dot"
                     style="display:inline-block;margin-right:6px;"></div>
                En attente de l'annonce officielle des résultats
            </div>

        </div>
    </div>

</div><!-- /screen-fin -->


</div><!-- /page-wrap -->

<script>

// ================================================================
// ÉTAT GLOBAL
// ================================================================
// Données injectées depuis PHP (session)
const state = {
    participantId: parseInt(localStorage.getItem('participantId')) || 0,
    nom:           localStorage.getItem('participantNom') || '',
    sessionId:     parseInt(localStorage.getItem('sessionId')) || 0,
    groupe:        localStorage.getItem('groupeNom') || null,
    sessionCode:   null,
    scoreTotal:    0,
    questionActuelle: null,
    reponseEnvoyee:   false,
    tempsDebut:       null,
    pollingTimer:     null,
    questionIndex:    0,
    totalQuestions:   10,
    chronoInterval:   null,
    phase: 'attente'   // on démarre directement en attente
};


function showScreen(name) {
    document.querySelectorAll('.screen').forEach(s => {
        s.classList.remove('active');
        s.style.display = 'none';
    });
    const screen = document.getElementById('screen-' + name);
    if (screen) {
        screen.classList.add('active');
        screen.style.display = 'block';
    }
    state.phase = name;
}
// ================================================================
// ÉCRAN 1 — CONNEXION
// ================================================================


// ================================================================
// ÉCRAN 2 — SALLE D'ATTENTE
// ================================================================
function entrerSalleAttente() {
    // Préparer l'UI
    document.getElementById('waiting-avatar').textContent =
        state.nom.charAt(0).toUpperCase();
    document.getElementById('waiting-name-display').textContent = state.nom;
    document.getElementById('attente-groupe').textContent =
        state.groupe ? state.groupe.replace('First Round ', 'G') : '—';

    // Topbar badge
    document.getElementById('live-badge').style.display = 'flex';
    document.getElementById('badge-nom').textContent = state.nom;

    showScreen('attente');
    demarrerPollingSession();
}

async function demarrerPollingSession() {
    if (state.pollingTimer) clearInterval(state.pollingTimer);
 
    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=status&participant_id=${state.participantId}`
            );
            const data = await res.json();
 
            if (data.nb_participants !== undefined) {
                document.getElementById('attente-nb-participants')
                    .textContent = data.nb_participants;
            }
            if (data.groupe_nom) {
                state.groupe = data.groupe_nom;
                document.getElementById('attente-groupe').textContent =
                    data.groupe_nom.replace('First Round ', 'G');
            }
 
            if (data.session_phase === 'en_cours' && data.question) {
                const nouvelleQuestion = !state.questionActuelle ||
                    state.questionActuelle.id !== data.question.id;
 
                if (nouvelleQuestion) {
                    // Nouvelle question → charger l'écran
                    clearInterval(state.pollingTimer);
                    chargerQuestion(
                        data.question,
                        data.question_index,
                        data.total_questions,
                        data.round
                    );
                    // Le chrono démarrera quand chrono_demarre=1
                    if (data.chrono_demarre) {
                        demarrerChrono(10);
                    }
                } else if (data.chrono_demarre && !state.chronoEnCours) {
                    // Même question mais chrono vient de démarrer
                    clearInterval(state.pollingTimer);
                    demarrerChrono(10);
                }
            }
 
        } catch(e) { /* silencieux */ }
    };
 
    await poll();
    state.pollingTimer = setInterval(poll, 2000);
}
// ================================================================
// ÉCRAN 3 — QUESTION
// ================================================================
function chargerQuestion(question, index, total, round) {
    clearInterval(state.pollingTimer);
 
    state.questionActuelle = question;
    state.reponseEnvoyee   = false;
    state.tempsDebut       = null;
    state.questionIndex    = index;
    state.totalQuestions   = total;
    state.chronoEnCours    = false; // reset flag
 
    // Labels
    document.getElementById('q-round-label').textContent =
        round === 'finale' ? '✨ FINALE' : `FIRST ROUND ${round || ''}`;
    document.getElementById('q-badge').textContent = `Q${index} / ${total}`;
 
    // Barre progression
    document.getElementById('q-progress-fill').style.width =
        ((index / total) * 100) + '%';
 
    // Texte question
    document.getElementById('q-texte').textContent = question.texte;
 
    // Générer les 4 boutons choix
    const choixData = [
        question.choix_1,
        question.choix_2,
        question.choix_3,
        question.choix_4
    ];
    document.getElementById('choix-grid').innerHTML = choixData.map((c, i) => `
        <button class="choix-btn" id="choix-${i+1}" onclick="repondre(${i+1})">
            <div class="choix-num">${i+1}</div>
            <span>${c}</span>
        </button>
    `).join('');
 
    document.getElementById('reponse-msg').style.display = 'none';
 
    // Réinitialiser le chrono visuellement sans le démarrer
    document.getElementById('chrono-num').textContent = '10';
    const arc = document.getElementById('chrono-arc');
    if (arc) {
        arc.style.strokeDashoffset = '0';
        arc.style.stroke = 'var(--gold)';
        arc.style.filter = 'drop-shadow(0 0 6px rgba(245,166,35,0.6))';
    }
 
    showScreen('question');
 
    // Attendre le top chrono de l'admin (polling chrono_demarre)
    demarrerPollingChrono();
}
// ================================================================
// CHRONO CIRCULAIRE SVG
// ================================================================
function demarrerChrono(duree) {
    if (state.chronoInterval) clearInterval(state.chronoInterval);
 
    state.chronoEnCours = true; // FLAG
 
    const arc   = document.getElementById('chrono-arc');
    const numEl = document.getElementById('chrono-num');
    const circonference = 251;
 
    let restant = duree;
    state.tempsDebut = Date.now();
 
    const update = () => {
        numEl.textContent = restant;
 
        const ratio = restant / duree;
        arc.style.strokeDashoffset = circonference * (1 - ratio);
 
        if (restant <= 3) {
            arc.style.stroke = 'var(--red)';
            arc.style.filter = 'drop-shadow(0 0 6px rgba(255,75,75,0.8))';
            numEl.style.color = 'var(--red)';
            numEl.style.animation = 'countdownPulse 0.5s ease infinite';
        } else if (restant <= 5) {
            arc.style.stroke = '#FF9500';
            arc.style.filter = 'drop-shadow(0 0 6px rgba(255,149,0,0.6))';
            numEl.style.color = '#FF9500';
            numEl.style.animation = 'none';
        } else {
            arc.style.stroke = 'var(--gold)';
            arc.style.filter = 'drop-shadow(0 0 6px rgba(245,166,35,0.6))';
            numEl.style.color = 'var(--gold)';
            numEl.style.animation = 'none';
        }
 
        if (restant <= 0) {
    clearInterval(state.chronoInterval);
    state.chronoEnCours = false;
    bloquerReponses();
    demarrerPollingResultat(); // ✅ AJOUT
    return;
     }
        restant--;
    };
 
    update();
    state.chronoInterval = setInterval(update, 1000);
}

function bloquerReponses() {
    document.querySelectorAll('.choix-btn').forEach(b => b.disabled = true);
    if (!state.reponseEnvoyee) {
        const msg = document.getElementById('reponse-msg');
        msg.style.display = 'block';
        msg.textContent = '⏰ Temps écoulé ! En attente de la correction...';
        demarrerPollingResultat();
    }
}

// ================================================================
// RÉPONDRE À UNE QUESTION
// ================================================================
async function repondre(choix) {
    if (state.reponseEnvoyee) return;
    if (!state.questionActuelle) return;

    state.reponseEnvoyee = true;

    const tempsReponse = state.tempsDebut
        ? Math.max(0, Math.round((Date.now() - state.tempsDebut) / 100) / 10)
        : 10;

    // Feedback visuel immédiat
    document.querySelectorAll('.choix-btn').forEach(b => b.disabled = true);
    const btnChoisi = document.getElementById('choix-' + choix);
    if (btnChoisi) btnChoisi.classList.add('selected');

    document.getElementById('reponse-msg').style.display = 'block';

    try {
        const res = await fetch('../api/participant.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action:        'repondre',
                participant_id: state.participantId,
                question_id:   state.questionActuelle.id,
                reponse:       choix,
                temps_reponse: tempsReponse
            })
        });
        const data = await res.json();

        if (data.success) {
            afficherFeedbackReponse(
                choix,
                data.bonne_reponse,
                data.points,
                tempsReponse
            );
        }
    } catch(e) {
        document.getElementById('reponse-msg').textContent = '✅ Réponse enregistrée !';
    }

    demarrerPollingResultat();
}

// ================================================================
// FEEDBACK VISUEL CORRECT / FAUX
// ================================================================
function afficherFeedbackReponse(maReponse, bonneReponse, points, temps) {
    const correct = (parseInt(maReponse) === parseInt(bonneReponse));

    document.querySelectorAll('.choix-btn').forEach((b, i) => {
        const num = i + 1;
        if (num === parseInt(bonneReponse)) b.classList.add('reveal-correct');
        if (num === parseInt(maReponse) && !correct) b.classList.add('wrong');
        if (num === parseInt(maReponse) &&  correct) b.classList.add('correct');
    });

    const msg = document.getElementById('reponse-msg');
    if (correct) {
        msg.style.color      = 'var(--green)';
        msg.style.background = 'rgba(0,255,136,0.08)';
        msg.style.border     = '1px solid rgba(0,255,136,0.2)';
        msg.textContent      = `✅ Bonne réponse ! +${points} points`;
    } else {
        msg.style.color      = 'var(--red)';
        msg.style.background = 'rgba(255,75,75,0.08)';
        msg.style.border     = '1px solid rgba(255,75,75,0.2)';
        msg.textContent      = `❌ Mauvaise réponse. Bonne réponse : choix ${bonneReponse}.`;
    }

    state.scoreTotal += (points || 0);
}

// ================================================================
// POLLING — PROCHAINE QUESTION / RÉSULTAT
// ================================================================
async function demarrerPollingResultat() {
    if (state.pollingTimer) clearInterval(state.pollingTimer);

    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=prochaine_question&participant_id=${state.participantId}`
            );
            const data = await res.json();

            if (data.phase === 'resultat') {
                clearInterval(state.pollingTimer);
                afficherResultat(
                    data.correct,
                    data.points_question || 0,
                    data.temps_reponse   || 0,
                    data.score_total     || state.scoreTotal,
                    data.mon_rang,
                    data.bonne_reponse,
                    data.ma_reponse
                );

            } else if (data.phase === 'classement') {
                clearInterval(state.pollingTimer);
                afficherClassement(
                    data.classement,
                    data.mon_rang,
                    data.question_index
                );

            } else if (data.phase === 'question' &&
                       data.question_id !== state.questionActuelle?.id) {
                clearInterval(state.pollingTimer);
                chargerQuestion(
                    data.question,
                    data.question_index,
                    data.total_questions,
                    data.round
                );

            } else if (data.phase === 'fin') {
                clearInterval(state.pollingTimer);
                afficherFin(data);
            }

        } catch(e) { /* silencieux */ }
    };

    await poll();
    state.pollingTimer = setInterval(poll, 2000);
}

// ================================================================
// ÉCRAN 4 — RÉSULTAT QUESTION
// ================================================================
function afficherResultat(correct, points, temps, scoreTotal, rang, bonneRep, maRep) {
    clearInterval(state.chronoInterval);

    document.getElementById('result-icon').textContent  = correct ? '🎯' : '😔';
    document.getElementById('result-title').textContent = correct ? 'Bonne réponse !' : 'Mauvaise réponse…';
    document.getElementById('result-title').style.color = correct ? 'var(--green)' : 'var(--red)';

    document.getElementById('result-points').textContent = correct ? '+' + points : '0';
    document.getElementById('result-points').style.color = correct ? 'var(--gold)' : 'var(--muted)';

    document.getElementById('result-temps-val').textContent =
        parseFloat(temps).toFixed(1) + 's';

    state.scoreTotal = scoreTotal;
    document.getElementById('score-total-display').textContent = scoreTotal + ' pts';
    document.getElementById('result-rang').textContent = rang ? '# ' + rang : '—';

    showScreen('resultat');
    demarrerPollingDepuisResultat();
}

async function demarrerPollingDepuisResultat() {
    if (state.pollingTimer) clearInterval(state.pollingTimer);

    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=prochaine_question&participant_id=${state.participantId}`
            );
            const data = await res.json();

            if (data.phase === 'question' &&
                data.question_id !== state.questionActuelle?.id) {
                clearInterval(state.pollingTimer);
                chargerQuestion(data.question, data.question_index, data.total_questions, data.round);

            } else if (data.phase === 'classement') {
                clearInterval(state.pollingTimer);
                afficherClassement(data.classement, data.mon_rang, data.question_index);

            } else if (data.phase === 'fin') {
                clearInterval(state.pollingTimer);
                afficherFin(data);
            }
        } catch(e) { /* silencieux */ }
    };

    state.pollingTimer = setInterval(poll, 2000);
}

// ================================================================
// ÉCRAN 5 — CLASSEMENT INTERMÉDIAIRE
// ================================================================
function afficherClassement(classement, monRang, questionIndex) {
    if (!Array.isArray(classement)) classement = [];

    document.getElementById('classement-subtitle').textContent =
        `Après la question ${questionIndex || '—'}`;

    const medals   = ['gold', 'silver', 'bronze'];
    const emojis   = ['🥇', '🥈', '🥉'];

    document.getElementById('ranking-list').innerHTML =
        classement.slice(0, 10).map((p, i) => {
            const isMe = (p.id === state.participantId || p.nom === state.nom);
            return `
            <div class="ranking-item ${isMe ? 'is-me' : ''}">
                <div class="ranking-pos ${medals[i] || ''}">
                    ${emojis[i] || (i + 1)}
                </div>
                <div class="ranking-name">
                    ${p.nom}
                    ${isMe ? `<small>← Vous</small>` : ''}
                </div>
                <div class="ranking-score">${p.total_points} pts</div>
            </div>`;
        }).join('') ||
        `<div style="color:var(--muted);text-align:center;padding:20px;">
            Aucun classement disponible.
         </div>`;

    showScreen('classement');
    demarrerPollingResultat();
}

// ================================================================
// ÉCRAN 6 — FIN
// ================================================================
function afficherFin(data) {
    clearInterval(state.pollingTimer);
    clearInterval(state.chronoInterval);

    const scoreTotal = data.score_finale || data.score_total || state.scoreTotal;
    const rang       = data.mon_rang    || '—';
    const estFinale  = data.round === 'finale';
    const qualifie   = data.qualifie    || false;

    document.getElementById('fin-score').textContent = scoreTotal;

    if (estFinale && rang === 1) {
        // 🏆 Champion
        document.getElementById('fin-emoji').textContent  = '🏆';
        document.getElementById('fin-label').textContent  = '🎉 CHAMPION GOING FOR GOLD';
        document.getElementById('fin-title').textContent  = 'Félicitations !';
        document.getElementById('fin-msg').textContent    =
            'Vous êtes le Grand Champion de la compétition Going For Gold !';

    } else if (estFinale && rang === 2) {
        // 🥈 2ème
        document.getElementById('fin-emoji').textContent  = '🥈';
        document.getElementById('fin-label').textContent  = 'FINALE TERMINÉE';
        document.getElementById('fin-title').textContent  = 'Superbe performance !';
        document.getElementById('fin-msg').textContent    = 'Vous terminez à la 2ème place de la compétition.';

    } else if (estFinale && rang === 3) {
        // 🥉 3ème
        document.getElementById('fin-emoji').textContent  = '🥉';
        document.getElementById('fin-label').textContent  = 'FINALE TERMINÉE';
        document.getElementById('fin-title').textContent  = 'Bien joué !';
        document.getElementById('fin-msg').textContent    = 'Vous terminez à la 3ème place de la compétition.';

    } else if (qualifie) {
        // Qualifié mais finale pas encore terminée
        document.getElementById('fin-emoji').textContent  = '⭐';
        document.getElementById('fin-label').textContent  = 'QUALIFIÉ(E) POUR LA FINALE';
        document.getElementById('fin-title').textContent  = 'Vous êtes en Finale !';
        document.getElementById('fin-msg').textContent    =
            'Félicitations ! Vous avez terminé premier(e) de votre round.';

    } else {
        // Non qualifié
        document.getElementById('fin-emoji').textContent  = '👏';
        document.getElementById('fin-label').textContent  = 'ROUND TERMINÉ';
        document.getElementById('fin-title').textContent  = `Classé(e) #${rang}`;
        document.getElementById('fin-msg').textContent    =
            'Merci pour votre participation. Résultats annoncés prochainement.';
    }

    // ✅ Afficher le podium pour TOUS si la finale est terminée
    if (estFinale) {
        afficherPodiumParticipant();
    }

    showScreen('fin');

    // Si qualifié ET finale pas encore commencée → continuer à poller
    if (qualifie && !estFinale) {
        demarrerPollingFinale();
    }
}
// ================================================================
// POLLING FINALE — attendre le démarrage de la finale
// ================================================================
function demarrerPollingFinale() {
    if (state.pollingTimer) clearInterval(state.pollingTimer);

    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=status&participant_id=${state.participantId}`
            );
            const data = await res.json();

            if (data.session_phase === 'en_cours' && data.question) {
                const nouvelleQuestion = !state.questionActuelle ||
                    state.questionActuelle.id !== data.question.id;

                if (nouvelleQuestion) {
                    clearInterval(state.pollingTimer);
                    chargerQuestion(
                        data.question,
                        data.question_index,
                        data.total_questions,
                        data.round
                    );
                    if (data.chrono_demarre) {
                        demarrerChrono(10);
                    }
                } else if (data.chrono_demarre && !state.chronoEnCours) {
                    clearInterval(state.pollingTimer);
                    demarrerChrono(10);
                }

            // ✅ AJOUT : détecter que la finale est terminée
            } else if (data.session_phase === 'attente') {

                // Vérifier si la finale existe et est terminée
                try {
                    const resClassement = await fetch('../api/classement.php?type=finale');
                    const podium = await resClassement.json();

                    if (Array.isArray(podium) && podium.length > 0) {
                        // La finale est terminée, on a des résultats
                        clearInterval(state.pollingTimer);

                        // Trouver mon rang dans le podium
                        const monRang = podium.findIndex(p => p.id == state.participantId) + 1;
                        const monScore = podium.find(p => p.id == state.participantId)?.total_points || 0;

                        afficherFin({
                            round:       'finale',
                            mon_rang:    monRang > 0 ? monRang : '—',
                            score_total: monScore
                        });
                    }
                    // Sinon finale pas encore jouée → continuer à attendre
                } catch(e) { }

            } else if (data.session_phase === 'termine') {
                clearInterval(state.pollingTimer);
                afficherFin(data);
            }

        } catch(e) { }
    };

    poll();
    state.pollingTimer = setInterval(poll, 2000);
}
// ================================================================
// RESTAURER SESSION (rechargement de page)
// ================================================================


// ================================================================
// RACCOURCIS CLAVIER (touches 1-4 pour répondre)
// ================================================================
document.addEventListener('keydown', e => {
    if (state.phase === 'question' && !state.reponseEnvoyee) {
        if (['1','2','3','4'].includes(e.key)) {
            repondre(parseInt(e.key));
        }
    }
});

// ================================================================
// INIT — Restaurer session si rechargement
// ================================================================
window.addEventListener('load', async () => {

// Remplir l'UI avec les données de session
document.getElementById('waiting-avatar').textContent =
    state.nom.charAt(0).toUpperCase();
document.getElementById('waiting-name-display').textContent = state.nom;
document.getElementById('attente-groupe').textContent =
    state.groupe ? state.groupe.replace('First Round ', 'G') : '—';

// Topbar badge
document.getElementById('live-badge').style.display = 'flex';
document.getElementById('badge-nom').textContent = state.nom;

// Vérifier si une question est déjà en cours
try {
    const res = await fetch(
        `../api/participant.php?action=status&participant_id=${state.participantId}`
    );
    const data = await res.json();

    if (data.session_phase === 'en_cours' && data.question) {
        chargerQuestion(
            data.question,
            data.question_index,
            data.total_questions,
            data.round
        );
    } else if (data.session_phase === 'termine') {
        afficherFin(data);
    } else {
        // Rester en salle d'attente + polling
        demarrerPollingSession();
    }

} catch(e) {
    demarrerPollingSession();
}
});


function demarrerPollingChrono() {
    if (state.pollingTimer) clearInterval(state.pollingTimer);

    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=status&participant_id=${state.participantId}`
            );
            const data = await res.json();

            // ✅ AJOUT : si la question a changé, recharger
            if (data.session_phase === 'en_cours' && data.question) {
                if (data.question.id !== state.questionActuelle?.id) {
                    clearInterval(state.pollingTimer);
                    chargerQuestion(
                        data.question,
                        data.question_index,
                        data.total_questions,
                        data.round
                    );
                    return;
                }

                // ✅ Chrono démarre
                if (data.chrono_demarre && !state.chronoEnCours) {
                    clearInterval(state.pollingTimer);
                    demarrerChrono(10);
                    // ✅ AJOUT : relancer polling résultat après chrono
                    setTimeout(() => {
                        if (!state.reponseEnvoyee) {
                            demarrerPollingResultat();
                        }
                    }, 10500);
                    return;
                }
            } else if (data.session_phase === 'termine') {
                clearInterval(state.pollingTimer);
                afficherFin(data);
            }
        } catch(e) { }
    };

    poll();
    state.pollingTimer = setInterval(poll, 1000);
}


async function afficherPodiumParticipant() {
    try {
        const res = await fetch('../api/classement.php?type=finale');
        const data = await res.json();

        if (!Array.isArray(data) || data.length === 0) return;

        const medals  = ['🥇', '🥈', '🥉'];
        const couleurs = ['#F5A623', '#C0C0C0', '#CD7F32'];

        const podiumHTML = `
            <div style="margin-top:8px;">
                <div style="font-size:12px;letter-spacing:2px;color:var(--gold);
                            font-weight:700;margin-bottom:16px;text-align:center;">
                    🏆 PODIUM FINAL
                </div>
                ${data.slice(0, 3).map((p, i) => {
    const isMe = p.id == state.participantId;
    return `
        <div style="display:flex;align-items:center;gap:14px;
                    padding:14px 18px;border-radius:16px;margin-bottom:10px;
                    background:${i === 0 ? 'rgba(245,166,35,0.10)' : 'rgba(255,255,255,0.04)'};
                    border:1px solid ${i === 0 ? 'rgba(245,166,35,0.3)' : 'rgba(255,255,255,0.08)'};">
            <span style="font-size:24px;">${medals[i]}</span>
            <div style="flex:1;">
                <div style="font-weight:800;font-size:15px;
                            color:${isMe ? 'var(--gold)' : 'var(--text)'};">
                    ${p.nom} ${isMe ? '<small style="color:var(--gold);">← Vous</small>' : ''}
                </div>
            </div>
            <div style="font-weight:900;font-size:16px;color:${couleurs[i]};">
                ${p.total_points} pts
            </div>
        </div>`;
}).join('')}
            </div>`;

        document.getElementById('fin-podium').innerHTML = podiumHTML;

    } catch(e) { /* silencieux */ }
}


</script>

</body>
</html>