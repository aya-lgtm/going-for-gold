<?php
/* =========================================================
   GOING FOR GOLD — PARTICIPANT LOBBY PREMIUM
   VERSION : ULTRA PREMIUM UI
   ========================================================= */

/* -----------------------------
   DEMO DATA
----------------------------- */

$participant = "Aya";
$round = 1;
$totalParticipants = 24;
$position = 12;

$leaderboard = [
    [
        "name" => "Samir",
        "score" => 950,
        "status" => "Leader actuel"
    ],
    [
        "name" => "Lina",
        "score" => 920,
        "status" => "Très proche"
    ],
    [
        "name" => "Youssef",
        "score" => 880,
        "status" => "Excellent score"
    ]
];

?>

<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Going For Gold — Participant Lobby</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>

/* =========================================================
   ROOT
========================================================= */

:root{

    --bg:#050510;

    --panel:#0F1020;

    --gold:#F5A623;
    --gold-light:#FFD700;

    --purple:#7C3AED;

    --green:#00FF88;

    --text:#FFFFFF;
    --muted:#9CA3AF;

    --border:rgba(255,255,255,0.08);

}

/* =========================================================
   RESET
========================================================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html,
body{
    width:100%;
    height:100%;
}

/* =========================================================
   BODY
========================================================= */

body{

    font-family:'Poppins',sans-serif;

    color:var(--text);

    overflow-x:hidden;
    overflow-y:auto;

    background:
    radial-gradient(circle at top right,
    rgba(124,58,237,0.20),
    transparent 30%),

    radial-gradient(circle at bottom left,
    rgba(245,166,35,0.15),
    transparent 30%),

    #050510;

    position:relative;

}

/* GRID BACKGROUND */

body::before{

    content:"";

    position:absolute;

    inset:0;

    background-image:
    linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);

    background-size:40px 40px;

    pointer-events:none;

}

/* BIG PURPLE GLOW */

body::after{

    content:"";

    position:absolute;

    width:700px;
    height:700px;

    border-radius:50%;

    background:
    radial-gradient(circle,
    rgba(124,58,237,0.18),
    transparent 70%);

    top:-250px;
    right:-200px;

    filter:blur(40px);

    pointer-events:none;

}

/* =========================================================
   FLOATING PARTICLES
========================================================= */

.particle{

    position:absolute;

    color:rgba(255,215,0,0.4);

    animation:pulse 3s infinite;

}

.p1{
    top:100px;
    left:100px;
    font-size:18px;
}

.p2{
    top:220px;
    right:220px;
    font-size:12px;
}

.p3{
    bottom:140px;
    left:300px;
    font-size:14px;
}

/* =========================================================
   MAIN CONTAINER
========================================================= */

.container{

    position:relative;

    z-index:2;

    width:100%;

    min-height:100vh;

    padding:28px;

    display:flex;

    flex-direction:column;

}

/* =========================================================
   HEADER
========================================================= */

.header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:28px;

}

/* =========================================================
   LOGO
========================================================= */

.logo-wrap{

    display:flex;

    align-items:center;

    gap:18px;

}

.logo{

    width:82px;
    height:82px;

    border-radius:26px;

    background:
    linear-gradient(145deg,#1A1B35,#10111F);

    border:1px solid rgba(255,215,0,0.25);

    display:flex;

    align-items:center;
    justify-content:center;

    box-shadow:
    0 0 40px rgba(245,166,35,0.18),
    inset 0 0 20px rgba(255,255,255,0.03);

    animation:float 4s ease-in-out infinite;

}

.logo img{

    width:58px;
    object-fit:contain;

}

.title h1{

    font-size:42px;

    font-weight:900;

    line-height:1;

}

.title p{

    margin-top:8px;

    color:var(--muted);

}

/* =========================================================
   LIVE BADGE
========================================================= */

.live-badge{

    display:flex;

    align-items:center;

    gap:12px;

    padding:14px 24px;

    border-radius:999px;

    background:rgba(0,255,136,0.08);

    border:1px solid rgba(0,255,136,0.2);

    color:var(--green);

    font-weight:700;

    box-shadow:
    0 0 20px rgba(0,255,136,0.08);

}

.dot{

    width:10px;
    height:10px;

    border-radius:50%;

    background:var(--green);

    box-shadow:0 0 12px var(--green);

    animation:pulse 1.2s infinite;

}

/* =========================================================
   CONTENT
========================================================= */

.content{

    flex:1;

    display:grid;

    grid-template-columns:1.35fr 0.65fr;

    gap:24px;

}

/* =========================================================
   PANELS
========================================================= */

.panel{

    background:
    linear-gradient(
    145deg,
    rgba(15,16,32,0.95),
    rgba(10,10,25,0.92));

    border:1px solid var(--border);

    border-radius:32px;

    padding:30px;

    position:relative;

    overflow:hidden;

    backdrop-filter:blur(18px);

}

/* TOP BORDER */

.panel::before{

    content:"";

    position:absolute;

    top:0;
    left:0;
    right:0;

    height:2px;

    background:
    linear-gradient(
    90deg,
    transparent,
    var(--gold),
    var(--purple),
    transparent);

}

/* =========================================================
   WAITING PANEL
========================================================= */

.waiting-panel{

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    text-align:center;

    position:relative;

}

/* BIG GLOW */

.waiting-panel::after{

    content:"";

    position:absolute;

    width:550px;
    height:550px;

    border-radius:50%;

    background:
    radial-gradient(circle,
    rgba(124,58,237,0.18),
    transparent 70%);

    filter:blur(40px);

    z-index:0;

}

/* =========================================================
   LOADER
========================================================= */

/* =========================================================
   HEARTBEAT LOGO
========================================================= */

.logo-heartbeat{

position:relative;

width:240px;
height:240px;

display:flex;

align-items:center;
justify-content:center;

margin-bottom:40px;

z-index:2;

}

/* =========================================================
OUTER RING
========================================================= */

.heartbeat-ring{

position:absolute;

width:220px;
height:220px;

border-radius:50%;

background:
conic-gradient(
from 0deg,
rgba(245,166,35,0.9),
rgba(124,58,237,0.9),
rgba(255,215,0,0.9),
rgba(245,166,35,0.9));

animation:
slowRotate 8s linear infinite,
glowPulse 2s ease-in-out infinite;

box-shadow:
0 0 40px rgba(124,58,237,0.35),
0 0 80px rgba(245,166,35,0.18);

}

/* INNER DARK CIRCLE */

.heartbeat-ring::before{

content:"";

position:absolute;

inset:12px;

border-radius:50%;

background:#070712;

}

/* =========================================================
LOGO
========================================================= */

.heartbeat-logo{

position:relative;

width:140px;
height:140px;

border-radius:50%;

background:
linear-gradient(
145deg,
rgba(255,255,255,0.05),
rgba(255,255,255,0.02));

display:flex;

align-items:center;
justify-content:center;

z-index:3;

backdrop-filter:blur(10px);

border:1px solid rgba(255,255,255,0.08);

animation:heartbeat 1.4s ease-in-out infinite;

box-shadow:
0 0 30px rgba(245,166,35,0.18),
inset 0 0 20px rgba(255,255,255,0.03);

}

/* LOGO IMAGE */

.heartbeat-logo img{

width:90px;

object-fit:contain;

filter:
drop-shadow(0 0 15px rgba(245,166,35,0.25));

}

/* =========================================================
HEARTBEAT ANIMATION
========================================================= */

@keyframes heartbeat{

0%{
    transform:scale(1);
}

14%{
    transform:scale(1.08);
}

28%{
    transform:scale(1);
}

42%{
    transform:scale(1.12);
}

70%{
    transform:scale(1);
}

}

/* =========================================================
ROTATION
========================================================= */

@keyframes slowRotate{

100%{
    transform:rotate(360deg);
}

}

/* =========================================================
GLOW
========================================================= */

@keyframes glowPulse{

50%{

    box-shadow:
    0 0 60px rgba(124,58,237,0.45),
    0 0 120px rgba(245,166,35,0.25);

}

}

/* =========================================================
   WAITING TEXT
========================================================= */

.waiting-title{

    font-size:45px;

    font-weight:900;

    line-height:1.1;

    letter-spacing:-2px;

    margin-bottom:18px;

    z-index:2;

    background:
    linear-gradient(
    90deg,
    white,
    #FFD700);

    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;

}

.waiting-subtitle{

    max-width:650px;

    color:var(--muted);

    line-height:2;

    font-size:15px;

    z-index:2;

}

/* =========================================================
   MESSAGE BOX
========================================================= */

.message-box{

    margin-top:35px;

    padding:18px 26px;

    border-radius:20px;

    background:rgba(124,58,237,0.12);

    border:1px solid rgba(124,58,237,0.25);

    color:#D8B4FE;

    animation:pulseBox 2s infinite;

    z-index:2;

    font-weight:600;

}

/* =========================================================
   RIGHT COLUMN
========================================================= */

.right-column{

    display:flex;

    flex-direction:column;

    gap:24px;

}

/* =========================================================
   INFO GRID
========================================================= */

.info-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:16px;

}

/* =========================================================
   INFO CARD
========================================================= */

.info-card{

    background:
    linear-gradient(
    145deg,
    rgba(255,255,255,0.05),
    rgba(255,255,255,0.02));

    border:1px solid rgba(255,255,255,0.08);

    border-radius:24px;

    padding:24px;

    transition:0.35s;

    box-shadow:
    inset 0 0 20px rgba(255,255,255,0.02),
    0 10px 30px rgba(0,0,0,0.25);

}

.info-card:hover{

    transform:translateY(-5px);

    border-color:rgba(245,166,35,0.25);

    box-shadow:
    0 10px 40px rgba(245,166,35,0.12);

}

.info-icon{

    font-size:26px;

    margin-bottom:12px;

}

.info-label{

    font-size:12px;

    color:var(--muted);

    margin-bottom:6px;

}

.info-value{

    font-size:24px;

    font-weight:800;

}



/* =========================================================
   FOOTER BAR
========================================================= */

.footer-bar{

    margin-top:24px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    padding:18px;

    border-radius:18px;

    background:rgba(0,255,136,0.06);

    border:1px solid rgba(0,255,136,0.15);

    color:var(--green);

    font-weight:700;

}

/* =========================================================
   ANIMATIONS
========================================================= */

@keyframes spin{

    100%{
        transform:rotate(360deg);
    }

}

@keyframes pulse{

    50%{
        transform:scale(1.2);
        opacity:1;
    }

}

@keyframes pulseBox{

    50%{
        box-shadow:0 0 30px rgba(124,58,237,0.18);
    }

}

@keyframes float{

    50%{
        transform:translateY(-8px);
    }

}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1200px){

    .content{
        grid-template-columns:1fr;
    }

}

@media(max-width:768px){

    body{
        overflow:auto;
    }

    .header{

        flex-direction:column;

        gap:20px;

        align-items:flex-start;

    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .waiting-title{
        font-size:30px;
    }

    .title h1{
        font-size:25px;
    }

}

</style>
</head>

<body>

<!-- PARTICLES -->

<div class="particle p1">✦</div>
<div class="particle p2">✦</div>
<div class="particle p3">✦</div>

<div class="container">

    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="header">

        <div class="logo-wrap">

            <!-- CHANGE THIS IMAGE -->
            <div class="logo">

                <img src="../assets/img/logo.png" alt="Going For Gold">

            </div>

            <div class="title">

                

                <p>Compétition interactive en temps réel</p>

            </div>

        </div>

        <div class="live-badge">

            <div class="dot"></div>

            SESSION ACTIVE

        </div>

    </div>

    <!-- =====================================================
         CONTENT
    ====================================================== -->

    <div class="content">

        <!-- =================================================
             LEFT PANEL
        ================================================== -->

        <div class="panel waiting-panel">

        <div class="logo-heartbeat">

            <div class="heartbeat-ring"></div>

             <div class="heartbeat-logo">

              <img src="../assets/img/logo.png" alt="Going For Gold">
            </div>

            </div>

            <div class="waiting-title">
                En attente du démarrage...
            </div>

            <div class="waiting-subtitle">

                L'organisateur prépare actuellement la compétition.
                Restez prêt, les questions apparaîtront automatiquement
                dès le lancement du round.

            </div>

            <div class="message-box">
                ⚡ Préparez-vous... Le round commence bientôt !
            </div>

        </div>

        <!-- =================================================
             RIGHT COLUMN
        ================================================== -->

        <div class="right-column">

            <!-- =============================================
                 SESSION INFO
            ============================================== -->

            <div class="panel">

                <div style="
                font-size:22px;
                font-weight:800;
                margin-bottom:22px;">

                    🎮 Informations session

                </div>

                <div class="info-grid">

                    <div class="info-card">

                        <div class="info-icon">👤</div>

                        <div class="info-label">
                            Participant
                        </div>

                        <div class="info-value">
                            <?php echo $participant; ?>
                        </div>

                    </div>

                    <div class="info-card">

                        <div class="info-icon">🏆</div>

                        <div class="info-label">
                            Round
                        </div>

                        <div class="info-value">
                            <?php echo $round; ?>
                        </div>

                    </div>

                    <div class="info-card">

                        <div class="info-icon">👥</div>

                        <div class="info-label">
                            Participants
                        </div>

                        <div class="info-value">
                            <?php echo $totalParticipants; ?>
                        </div>

                    </div>

                    <div class="info-card">

                        <div class="info-icon">⭐</div>

                        <div class="info-label">
                            Position
                        </div>

                        <div class="info-value">
                            #<?php echo $position; ?>
                        </div>

                    </div>

                </div>

            </div>

           

        </div>

    </div>

</div>

</body>
</html>