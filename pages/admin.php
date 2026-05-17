<?php
session_start();

// Si la variable de session n'est pas définie, on dégage l'intrus
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Going For Gold — Control Center</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style-admin.css">
<link rel="icon" type="image/png" href="../assets/img/favicon.png">

</head>

<body>

<!-- =======================================================
SIDEBAR
======================================================= -->

<aside class="sidebar">

<div class="logo-area">

<img src="../assets/img/logo.png" style="width:120px;
                    height:auto;
                    object-fit:contain;
                    display:block;
                    margin:0 auto 12px auto;
                    filter:drop-shadow(0 0 15px rgba(245,166,35,0.4));
                    animation:trophyFloat 3s ease-in-out infinite;">

<div class="logo-sub">
CONTROL CENTER • HEM ENGINEERING
</div>

</div>

<div class="sidebar-menu">

<div class="menu-item active" onclick="showSection('overview', this)">
    <div class="menu-icon">📊</div>
    Vue d'ensemble
</div>

<div class="menu-item" onclick="showSection('session', this)">
    <div class="menu-icon">🔑</div>
    Code Session
</div>

<div class="menu-item" onclick="showSection('participants', this)">
    <div class="menu-icon">👥</div>
    Participants & Tirage
</div>

<div class="menu-item" onclick="showSection('questions', this)">
    <div class="menu-icon">📋</div>
    Questions
</div>

<div class="menu-item" onclick="showSection('rounds', this)">
    <div class="menu-icon">🎮</div>
    Rounds
</div>

<div class="menu-item" onclick="showSection('finale', this)">
    <div class="menu-icon">🏆</div>
    Finale
</div>

<div class="menu-item" onclick="showSection('stats', this)">
    <div class="menu-icon">📈</div>
    Statistiques
</div>

<div class="menu-item" onclick="window.location.href='logout.php'" >
    <div class="menu-icon">➜]</div>
    Déconnexion
</div>
   
</div>

</div>

<div class="sidebar-bottom">

<div class="server-box">

<div class="live">
<div class="dot"></div>
SERVEUR CONNECTÉ
</div>

<div style="margin-top:10px;font-size:11px;color:var(--muted);">
Raspberry Pi 4 • 12ms • WiFi Active
</div>

</div>

</div>

</aside>

<!-- =======================================================
MAIN
======================================================= -->

<div class="main">

<!-- =======================================================
TOPBAR
======================================================= -->

<div class="topbar">

<div class="top-left">

<h1>Interface Organisateur</h1>

<p>
Gestion complète de la compétition Going For Gold
</p>

</div>

<div class="top-right">

<div class="live">
<div class="dot"></div>
SESSION ACTIVE
</div>

<button class="theme-btn" onclick="toggleTheme()" id="themeBtn">
🌙
</button>

</div>

</div>

<!-- =======================================================
CONTENT
======================================================= -->

<div class="content">



<div class="section active" id="section-overview">
<!-- HERO -->

<div class="hero-admin">

<div class="hero-left">

<div class="hero-title">
Bienvenue dans le <span>Control Center</span>
</div>

<div class="hero-desc">
Importez les participants, organisez les groupes,
contrôlez les rounds en temps réel,
sélectionnez les finalistes et pilotez
l’intégralité de la compétition depuis une seule interface.
</div>

<div class="hero-actions">

<button class="btn-gold" onclick="showSection('rounds', document.querySelector('[onclick*=rounds]'))">
    🚀 Démarrer la compétition
</button>


<button class="btn-outline" onclick="showSection('stats', document.querySelector('[onclick*=stats]'))">
    📋 Voir les statistiques
</button>

</div>

</div>

<div class="hero-right">
    <img class="trophy-img" src="../assets/img/trophy.png" alt="Trophy">
</div>

</div>

<!-- KPI -->

<div class="kpi-grid">

    <div class="kpi" style="--accent:#4F46E5;">
        <div class="kpi-icon-wrap" style="background:rgba(79,70,229,0.2);">
            <img src="../assets/img/icon-participants.png" style="width:28px;height:28px;">
        </div>
        <img src="../assets/img/bg-participants.png" class="kpi-bg-img">
        <div class="kpi-value">75</div>
        <div class="kpi-label">PARTICIPANTS</div>
        <div class="kpi-badge">✅ Importés avec succès</div>
        <div class="kpi-bar" style="background:#4F46E5;"></div>
    </div>

    <div class="kpi" style="--accent:#16A34A;">
        <div class="kpi-icon-wrap" style="background:rgba(22,163,74,0.2);">
            <img src="../assets/img/icon-questions.png" style="width:28px;height:28px;">
        </div>
        <img src="../assets/img/bg-questions.png" class="kpi-bg-img">
        <div class="kpi-value">35</div>
        <div class="kpi-label">QUESTIONS</div>
        <div class="kpi-badge">✅ Prêtes pour la compétition</div>
        <div class="kpi-bar" style="background:#16A34A;"></div>
    </div>

    <div class="kpi" style="--accent:#7C3AED;">
        <div class="kpi-icon-wrap" style="background:rgba(124,58,237,0.2);">
            <img src="../assets/img/icon-rounds.png" style="width:28px;height:28px;">
        </div>
        <img src="../assets/img/bg-trophy.png" class="kpi-bg-img">
        <div class="kpi-value">3</div>
        <div class="kpi-label">ROUNDS</div>
        <div class="kpi-badge">✅ Groupes équilibrés</div>
        <div class="kpi-bar" style="background:#7C3AED;"></div>
    </div>

    <div class="kpi" style="--accent:#D97706;">
        <div class="kpi-icon-wrap" style="background:rgba(217,119,6,0.2);">
            <img src="../assets/img/icon-timer.png" style="width:28px;height:28px;">
        </div>
        <img src="../assets/img/bg-timer.png" class="kpi-bg-img">
        <div class="kpi-value">10s</div>
        <div class="kpi-label">TEMPS RÉPONSE</div>
        <div class="kpi-badge">✅ Par question</div>
        <div class="kpi-bar" style="background:#D97706;"></div>
    </div>

</div>

<!-- WORKFLOW -->

<div class="workflow">

    <div style="margin-bottom:24px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
            <span style="font-size:22px;">🎯</span>
            <span style="font-size:18px;font-weight:800;">Workflow Organisateur</span>
        </div>
        <div style="font-size:13px;color:var(--muted);margin-left:32px;">
            Suivez ces étapes pour piloter votre compétition
        </div>
    </div>

    <div class="timeline">

        <div class="step-wrap">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-title">Importer Participants</div>
                <div class="step-desc">Import Excel (.xlsx)</div>
            </div>
            <div class="step-connector">••••</div>
        </div>

        <div class="step-wrap">
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-title">Tirage au Sort</div>
                <div class="step-desc">3 groupes équilibrés</div>
            </div>
            <div class="step-connector">••••</div>
        </div>

        <div class="step-wrap">
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-title">Importer Questions</div>
                <div class="step-desc">Questions + réponses</div>
            </div>
            <div class="step-connector">••••</div>
        </div>

        <div class="step-wrap">
            <div class="step">
                <div class="step-number">▶</div>
                <div class="step-title">Lancer Rounds</div>
                <div class="step-desc">Gestion live des manches</div>
            </div>
            <div class="step-connector">••••</div>
        </div>

        <div class="step-wrap">
            <div class="step">
                <div class="step-number">📊</div>
                <div class="step-title">Voir les Stats</div>
                <div class="step-desc">Scores & réponses live</div>
            </div>
            <div class="step-connector">••••</div>
        </div>

        <div class="step-wrap">
            <div class="step" >
                <div class="step-number">🏆</div>
                <div class="step-title">Finale</div>
                <div class="step-desc">Sélection des champions</div>
            </div>
            <!-- pas de connector après le dernier -->
        </div>

    </div>
</div>

<!-- CONTROL CENTER -->

</div>


<div class="section" id="section-session" style="display:none;">

    <!-- HERO CODE SESSION -->
    <div style="position:relative;background:linear-gradient(135deg,rgba(245,166,35,0.12),rgba(124,58,237,0.15));
                border:1px solid rgba(245,166,35,0.25);border-radius:30px;
                padding:40px 48px;margin-bottom:24px;overflow:hidden;">

        <!-- Cercles décoratifs fond -->
        <div style="position:absolute;width:320px;height:320px;border-radius:50%;
                    background:radial-gradient(circle,rgba(245,166,35,0.15),transparent 70%);
                    top:-120px;right:-80px;pointer-events:none;"></div>
        <div style="position:absolute;width:200px;height:200px;border-radius:50%;
                    background:radial-gradient(circle,rgba(124,58,237,0.12),transparent 70%);
                    bottom:-80px;left:-60px;pointer-events:none;"></div>

        <!-- Points brillants -->
        <div style="position:absolute;top:-4px;left:60px;width:8px;height:8px;border-radius:50%;
                    background:var(--gold);box-shadow:0 0 12px var(--gold),0 0 24px var(--gold2);
                    animation:borderGlow 2s ease-in-out infinite;"></div>
        <div style="position:absolute;bottom:-4px;right:120px;width:6px;height:6px;border-radius:50%;
                    background:var(--gold2);box-shadow:0 0 8px var(--gold2);
                    animation:borderGlow 3s ease-in-out infinite 1s;"></div>

        <div style="display:flex;align-items:center;justify-content:space-between;position:relative;z-index:1;">

            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                    <div style="width:44px;height:44px;border-radius:50%;
                                background:rgba(245,166,35,0.2);border:1px solid rgba(245,166,35,0.3);
                                display:flex;align-items:center;justify-content:center;font-size:20px;">
                        🔑
                    </div>
                    <div>
                        <div style="font-size:11px;letter-spacing:3px;color:var(--gold);font-weight:700;margin-bottom:2px;">
                            ACCÈS COMPÉTITION
                        </div>
                        <div style="font-size:26px;font-weight:900;">
                            Code de Session
                        </div>
                    </div>
                </div>
                <p style="font-size:13px;color:var(--muted);max-width:480px;line-height:1.8;">
                    Générez un code unique et affichez-le sur l'écran principal.
                    Les participants le saisissent sur leur téléphone pour rejoindre la compétition en temps réel.
                </p>
            </div>

            <!-- Badge statut -->
            <div id="hero-statut-badge"
                 style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);
                        border-radius:20px;padding:20px 28px;text-align:center;min-width:160px;">
                <div style="font-size:11px;letter-spacing:2px;color:var(--muted);margin-bottom:8px;font-weight:700;">
                    STATUT
                </div>
                <div id="hero-statut-text"
                     style="font-size:14px;font-weight:800;color:var(--muted);
                            display:flex;align-items:center;gap:8px;justify-content:center;">
                    <span>⏳</span> En attente
                </div>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1.1fr 0.9fr;gap:22px;">

        <!-- PANNEAU CODE -->
        <div style="display:flex;flex-direction:column;gap:18px;">

            <!-- Card code principal -->
            <div class="panel" style="
                                       border:1px solid rgba(245,166,35,0.3);
                                       position:relative;overflow:hidden;text-align:center;padding:40px 32px;">

                <!-- Lignes décoratives -->
                <div style="position:absolute;top:0;left:0;right:0;height:2px;
                            background:linear-gradient(90deg,transparent,var(--gold),var(--gold2),transparent);
                            animation:borderGlow 2.5s ease-in-out infinite;"></div>
                <div style="position:absolute;bottom:0;left:0;right:0;height:1px;
                            background:linear-gradient(90deg,transparent,rgba(245,166,35,0.3),transparent);"></div>

                <!-- Étoiles -->
                <div style="position:absolute;top:20px;left:24px;color:var(--gold);font-size:16px;
                            opacity:0.5;animation:pulse 3s infinite;">✦</div>
                <div style="position:absolute;top:40px;right:30px;color:var(--gold2);font-size:10px;
                            opacity:0.4;animation:pulse 2s infinite 1s;">✦</div>
                <div style="position:absolute;bottom:30px;left:40px;color:var(--gold);font-size:12px;
                            opacity:0.3;animation:pulse 4s infinite 0.5s;">✦</div>

                <div style="font-size:11px;letter-spacing:3px;color:var(--muted);
                            font-weight:700;margin-bottom:20px;">
                    CODE D'ACCÈS
                </div>

                <!-- Code affiché -->
                <div id="session-code-display"
                     style="font-size:80px;font-weight:900;letter-spacing:18px;
                            background:linear-gradient(135deg,var(--gold2),var(--gold),var(--gold2));
                            background-size:200%;
                            -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                            
                            min-height:96px;display:flex;align-items:center;justify-content:center;
                            font-family:'Poppins',sans-serif;margin-bottom:8px;">
                    ──────
                </div>

                <!-- Séparateur décoratif -->
                <div style="display:flex;align-items:center;gap:12px;margin:16px 0 24px;">
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(245,166,35,0.3));"></div>
                    <div style="width:6px;height:6px;border-radius:50%;background:var(--gold);
                                box-shadow:0 0 8px var(--gold);animation:pulse 1.4s infinite;"></div>
                    <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(245,166,35,0.3),transparent);"></div>
                </div>

                <p style="font-size:12px;color:var(--muted);margin-bottom:28px;line-height:1.7;">
                    Projetez ce code sur l'écran principal<br>
                    
                </p>

                <!-- Boutons -->
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <button onclick="genererCode()"
                        style="width:100%;background:linear-gradient(135deg,var(--gold2),var(--gold));
                               color:#000;font-weight:900;border:none;border-radius:14px;
                               padding:18px;font-size:15px;cursor:pointer;
                               font-family:'Poppins',sans-serif;letter-spacing:0.5px;transition:.3s;
                               display:flex;align-items:center;justify-content:center;gap:10px;
                               box-shadow:0 4px 20px rgba(245,166,35,0.3);"
                        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 30px rgba(245,166,35,0.5)'"
                        onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(245,166,35,0.3)'">
                        🎲 &nbsp;Générer un nouveau code
                    </button>

                    <button id="btn-demarrer-session" onclick="demarrerSession()"
                        style="display:none;width:100%;
                               background:linear-gradient(135deg,#00FF88,#00cc66);
                               color:#000;font-weight:900;border:none;border-radius:14px;
                               padding:18px;font-size:15px;cursor:pointer;
                               font-family:'Poppins',sans-serif;letter-spacing:0.5px;transition:.3s;
                               display:none;align-items:center;justify-content:center;gap:10px;
                               box-shadow:0 4px 20px rgba(0,255,136,0.25);"
                        onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 30px rgba(0,255,136,0.4)'"
                        onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(0,255,136,0.25)'">
                        ➤ &nbsp;Démarrer la session
                    </button>
                </div>

                <div id="session-msg" style="margin-top:14px;font-size:12px;min-height:20px;"></div>
            </div>

            <!-- Compteur participants -->
            <div id="session-nb-wrap" style="display:none;">
                <div class="panel" style="

                                           border:1px solid rgba(0,255,136,0.25);
                                           display:flex;align-items:center;gap:20px;padding:24px 28px;
                                           position:relative;overflow:hidden;">
                    <div style="position:absolute;top:0;left:0;right:0;height:2px;
                                background:linear-gradient(90deg,transparent,rgba(0,255,136,0.5),transparent);
                                animation:borderGlow 2s infinite;"></div>

                    <div style="width:64px;height:64px;border-radius:50%;flex-shrink:0;
                                background:rgba(0,255,136,0.12);
                                border:2px solid rgba(0,255,136,0.3);
                                display:flex;align-items:center;justify-content:center;">
                        <div class="dot" style="width:14px;height:14px;"></div>
                    </div>

                    <div>
                        <div style="font-size:48px;font-weight:900;color:var(--green);
                                    text-shadow:0 0 20px rgba(0,255,136,0.4);line-height:1;"
                             id="session-nb-participants">0</div>
                        <div style="font-size:12px;color:var(--muted);margin-top:4px;font-weight:600;">
                            participant(s) connecté(s) et en attente
                        </div>
                    </div>

                    <div style="margin-left:auto;text-align:right;">
                        <div style="font-size:11px;color:var(--muted);margin-bottom:6px;">Mise à jour</div>
                        <div style="font-size:11px;color:var(--green);font-weight:700;">
                            <span class="dot" style="width:6px;height:6px;display:inline-block;margin-right:4px;"></span>
                            toutes les 2s
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- PANNEAU PARTICIPANTS LIVE -->
        <div class="panel" style="  
                                   position:relative;overflow:hidden;display:flex;flex-direction:column;">

            <!-- Ligne déco top -->
            <div style="position:absolute;top:0;left:0;right:0;height:2px;
                        background:linear-gradient(90deg,transparent,rgba(124,58,237,0.6),transparent);
                        animation:borderGlow 3s infinite;"></div>

            <!-- Point brillant -->
            <div style="position:absolute;top:-4px;right:40px;width:6px;height:6px;border-radius:50%;
                        background:#A78BFA;box-shadow:0 0 10px #A78BFA;
                        animation:borderGlow 2.5s infinite;"></div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(124,58,237,0.25);border:1px solid rgba(124,58,237,0.3);
                                display:flex;align-items:center;justify-content:center;font-size:16px;">
                        📡
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:800;">Participants connectés</div>
                        <div style="font-size:11px;color:var(--muted);">Flux en temps réel</div>
                    </div>
                </div>
                <div class="live" id="session-live-badge" style="display:none;
                     background:rgba(0,255,136,0.08);border:1px solid rgba(0,255,136,0.2);
                     border-radius:50px;padding:6px 14px;">
                    <div class="dot"></div>
                    LIVE
                </div>
            </div>

            <!-- Liste scrollable -->
            <div id="session-participants-list"
                 style="flex:1;display:flex;flex-direction:column;gap:8px;
                        max-height:440px;overflow-y:auto;
                        scrollbar-width:thin;scrollbar-color:rgba(245,166,35,0.3) transparent;">
                <div style="text-align:center;padding:60px 20px;color:var(--muted);">
                    <div style="font-size:52px;margin-bottom:14px;opacity:0.4;">👥</div>
                    <div style="font-size:14px;font-weight:700;margin-bottom:6px;color:var(--text);">
                        En attente des participants
                    </div>
                    <div style="font-size:12px;line-height:1.7;">
                        Générez un code et partagez-le.<br>
                        Les participants apparaîtront ici automatiquement.
                    </div>
                </div>
            </div>

            <!-- Footer info -->
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border);
                        display:flex;align-items:center;gap:8px;font-size:12px;color:var(--muted);">
                <span style="width:20px;height:20px;border-radius:50%;
                             background:rgba(124,58,237,0.3);color:#A78BFA;
                             display:inline-flex;align-items:center;justify-content:center;
                             font-size:11px;flex-shrink:0;">ℹ</span>
                La liste se rafraîchit automatiquement toutes les 2 secondes.
            </div>
        </div>

    </div>

</div>


<!-- SECTION PARTICIPANTS -->
<div class="section" id="section-participants" style="display:none;">

<div class="panel" style="position:relative;overflow:visible;margin-bottom:24px;">
        
        <!-- Trophée décoratif -->
        <img src="../assets/img/trophy-3d.png" 
     style="position:absolute;right:60px;top:30px;width:250px;
            opacity:0.9;pointer-events:none;z-index:0;
            animation:trophyFloat 3s ease-in-out infinite;">

        <div style="position:relative;z-index:1;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span style="font-size:20px;">⏳</span>
                <span style="font-size:20px;font-weight:800;">Liste d'attente</span>
            </div>
            <p style="font-size:13px;color:var(--muted);margin-bottom:24px;">
                Les participants qui ont rejoint depuis la page d'accueil apparaissent ici.
            </p>

            <!-- Badges stats -->
            <div style="display:flex;gap:12px;margin-bottom:24px;">
                <div style="background:linear-gradient(135deg,var(--gold2),var(--gold));
                            color:#000;border-radius:50px;padding:10px 20px;
                            font-size:13px;font-weight:800;display:flex;align-items:center;gap:8px;">
                    👥 <span id="count-attente">0</span> En attente
                </div>
                <div style="background:rgba(124,58,237,0.15);
                            border:1px solid rgba(124,58,237,0.3);
                            color:#A78BFA;border-radius:50px;padding:10px 20px;
                            font-size:13px;font-weight:700;display:flex;align-items:center;gap:8px;">
                    👥 <span id="count-groupes">0</span> Groupés
                </div>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;margin-bottom:24px;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border);">
                            <th style="padding:12px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1px;color:var(--gold);
                                       font-weight:700;">#</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1px;color:var(--gold);
                                       font-weight:700;">Nom</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1px;color:var(--gold);
                                       font-weight:700;">Heure de connexion</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1px;color:var(--gold);
                                       font-weight:700;">Groupe</th>
                            <th style="padding:12px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1px;color:var(--gold);
                                       font-weight:700;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-attente">
                        <tr>
                            <td colspan="5" style="text-align:center;color:var(--muted);padding:40px;">
                                ⏳ En attente de participants...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Boutons -->
            <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <button class="btn-gold" onclick="lancerTirage()" id="btn-tirage"
              style="display:flex;align-items:center;gap:8px;opacity:0.5;cursor:not-allowed;"
              disabled>
                🎲 Lancer le tirage au sort
            </button>
                <button class="btn-outline" onclick="chargerParticipants()"
                        style="display:flex;align-items:center;gap:8px;">
                    🔄 Actualiser la liste
                </button>
                <div style="margin-left:auto;background:rgba(255,255,255,0.04);
                            border:1px solid var(--border);border-radius:12px;
                            padding:10px 16px;font-size:12px;color:var(--muted);
                            display:flex;align-items:center;gap:8px;">
                    ℹ️ Le tirage répartit automatiquement en 3 groupes de 25
                </div>
            </div>
        </div>
    </div>

    <!-- Résultat tirage -->
    <div id="groupes-panel" style="display:none;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
            <span style="font-size:20px;">🏆</span>
            <span style="font-size:20px;font-weight:800;">Résultat du tirage</span>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">

            <div style="background:rgba(245,166,35,0.06);border:1px solid rgba(245,166,35,0.25);
                        border-radius:20px;padding:22px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h5 style="color:var(--gold);font-weight:800;font-size:15px;">First Round 1</h5>
                    <span id="count-g1" style="background:rgba(245,166,35,0.15);color:var(--gold);
                                font-size:11px;font-weight:700;padding:4px 12px;border-radius:50px;">
                        0 participant
                    </span>
                </div>
                <div id="groupe-1-list"></div>
            </div>

            <div style="background:rgba(124,58,237,0.06);border:1px solid rgba(124,58,237,0.25);
                        border-radius:20px;padding:22px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h5 style="color:#A78BFA;font-weight:800;font-size:15px;">First Round 2</h5>
                    <span id="count-g2" style="background:rgba(124,58,237,0.15);color:#A78BFA;
                                font-size:11px;font-weight:700;padding:4px 12px;border-radius:50px;">
                        0 participant
                    </span>
                </div>
                <div id="groupe-2-list"></div>
            </div>

            <div style="background:rgba(56,189,248,0.06);border:1px solid rgba(56,189,248,0.25);
                        border-radius:20px;padding:22px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h5 style="color:#38BDF8;font-weight:800;font-size:15px;">First Round 3</h5>
                    <span id="count-g3" style="background:rgba(56,189,248,0.15);color:#38BDF8;
                                font-size:11px;font-weight:700;padding:4px 12px;border-radius:50px;">
                        0 participant
                    </span>
                </div>
                <div id="groupe-3-list"></div>
            </div>

        </div>
    </div>

</div>

<!-- SECTION QUESTIONS -->
<!-- SECTION QUESTIONS -->
<div class="section" id="section-questions" style="display:none;">

    <!-- Import + Ajout -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:22px;margin-bottom:24px;">

        <!-- Import Excel -->
        <div class="panel" style="position:relative;overflow:visible;background:linear-gradient(135deg,rgba(124,58,237,0.15),rgba(245,166,35,0.05));border:1px solid rgba(124,58,237,0.3);">
            
            <!-- Trophée décoratif -->
            <img src="../assets/img/trophy-3d.png" 
     style="position:absolute;right:30px;top:0px;width:150px;
            opacity:0.9;pointer-events:none;z-index:0;
            animation:trophyFloat 3s ease-in-out infinite;">


            <!-- Étoiles décoratives -->
            <div style="position:absolute;top:12px;right:160px;color:var(--gold);
                        font-size:14px;animation:pulse 2s infinite;">✦</div>
            <div style="position:absolute;top:30px;right:120px;color:var(--gold);
                        font-size:10px;animation:pulse 2.5s infinite;">✦</div>

            <div style="position:relative;z-index:1;">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                    <span style="font-size:22px;">📥</span>
                    <span style="font-size:18px;font-weight:800;">Importer depuis Excel</span>
                </div>

                <p style="font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.7;">
                    Format attendu : Question | Choix1 | Choix2 | Choix3 | Choix4 | Bonne réponse (1-4)
                </p>

                <!-- Zone fichier stylisée -->
                <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.12);
                            border-radius:14px;padding:14px 16px;margin-bottom:16px;
                            display:flex;align-items:center;gap:12px;">
                    <label for="excel-questions"
                        style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);
                               color:var(--text);border-radius:8px;padding:8px 16px;
                               font-size:12px;font-weight:600;cursor:pointer;
                               font-family:'Poppins',sans-serif;white-space:nowrap;">
                        Choisir un fichier
                    </label>
                    <span id="file-name-display" style="font-size:12px;color:var(--muted);">
                        Aucun fichier choisi
                    </span>
                    <input type="file" id="excel-questions" accept=".xlsx,.xls"
                        style="display:none;"
                        onchange="document.getElementById('file-name-display').textContent = this.files[0]?.name || 'Aucun fichier choisi'">
                </div>

                <!-- Bouton import large -->
                <button onclick="importerQuestions()"
                    style="width:100%;background:linear-gradient(135deg,var(--gold2),var(--gold));
                           color:#000;font-weight:800;border:none;border-radius:14px;
                           padding:16px;font-size:14px;cursor:pointer;
                           font-family:'Poppins',sans-serif;letter-spacing:0.5px;
                           transition:.3s;display:flex;align-items:center;justify-content:center;gap:10px;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 25px rgba(245,166,35,0.4)'"
                    onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                    ⬆ &nbsp;Importer les questions
                </button>

                <div id="import-msg" style="margin-top:10px;font-size:12px;"></div>

                <!-- Note info -->
                <div style="margin-top:16px;display:flex;align-items:center;gap:8px;
                            font-size:12px;color:var(--muted);">
                    <span style="width:20px;height:20px;border-radius:50%;
                                 background:rgba(124,58,237,0.3);color:#A78BFA;
                                 display:inline-flex;align-items:center;justify-content:center;
                                 font-size:11px;flex-shrink:0;">ℹ</span>
                    Assurez-vous que votre fichier respecte le format requis.
                </div>
            </div>
        </div>

        <!-- Ajouter manuellement -->
        <div class="panel" style="
                                   border:1px solid rgba(124,58,237,0.25);position:relative;overflow:hidden;">
            
            <!-- Étoile décorative -->
            <div style="position:absolute;top:16px;right:20px;color:var(--gold);
                        font-size:18px;opacity:0.6;animation:pulse 3s infinite;">✦</div>

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                <span style="font-size:22px;">➕</span>
                <span style="font-size:18px;font-weight:800;">Ajouter une question</span>
            </div>

            <div style="display:flex;flex-direction:column;gap:12px;">
                <input type="text" id="q-texte" placeholder="Question"
                    style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);
                           border-radius:12px;padding:14px 16px;color:var(--text);
                           font-family:'Poppins',sans-serif;width:100%;font-size:13px;
                           outline:none;transition:.3s;"
                    onfocus="this.style.borderColor='rgba(245,166,35,0.5)'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.12)'">

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <input type="text" id="q-c1" placeholder="Choix 1"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);
                               border-radius:12px;padding:13px 16px;color:var(--text);
                               font-family:'Poppins',sans-serif;font-size:13px;outline:none;transition:.3s;"
                        onfocus="this.style.borderColor='rgba(245,166,35,0.5)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    <input type="text" id="q-c2" placeholder="Choix 2"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);
                               border-radius:12px;padding:13px 16px;color:var(--text);
                               font-family:'Poppins',sans-serif;font-size:13px;outline:none;transition:.3s;"
                        onfocus="this.style.borderColor='rgba(245,166,35,0.5)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    <input type="text" id="q-c3" placeholder="Choix 3"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);
                               border-radius:12px;padding:13px 16px;color:var(--text);
                               font-family:'Poppins',sans-serif;font-size:13px;outline:none;transition:.3s;"
                        onfocus="this.style.borderColor='rgba(245,166,35,0.5)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    <input type="text" id="q-c4" placeholder="Choix 4"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);
                               border-radius:12px;padding:13px 16px;color:var(--text);
                               font-family:'Poppins',sans-serif;font-size:13px;outline:none;transition:.3s;"
                        onfocus="this.style.borderColor='rgba(245,166,35,0.5)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                </div>

                <select id="q-correct"
                    style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);
                           border-radius:12px;padding:13px 16px;color:var(--text);
                           font-family:'Poppins',sans-serif;font-size:13px;outline:none;">
                    <option value="1">✅ Bonne réponse : Choix 1</option>
                    <option value="2">✅ Bonne réponse : Choix 2</option>
                    <option value="3">✅ Bonne réponse : Choix 3</option>
                    <option value="4">✅ Bonne réponse : Choix 4</option>
                </select>

                <button onclick="ajouterQuestion()"
                    style="width:100%;background:linear-gradient(135deg,var(--gold2),var(--gold));
                           color:#000;font-weight:800;border:none;border-radius:14px;
                           padding:16px;font-size:14px;cursor:pointer;
                           font-family:'Poppins',sans-serif;letter-spacing:0.5px;
                           transition:.3s;display:flex;align-items:center;justify-content:center;gap:8px;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 25px rgba(245,166,35,0.4)'"
                    onmouseout="this.style.transform='none';this.style.boxShadow='none'">
                    ➕ &nbsp;Ajouter la question
                </button>
            </div>
        </div>
    </div>

    <!-- Liste questions -->
    <div class="panel" style="
                               border:1px solid rgba(124,58,237,0.25);position:relative;overflow:hidden;">

        <!-- Étoile déco gauche -->
        <div style="position:absolute;left:16px;top:50%;color:var(--gold);
                    font-size:16px;opacity:0.4;animation:pulse 4s infinite;">✦</div>
        <!-- Étoile déco droite -->
        <div style="position:absolute;right:280px;top:20px;color:var(--gold);
                    font-size:12px;opacity:0.4;animation:pulse 3s infinite;">✦</div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <span style="font-size:20px;">📋</span>
                <span style="font-size:18px;font-weight:800;">Liste des questions</span>
                <span id="count-questions"
                    style="background:rgba(255,255,255,0.08);color:var(--muted);
                           padding:4px 12px;border-radius:50px;font-size:13px;font-weight:600;">
                    (0)
                </span>
            </div>
            <button onclick="exporterQuestions()"
                style="background:transparent;border:1px solid var(--gold);
                       color:var(--gold);border-radius:50px;padding:10px 22px;
                       font-size:13px;font-weight:700;cursor:pointer;
                       font-family:'Poppins',sans-serif;transition:.3s;
                       display:flex;align-items:center;gap:8px;"
                onmouseover="this.style.background='var(--gold)';this.style.color='#000'"
                onmouseout="this.style.background='transparent';this.style.color='var(--gold)'">
                📤 Exporter Excel
            </button>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:rgba(124,58,237,0.15);">
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">#</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">Question</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">Choix 1</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">Choix 2</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">Choix 3</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">Choix 4</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">Réponse</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;
                                   text-transform:uppercase;letter-spacing:1.5px;
                                   color:var(--gold);font-weight:700;">Action</th>
                    </tr>
                </thead>
                <tbody id="table-questions">
                    <tr>
                        <td colspan="8" style="text-align:center;padding:60px 20px;">
                            <div style="font-size:48px;margin-bottom:12px;">📁</div>
                            <div style="font-weight:700;font-size:15px;margin-bottom:6px;">
                                Aucune question importée
                            </div>
                            <div style="font-size:13px;color:var(--muted);">
                                Importez un fichier Excel ou ajoutez vos questions manuellement.
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- SECTION ROUNDS -->
<div class="section" id="section-rounds" style="display:none;">

    <!-- Sélecteur de round -->
    <div style="display:flex;gap:12px;margin-bottom:24px;">
        <button onclick="selectionnerRound(1)" id="btn-r1"
            style="background:linear-gradient(135deg,var(--gold2),var(--gold));
                   color:#000;font-weight:800;border:none;border-radius:50px;
                   padding:12px 28px;font-size:14px;cursor:pointer;
                   font-family:'Poppins',sans-serif;transition:.3s;
                   box-shadow:0 0 20px rgba(245,166,35,0.4);">
            Round 1
        </button>
        <button onclick="selectionnerRound(2)" id="btn-r2"
            style="background:transparent;border:2px solid var(--gold);
                   color:var(--gold);font-weight:800;border-radius:50px;
                   padding:12px 28px;font-size:14px;cursor:pointer;
                   font-family:'Poppins',sans-serif;transition:.3s;">
            Round 2
        </button>
        <button onclick="selectionnerRound(3)" id="btn-r3"
            style="background:transparent;border:2px solid var(--gold);
                   color:var(--gold);font-weight:800;border-radius:50px;
                   padding:12px 28px;font-size:14px;cursor:pointer;
                   font-family:'Poppins',sans-serif;transition:.3s;">
            Round 3
        </button>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;">

        <!-- PANNEAU PRINCIPAL -->
        <div style="display:flex;flex-direction:column;gap:22px;">

            <!-- Statut du round -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.4);position:relative;overflow:visible;">
                
                <!-- Point brillant coin -->
                <div style="position:absolute;top:-4px;left:40px;width:8px;height:8px;
                            border-radius:50%;background:var(--gold);
                            box-shadow:0 0 12px var(--gold),0 0 24px var(--gold2);
                            animation:borderGlow 2s ease-in-out infinite;z-index:10;"></div>

                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;">
                    <div>
                        <div style="font-size:24px;font-weight:900;margin-bottom:12px;" id="round-titre">
                            First Round 1
                        </div>
                        <div style="display:flex;align-items:center;gap:20px;font-size:13px;color:var(--muted);">
                            <span>👥 25 participants</span>
                            <span style="color:rgba(255,255,255,0.2);">|</span>
                            <span>❓ 10 questions</span>
                        </div>
                    </div>
                    <span id="round-badge"
                        style="background:rgba(245,166,35,0.15);color:var(--gold);
                               border:1px solid rgba(245,166,35,0.3);
                               padding:8px 20px;border-radius:50px;font-size:12px;font-weight:700;
                               display:flex;align-items:center;gap:8px;">
                        ⏳ En attente
                    </span>
                </div>

                <!-- Barre de progression -->
                <div style="margin-bottom:24px;">
                    <div style="display:flex;justify-content:space-between;font-size:13px;
                                color:var(--muted);margin-bottom:10px;">
                        <span>Progression</span>
                        <span id="q-progression">0 / 10</span>
                    </div>
                    <div style="background:rgba(255,255,255,0.08);border-radius:50px;height:8px;position:relative;">
                        <div id="progress-bar"
                            style="height:100%;background:linear-gradient(90deg,var(--gold2),var(--gold));
                                   border-radius:50px;width:0%;transition:width 0.5s;
                                   box-shadow:0 0 10px rgba(245,166,35,0.5);"></div>
                        <!-- Point sur la barre -->
                        <div style="position:absolute;left:2px;top:50%;transform:translateY(-50%);
                                    width:12px;height:12px;border-radius:50%;
                                    background:var(--gold);
                                    box-shadow:0 0 8px var(--gold);"></div>
                    </div>
                </div>

                <!-- Bouton démarrer -->
                <button id="btn-demarrer" onclick="demarrerRound()"
                    style="background:linear-gradient(135deg,var(--gold2),var(--gold));
                           color:#000;font-weight:900;border:none;border-radius:14px;
                           padding:18px 40px;font-size:15px;cursor:pointer;
                           font-family:'Poppins',sans-serif;transition:.3s;
                           display:flex;align-items:center;gap:10px;
                           box-shadow:0 4px 20px rgba(245,166,35,0.35);"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 30px rgba(245,166,35,0.5)'"
                    onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(245,166,35,0.35)'">
                    ➤ &nbsp;Démarrer le Round
                </button>
            </div>

            <!-- Question en cours -->
            <div class="panel" id="panel-question" style="display:none;
                border:1px solid rgba(124,58,237,0.35);">

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <div style="font-size:12px;color:var(--gold);font-weight:700;letter-spacing:2px;">
                        QUESTION ACTUELLE
                    </div>
                    <span id="q-num-badge"
                        style="background:rgba(245,166,35,0.1);color:var(--gold);
                               border:1px solid rgba(245,166,35,0.3);
                               padding:6px 16px;border-radius:50px;font-size:12px;font-weight:700;">
                        Q1 / 10
                    </span>
                </div>

                <div id="q-texte-display"
                    style="font-size:18px;font-weight:700;line-height:1.5;
                           margin-bottom:20px;padding:20px;
                           background:rgba(245,166,35,0.06);
                           border:1px solid rgba(245,166,35,0.2);border-radius:16px;">
                    Chargement...
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px;"
                     id="choix-display"></div>

                <!-- Chrono -->
                <div style="text-align:center;margin-bottom:24px;">
                    <div id="chrono-admin"
                        style="width:90px;height:90px;border-radius:50%;
                               border:4px solid var(--gold);
                               display:inline-flex;flex-direction:column;
                               align-items:center;justify-content:center;
                               font-size:32px;font-weight:900;color:var(--gold);
                               box-shadow:0 0 25px rgba(245,166,35,0.4),inset 0 0 20px rgba(245,166,35,0.05);">
                        <span id="chrono-num">10</span>
                        <span style="font-size:10px;color:var(--muted);font-weight:400;">sec</span>
                    </div>
                </div>

                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <button id="btn-top-chrono"
                        style="background:linear-gradient(135deg,#00FF88,#00cc66);
                               color:#000;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;
                               font-family:'Poppins',sans-serif;"
                        onclick="topChrono()">⏱ TOP CHRONO</button>
                    <button id="btn-stop-chrono"
                        style="background:linear-gradient(135deg,#FF4B4B,#cc0000);
                               color:#fff;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;display:none;
                               font-family:'Poppins',sans-serif;"
                        onclick="stopChrono()">⏹ ARRÊTER</button>
                    <button id="btn-afficher-stats"
                        style="background:linear-gradient(135deg,#7C3AED,#5B21B6);
                               color:#fff;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;display:none;
                               font-family:'Poppins',sans-serif;"
                        onclick="afficherStats()">📊 STATS</button>
                    <button id="btn-suivante"
                        style="background:linear-gradient(135deg,var(--gold2),var(--gold));
                               color:#000;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;display:none;
                               font-family:'Poppins',sans-serif;"
                        onclick="questionSuivante()">➡ SUIVANTE</button>
                </div>
            </div>

        </div>

        <!-- PANNEAU LATÉRAL -->
        <div style="display:flex;flex-direction:column;gap:18px;">

            <!-- Réponses reçues -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.35);text-align:center;
                                       position:relative;overflow:visible;">
                
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(124,58,237,0.3);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        🛰
                    </div>
                    <span style="font-size:16px;font-weight:800;">Réponses reçues</span>
                </div>

                <!-- Nombre avec étoiles -->
                <div style="position:relative;display:inline-block;margin-bottom:8px;">
                    <div style="position:absolute;top:-10px;left:-15px;color:var(--gold);
                                font-size:12px;animation:borderGlow 2s infinite;">✦</div>
                    <div style="position:absolute;bottom:0px;right:-20px;color:var(--gold2);
                                font-size:10px;animation:borderGlow 3s infinite 1s;">✦</div>
                    <span id="nb-reponses"
                        style="font-size:56px;font-weight:900;color:var(--gold);
                               text-shadow:0 0 20px rgba(245,166,35,0.5);">0</span>
                </div>

                <div style="font-size:13px;color:var(--muted);margin-bottom:16px;">
                 / <span id="nb-participants-round">—</span> participants
                </div>

                <div style="background:rgba(255,255,255,0.06);border-radius:50px;height:8px;">
                    <div id="progress-reponses"
                        style="height:100%;background:linear-gradient(90deg,#00FF88,#00cc66);
                               border-radius:50px;width:0%;transition:width 0.5s;
                               box-shadow:0 0 10px rgba(0,255,136,0.4);"></div>
                </div>
            </div>

            <!-- Statistiques question -->
            <div class="panel" id="panel-stats-q" style="display:none;
                
                border:1px solid rgba(124,58,237,0.35);">
                <div style="font-size:15px;font-weight:800;margin-bottom:16px;">📊 Statistiques</div>
                <div id="stats-choix" style="display:flex;flex-direction:column;gap:10px;"></div>
                <div style="margin-top:16px;padding:12px;background:rgba(0,255,136,0.08);
                            border:1px solid rgba(0,255,136,0.2);border-radius:12px;font-size:13px;">
                    ✅ Bonne réponse :
                    <strong id="bonne-rep-display" style="color:#00FF88;">—</strong>
                </div>
            </div>

            <!-- Top 3 -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.35);text-align:center;">

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(245,166,35,0.2);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        🥇
                    </div>
                    <span style="font-size:16px;font-weight:800;">Top 3 actuel</span>
                </div>

                <div id="top3-list">
    <div style="padding:20px;text-align:center;">
        <img src="../assets/img/trophy.png" alt="Trophy"
             style="width:200px;
                    height:auto;
                    object-fit:contain;
                    display:block;
                    margin:17 auto 8px auto;
                    filter:drop-shadow(0 0 15px rgba(245,166,35,0.4));
                    animation:trophyFloat 3s ease-in-out infinite;">
        <div style="font-size:13px;color:var(--muted);">En attente...</div>
    </div>
</div>
            </div>

        </div>

    </div>

</div>



<!-- SECTION FINALE -->
<div class="section" id="section-finale" style="display:none;">

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;">

        <!-- PANNEAU PRINCIPAL -->
        <div style="display:flex;flex-direction:column;gap:22px;">

            <!-- Les 3 Finalistes -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.4);position:relative;overflow:visible;">

                <!-- Points brillants -->
                <div style="position:absolute;top:-4px;left:40px;width:8px;height:8px;
                            border-radius:50%;background:var(--gold);
                            box-shadow:0 0 12px var(--gold),0 0 24px var(--gold2);
                            animation:borderGlow 2s ease-in-out infinite;z-index:10;"></div>
                <div style="position:absolute;bottom:-4px;right:60px;width:6px;height:6px;
                            border-radius:50%;background:var(--gold2);
                            box-shadow:0 0 8px var(--gold2);
                            animation:borderGlow 3s ease-in-out infinite 1s;z-index:10;"></div>

                <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(245,166,35,0.2);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        🏆
                    </div>
                    <span style="font-size:18px;font-weight:900;">Les 3 Finalistes</span>
                </div>

                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">

                    <!-- Finaliste 1 -->
                    <div style="text-align:center;padding:20px;
                                background:rgba(245,166,35,0.06);
                                border:1px solid rgba(245,166,35,0.25);
                                border-radius:20px;position:relative;overflow:hidden;">
                        <div style="position:absolute;top:0;left:0;right:0;height:2px;
                                    background:linear-gradient(90deg,transparent,var(--gold),transparent);
                                    animation:borderGlow 2s infinite;"></div>
                        <div style="font-size:36px;margin-bottom:10px;
                                    animation:trophyFloat 3s ease-in-out infinite;">👑</div>
                        <div style="font-weight:800;font-size:14px;margin-bottom:4px;" id="finaliste-1-nom">—</div>
                        <div style="font-size:11px;color:var(--muted);margin-bottom:10px;">First Round 1</div>
                        <div style="color:var(--gold);font-weight:900;font-size:18px;
                                    text-shadow:0 0 10px rgba(245,166,35,0.4);" id="finaliste-1-pts">0 pts</div>
                    </div>

                    <!-- Finaliste 2 -->
                    <div style="text-align:center;padding:20px;
                                background:rgba(124,58,237,0.08);
                                border:1px solid rgba(124,58,237,0.3);
                                border-radius:20px;position:relative;overflow:hidden;">
                        <div style="position:absolute;top:0;left:0;right:0;height:2px;
                                    background:linear-gradient(90deg,transparent,#A78BFA,transparent);
                                    animation:borderGlow 2.5s infinite;"></div>
                        <div style="font-size:36px;margin-bottom:10px;
                                    animation:trophyFloat 3s ease-in-out infinite 0.5s;">👑</div>
                        <div style="font-weight:800;font-size:14px;margin-bottom:4px;" id="finaliste-2-nom">—</div>
                        <div style="font-size:11px;color:var(--muted);margin-bottom:10px;">First Round 2</div>
                        <div style="color:#A78BFA;font-weight:900;font-size:18px;" id="finaliste-2-pts">0 pts</div>
                    </div>

                    <!-- Finaliste 3 -->
                    <div style="text-align:center;padding:20px;
                                background:rgba(56,189,248,0.06);
                                border:1px solid rgba(56,189,248,0.25);
                                border-radius:20px;position:relative;overflow:hidden;">
                        <div style="position:absolute;top:0;left:0;right:0;height:2px;
                                    background:linear-gradient(90deg,transparent,#38BDF8,transparent);
                                    animation:borderGlow 3s infinite;"></div>
                        <div style="font-size:36px;margin-bottom:10px;
                                    animation:trophyFloat 3s ease-in-out infinite 1s;">👑</div>
                        <div style="font-weight:800;font-size:14px;margin-bottom:4px;" id="finaliste-3-nom">—</div>
                        <div style="font-size:11px;color:var(--muted);margin-bottom:10px;">First Round 3</div>
                        <div style="color:#38BDF8;font-weight:900;font-size:18px;" id="finaliste-3-pts">0 pts</div>
                    </div>

                </div>

                <div style="display:flex;gap:12px;">
                    <button onclick="chargerFinalistes()"
                        style="background:transparent;border:1px solid var(--gold);
                               color:var(--gold);border-radius:50px;padding:12px 24px;
                               font-size:13px;font-weight:700;cursor:pointer;
                               font-family:'Poppins',sans-serif;transition:.3s;
                               display:flex;align-items:center;gap:8px;"
                        onmouseover="this.style.background='var(--gold)';this.style.color='#000'"
                        onmouseout="this.style.background='transparent';this.style.color='var(--gold)'">
                        🔄 Actualiser les finalistes
                    </button>
                    <button id="btn-demarrer-finale" onclick="demarrerFinale()"
                        style="background:linear-gradient(135deg,var(--gold2),var(--gold));
                               color:#000;font-weight:900;border:none;border-radius:50px;
                               padding:12px 28px;font-size:13px;cursor:pointer;
                               font-family:'Poppins',sans-serif;transition:.3s;
                               display:flex;align-items:center;gap:8px;
                               box-shadow:0 4px 20px rgba(245,166,35,0.35);"
                        onmouseover="this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.transform='none'">
                        🏆 Démarrer la Finale
                    </button>
                </div>
            </div>

            <!-- Question en cours finale -->
            <div class="panel" id="panel-question-finale" style="display:none;
                border:1px solid rgba(124,58,237,0.35);position:relative;overflow:visible;">

                <div style="position:absolute;top:-4px;right:40px;width:8px;height:8px;
                            border-radius:50%;background:var(--gold);
                            box-shadow:0 0 12px var(--gold);
                            animation:borderGlow 2s infinite;z-index:10;"></div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <div style="font-size:12px;color:var(--gold);font-weight:700;letter-spacing:2px;">
                        ✨ QUESTION FINALE
                    </div>
                    <span id="q-finale-badge"
                        style="background:rgba(245,166,35,0.1);color:var(--gold);
                               border:1px solid rgba(245,166,35,0.3);
                               padding:6px 16px;border-radius:50px;font-size:12px;font-weight:700;">
                        Q1 / 5
                    </span>
                </div>

                <div id="q-finale-texte"
                    style="font-size:18px;font-weight:700;line-height:1.5;margin-bottom:20px;
                           padding:20px;background:rgba(245,166,35,0.06);
                           border:1px solid rgba(245,166,35,0.2);border-radius:16px;">
                    Chargement...
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px;"
                     id="choix-finale-display"></div>

                <!-- Chrono finale -->
                <div style="text-align:center;margin-bottom:24px;">
                    <div id="chrono-finale"
                        style="width:90px;height:90px;border-radius:50%;
                               border:4px solid var(--gold);
                               display:inline-flex;flex-direction:column;
                               align-items:center;justify-content:center;
                               font-size:32px;font-weight:900;color:var(--gold);
                               box-shadow:0 0 25px rgba(245,166,35,0.4),inset 0 0 20px rgba(245,166,35,0.05);">
                        <span id="chrono-finale-num">10</span>
                        <span style="font-size:10px;color:var(--muted);font-weight:400;">sec</span>
                    </div>
                </div>

                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <button id="btn-top-finale" onclick="topChronoFinale()"
                        style="background:linear-gradient(135deg,#00FF88,#00cc66);
                               color:#000;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;
                               font-family:'Poppins',sans-serif;">
                        ⏱ TOP CHRONO
                    </button>
                    <button id="btn-stop-finale" onclick="stopChronoFinale()"
                        style="background:linear-gradient(135deg,#FF4B4B,#cc0000);
                               color:#fff;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;display:none;
                               font-family:'Poppins',sans-serif;">
                        ⏹ ARRÊTER
                    </button>
                    <button id="btn-stats-finale" onclick="afficherStatsFinale()"
                        style="background:linear-gradient(135deg,#7C3AED,#5B21B6);
                               color:#fff;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;display:none;
                               font-family:'Poppins',sans-serif;">
                        📊 STATS
                    </button>
                    <button id="btn-suivante-finale" onclick="questionSuivanteFinale()"
                        style="background:linear-gradient(135deg,var(--gold2),var(--gold));
                               color:#000;font-weight:800;border:none;border-radius:50px;
                               padding:14px 28px;font-size:13px;cursor:pointer;flex:1;display:none;
                               font-family:'Poppins',sans-serif;">
                        ➡ SUIVANTE
                    </button>
                </div>
            </div>

            <!-- PODIUM FINAL -->
            <div class="panel" id="panel-podium" style="display:none;
                border:1px solid rgba(124,58,237,0.4);position:relative;overflow:visible;">

                <div style="position:absolute;top:-4px;left:50%;width:8px;height:8px;
                            border-radius:50%;background:var(--gold);
                            box-shadow:0 0 12px var(--gold),0 0 24px var(--gold2);
                            animation:borderGlow 2s infinite;z-index:10;"></div>

                <div style="display:flex;align-items:center;gap:12px;margin-bottom:28px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(245,166,35,0.2);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        🏆
                    </div>
                    <span style="font-size:18px;font-weight:900;">Podium Final</span>
                </div>

                <div style="display:flex;justify-content:center;align-items:flex-end;
                            gap:20px;margin-bottom:28px;">

                    <!-- 2ème -->
                    <div style="text-align:center;">
                        <div style="font-size:36px;margin-bottom:8px;">🥈</div>
                        <div style="font-weight:800;font-size:15px;margin-bottom:4px;" id="podium-2-nom">—</div>
                        <div style="color:var(--muted);font-size:12px;margin-bottom:6px;">2ème place</div>
                        <div style="color:#C0C0C0;font-weight:800;font-size:16px;" id="podium-2-pts">0 pts</div>
                        <div style="height:90px;width:90px;margin:12px auto 0;
                                    background:rgba(192,192,192,0.1);
                                    border:1px solid rgba(192,192,192,0.3);
                                    border-radius:12px 12px 0 0;"></div>
                    </div>

                    <!-- 1er -->
                    <div style="text-align:center;">
                        <div style="font-size:52px;margin-bottom:8px;
                                    animation:trophyFloat 3s ease-in-out infinite;
                                    filter:drop-shadow(0 0 15px rgba(245,166,35,0.5));">🥇</div>
                        <div style="font-weight:900;font-size:18px;color:var(--gold);
                                    margin-bottom:4px;text-shadow:0 0 10px rgba(245,166,35,0.4);"
                             id="podium-1-nom">—</div>
                        <div style="color:var(--muted);font-size:12px;margin-bottom:6px;">🏆 Champion</div>
                        <div style="color:var(--gold);font-weight:900;font-size:20px;
                                    text-shadow:0 0 10px rgba(245,166,35,0.4);" id="podium-1-pts">0 pts</div>
                        <div style="height:130px;width:110px;margin:12px auto 0;
                                    background:rgba(245,166,35,0.1);
                                    border:2px solid var(--gold);
                                    border-radius:12px 12px 0 0;
                                    box-shadow:0 0 20px rgba(245,166,35,0.2);"></div>
                    </div>

                    <!-- 3ème -->
                    <div style="text-align:center;">
                        <div style="font-size:36px;margin-bottom:8px;">🥉</div>
                        <div style="font-weight:800;font-size:15px;margin-bottom:4px;" id="podium-3-nom">—</div>
                        <div style="color:var(--muted);font-size:12px;margin-bottom:6px;">3ème place</div>
                        <div style="color:#CD7F32;font-weight:800;font-size:16px;" id="podium-3-pts">0 pts</div>
                        <div style="height:70px;width:90px;margin:12px auto 0;
                                    background:rgba(205,127,50,0.1);
                                    border:1px solid rgba(205,127,50,0.3);
                                    border-radius:12px 12px 0 0;"></div>
                    </div>

                </div>

                <!-- Ex-aequo -->
                <div id="exaequo-section" style="display:none;">
                    <div style="background:rgba(255,75,75,0.08);border:1px solid rgba(255,75,75,0.25);
                                border-radius:16px;padding:20px;text-align:center;">
                        <div style="font-size:18px;font-weight:800;color:#FF4B4B;margin-bottom:8px;">
                            ⚠️ Ex-aequo détecté !
                        </div>
                        <div style="font-size:13px;color:var(--muted);margin-bottom:16px;" id="exaequo-msg">
                            Plusieurs participants ont le même score.
                        </div>
                        <button onclick="lancerQuestionOr()"
                            style="background:linear-gradient(135deg,var(--gold2),var(--gold));
                                   color:#000;font-weight:800;border:none;border-radius:50px;
                                   padding:12px 28px;font-size:13px;cursor:pointer;
                                   font-family:'Poppins',sans-serif;">
                            ✨ Lancer la Question d'Or
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- PANNEAU LATÉRAL -->
        <div style="display:flex;flex-direction:column;gap:18px;">

            <!-- Scores finale en direct -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.35);position:relative;overflow:visible;">

                <div style="position:absolute;top:-4px;right:30px;width:6px;height:6px;
                            border-radius:50%;background:var(--gold);
                            box-shadow:0 0 10px var(--gold);
                            animation:borderGlow 2.5s infinite;z-index:10;"></div>

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(124,58,237,0.3);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        📡
                    </div>
                    <span style="font-size:15px;font-weight:800;">Scores Finale</span>
                </div>

                <div id="scores-finale" style="font-size:13px;">
                    <div style="text-align:center;padding:30px;">
                        <div style="font-size:40px;margin-bottom:10px;
                                    animation:trophyFloat 3s ease-in-out infinite;">🏆</div>
                        <div style="color:var(--muted);">En attente...</div>
                    </div>
                </div>
            </div>

            <!-- Progression finale -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.35);">

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(245,166,35,0.2);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        📊
                    </div>
                    <span style="font-size:15px;font-weight:800;">Progression</span>
                </div>

                <div style="display:flex;justify-content:space-between;font-size:13px;
                            color:var(--muted);margin-bottom:10px;">
                    <span>Questions</span>
                    <span id="finale-progression">0 / 5</span>
                </div>
                <div style="background:rgba(255,255,255,0.06);border-radius:50px;height:8px;">
                    <div id="finale-progress-bar"
                        style="height:100%;background:linear-gradient(90deg,var(--gold2),var(--gold));
                               border-radius:50px;width:0%;transition:width 0.5s;
                               box-shadow:0 0 10px rgba(245,166,35,0.4);"></div>
                </div>

                <!-- Étapes -->
                <div style="display:flex;justify-content:space-between;margin-top:16px;">
                    <div id="step-finale-1" style="text-align:center;flex:1;">
                        <div style="width:28px;height:28px;border-radius:50%;
                                    background:rgba(255,255,255,0.06);
                                    border:1px solid rgba(255,255,255,0.15);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:11px;font-weight:700;color:var(--muted);
                                    margin:0 auto 4px;">1</div>
                        <div style="font-size:10px;color:var(--muted);">Q1</div>
                    </div>
                    <div id="step-finale-2" style="text-align:center;flex:1;">
                        <div style="width:28px;height:28px;border-radius:50%;
                                    background:rgba(255,255,255,0.06);
                                    border:1px solid rgba(255,255,255,0.15);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:11px;font-weight:700;color:var(--muted);
                                    margin:0 auto 4px;">2</div>
                        <div style="font-size:10px;color:var(--muted);">Q2</div>
                    </div>
                    <div id="step-finale-3" style="text-align:center;flex:1;">
                        <div style="width:28px;height:28px;border-radius:50%;
                                    background:rgba(255,255,255,0.06);
                                    border:1px solid rgba(255,255,255,0.15);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:11px;font-weight:700;color:var(--muted);
                                    margin:0 auto 4px;">3</div>
                        <div style="font-size:10px;color:var(--muted);">Q3</div>
                    </div>
                    <div id="step-finale-4" style="text-align:center;flex:1;">
                        <div style="width:28px;height:28px;border-radius:50%;
                                    background:rgba(255,255,255,0.06);
                                    border:1px solid rgba(255,255,255,0.15);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:11px;font-weight:700;color:var(--muted);
                                    margin:0 auto 4px;">4</div>
                        <div style="font-size:10px;color:var(--muted);">Q4</div>
                    </div>
                    <div id="step-finale-5" style="text-align:center;flex:1;">
                        <div style="width:28px;height:28px;border-radius:50%;
                                    background:rgba(255,255,255,0.06);
                                    border:1px solid rgba(255,255,255,0.15);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:11px;font-weight:700;color:var(--muted);
                                    margin:0 auto 4px;">5</div>
                        <div style="font-size:10px;color:var(--muted);">Q5</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<!-- SECTION STATISTIQUES -->
<div class="section" id="section-stats" style="display:none;">

    <!-- KPI Stats -->
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:24px;">

        <div style="
                    border:1px solid rgba(79,70,229,0.35);border-radius:20px;padding:24px;
                    text-align:center;position:relative;overflow:visible;transition:.3s;"
             onmouseover="this.style.transform='translateY(-4px)'"
             onmouseout="this.style.transform='none'">
            <div style="position:absolute;top:-4px;left:30px;width:6px;height:6px;
                        border-radius:50%;background:var(--gold);
                        box-shadow:0 0 10px var(--gold);
                        animation:borderGlow 2s infinite;"></div>
            <div style="width:52px;height:52px;border-radius:50%;
                        background:rgba(79,70,229,0.25);
                        display:flex;align-items:center;justify-content:center;
                        font-size:24px;margin:0 auto 16px;">👥</div>
            <div style="font-size:38px;font-weight:900;color:var(--gold);
                        text-shadow:0 0 15px rgba(245,166,35,0.4);
                        line-height:1;" id="stat-total-participants">0</div>
            <div style="font-size:11px;color:var(--muted);text-transform:uppercase;
                        letter-spacing:1.5px;margin-top:8px;font-weight:700;">Participants</div>
        </div>

        <div style="
                    border:1px solid rgba(0,255,136,0.25);border-radius:20px;padding:24px;
                    text-align:center;position:relative;overflow:visible;transition:.3s;"
             onmouseover="this.style.transform='translateY(-4px)'"
             onmouseout="this.style.transform='none'">
            <div style="position:absolute;top:-4px;right:30px;width:6px;height:6px;
                        border-radius:50%;background:#00FF88;
                        box-shadow:0 0 10px #00FF88;
                        animation:borderGlow 2.5s infinite;"></div>
            <div style="width:52px;height:52px;border-radius:50%;
                        background:rgba(0,255,136,0.15);
                        display:flex;align-items:center;justify-content:center;
                        font-size:24px;margin:0 auto 16px;">✅</div>
            <div style="font-size:38px;font-weight:900;color:#00FF88;
                        text-shadow:0 0 15px rgba(0,255,136,0.4);
                        line-height:1;" id="stat-total-reponses">0</div>
            <div style="font-size:11px;color:var(--muted);text-transform:uppercase;
                        letter-spacing:1.5px;margin-top:8px;font-weight:700;">Réponses totales</div>
        </div>

        <div style="
                    border:1px solid rgba(124,58,237,0.35);border-radius:20px;padding:24px;
                    text-align:center;position:relative;overflow:visible;transition:.3s;"
             onmouseover="this.style.transform='translateY(-4px)'"
             onmouseout="this.style.transform='none'">
            <div style="position:absolute;bottom:-4px;left:30px;width:6px;height:6px;
                        border-radius:50%;background:#A78BFA;
                        box-shadow:0 0 10px #A78BFA;
                        animation:borderGlow 3s infinite;"></div>
            <div style="width:52px;height:52px;border-radius:50%;
                        background:rgba(124,58,237,0.25);
                        display:flex;align-items:center;justify-content:center;
                        font-size:24px;margin:0 auto 16px;">🎯</div>
            <div style="font-size:38px;font-weight:900;color:#A78BFA;
                        text-shadow:0 0 15px rgba(124,58,237,0.4);
                        line-height:1;" id="stat-taux-reussite">0%</div>
            <div style="font-size:11px;color:var(--muted);text-transform:uppercase;
                        letter-spacing:1.5px;margin-top:8px;font-weight:700;">Taux de réussite</div>
        </div>

        <div style="
                    border:1px solid rgba(245,166,35,0.3);border-radius:20px;padding:24px;
                    text-align:center;position:relative;overflow:visible;transition:.3s;"
             onmouseover="this.style.transform='translateY(-4px)'"
             onmouseout="this.style.transform='none'">
            <div style="position:absolute;top:-4px;left:50%;width:6px;height:6px;
                        border-radius:50%;background:var(--gold2);
                        box-shadow:0 0 10px var(--gold2);
                        animation:borderGlow 2s infinite 0.5s;"></div>
            <div style="width:52px;height:52px;border-radius:50%;
                        background:rgba(245,166,35,0.2);
                        display:flex;align-items:center;justify-content:center;
                        font-size:24px;margin:0 auto 16px;">⚡</div>
            <div style="font-size:38px;font-weight:900;color:var(--gold);
                        text-shadow:0 0 15px rgba(245,166,35,0.4);
                        line-height:1;" id="stat-temps-moyen">0s</div>
            <div style="font-size:11px;color:var(--muted);text-transform:uppercase;
                        letter-spacing:1.5px;margin-top:8px;font-weight:700;">Temps moyen</div>
        </div>

    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;">

        <!-- CLASSEMENT COMPLET -->
        <div class="panel" style="
                                   border:1px solid rgba(124,58,237,0.35);position:relative;overflow:visible;">

            <div style="position:absolute;top:-4px;left:40px;width:8px;height:8px;
                        border-radius:50%;background:var(--gold);
                        box-shadow:0 0 12px var(--gold),0 0 24px var(--gold2);
                        animation:borderGlow 2s infinite;z-index:10;"></div>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(245,166,35,0.2);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        🏅
                    </div>
                    <span style="font-size:18px;font-weight:900;">Classement complet</span>
                </div>
                <button onclick="chargerStats()"
                    style="background:transparent;border:1px solid var(--gold);
                           color:var(--gold);border-radius:50px;padding:10px 20px;
                           font-size:12px;font-weight:700;cursor:pointer;
                           font-family:'Poppins',sans-serif;transition:.3s;
                           display:flex;align-items:center;gap:6px;"
                    onmouseover="this.style.background='var(--gold)';this.style.color='#000'"
                    onmouseout="this.style.background='transparent';this.style.color='var(--gold)'">
                    🔄 Actualiser
                </button>
            </div>

            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead>
                        <tr style="background:rgba(124,58,237,0.15);">
                            <th style="padding:14px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1.5px;
                                       color:var(--gold);font-weight:700;border-radius:12px 0 0 0;">Rang</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1.5px;
                                       color:var(--gold);font-weight:700;">Participant</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1.5px;
                                       color:var(--gold);font-weight:700;">Groupe</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1.5px;
                                       color:var(--gold);font-weight:700;">Score</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;
                                       text-transform:uppercase;letter-spacing:1.5px;
                                       color:var(--gold);font-weight:700;border-radius:0 12px 0 0;">Progression</th>
                        </tr>
                    </thead>
                    <tbody id="table-classement-complet">
                        <tr>
                            <td colspan="5" style="text-align:center;padding:60px 20px;">
                                <div style="font-size:48px;margin-bottom:12px;
                                            animation:trophyFloat 3s ease-in-out infinite;">🏆</div>
                                <div style="font-weight:700;font-size:15px;margin-bottom:6px;">
                                    Aucun score encore
                                </div>
                                <div style="font-size:13px;color:var(--muted);">
                                    Les scores apparaîtront ici après les rounds.
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PANNEAU LATÉRAL -->
        <div style="display:flex;flex-direction:column;gap:18px;">

            <!-- Stats par groupe -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.35);position:relative;overflow:visible;">

                <div style="position:absolute;top:-4px;right:30px;width:6px;height:6px;
                            border-radius:50%;background:var(--gold);
                            box-shadow:0 0 10px var(--gold);
                            animation:borderGlow 3s infinite;z-index:10;"></div>

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(124,58,237,0.25);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        📊
                    </div>
                    <span style="font-size:15px;font-weight:800;">Par groupe</span>
                </div>

                <div id="stats-groupes" style="display:flex;flex-direction:column;gap:14px;">

                    <!-- Groupe 1 -->
                    <div>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:12px;margin-bottom:8px;align-items:center;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:8px;height:8px;border-radius:50%;
                                            background:var(--gold);
                                            box-shadow:0 0 6px var(--gold);"></div>
                                <span style="font-weight:700;">First Round 1</span>
                            </div>
                            <span style="color:var(--gold);font-weight:700;" id="score-bar-g1">— pts</span>
                        </div>
                        <div style="background:rgba(255,255,255,0.06);border-radius:50px;height:8px;">
                            <div style="height:100%;border-radius:50px;width:0%;
                                        background:linear-gradient(90deg,var(--gold2),var(--gold));
                                        transition:.8s;box-shadow:0 0 8px rgba(245,166,35,0.4);"
                                 id="bar-g1"></div>
                        </div>
                    </div>

                    <!-- Groupe 2 -->
                    <div>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:12px;margin-bottom:8px;align-items:center;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:8px;height:8px;border-radius:50%;
                                            background:#A78BFA;
                                            box-shadow:0 0 6px #A78BFA;"></div>
                                <span style="font-weight:700;">First Round 2</span>
                            </div>
                            <span style="color:#A78BFA;font-weight:700;" id="score-bar-g2">— pts</span>
                        </div>
                        <div style="background:rgba(255,255,255,0.06);border-radius:50px;height:8px;">
                            <div style="height:100%;border-radius:50px;width:0%;
                                        background:linear-gradient(90deg,#C4B5FD,#A78BFA);
                                        transition:.8s;box-shadow:0 0 8px rgba(167,139,250,0.4);"
                                 id="bar-g2"></div>
                        </div>
                    </div>

                    <!-- Groupe 3 -->
                    <div>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:12px;margin-bottom:8px;align-items:center;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:8px;height:8px;border-radius:50%;
                                            background:#38BDF8;
                                            box-shadow:0 0 6px #38BDF8;"></div>
                                <span style="font-weight:700;">First Round 3</span>
                            </div>
                            <span style="color:#38BDF8;font-weight:700;" id="score-bar-g3">— pts</span>
                        </div>
                        <div style="background:rgba(255,255,255,0.06);border-radius:50px;height:8px;">
                            <div style="height:100%;border-radius:50px;width:0%;
                                        background:linear-gradient(90deg,#7DD3FC,#38BDF8);
                                        transition:.8s;box-shadow:0 0 8px rgba(56,189,248,0.4);"
                                 id="bar-g3"></div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Stats par question -->
            <div class="panel" style="
                                       border:1px solid rgba(124,58,237,0.35);position:relative;overflow:visible;">

                <div style="position:absolute;bottom:-4px;left:30px;width:6px;height:6px;
                            border-radius:50%;background:var(--gold2);
                            box-shadow:0 0 10px var(--gold2);
                            animation:borderGlow 2.5s infinite 1s;z-index:10;"></div>

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                    <div style="width:36px;height:36px;border-radius:50%;
                                background:rgba(245,166,35,0.2);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        ❓
                    </div>
                    <span style="font-size:15px;font-weight:800;">Par question</span>
                </div>

                <div id="stats-questions-list"
                     style="display:flex;flex-direction:column;gap:10px;max-height:300px;overflow-y:auto;">
                    <div style="text-align:center;padding:20px;">
                        <div style="font-size:13px;color:var(--muted);">En attente...</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>





<script>

function toggleTheme(){

document.body.classList.toggle('light');

const isLight = document.body.classList.contains('light');

document.getElementById('themeBtn').innerText =
isLight ? '☀️' : '🌙';

localStorage.setItem('theme',
isLight ? 'light' : 'dark');

}

window.onload = () => {
    if(localStorage.getItem('theme') === 'light'){
        document.body.classList.add('light');
        document.getElementById('themeBtn').innerText='☀️';
    }

    // Réinitialiser toute l'UI au chargement
    sessionCourante     = null;
    roundActuel         = 1;
    questionIndex       = 0;
    questionsRound      = [];
    nbParticipantsRound = 0;

    // Réinitialiser top 3
    document.getElementById('top3-list').innerHTML = `
        <div style="text-align:center;padding:20px;">
            <img src="../assets/img/trophy.png"
                 style="width:200px;height:auto;object-fit:contain;display:block;
                        margin:0 auto 8px auto;
                        filter:drop-shadow(0 0 15px rgba(245,166,35,0.4));
                        animation:trophyFloat 3s ease-in-out infinite;">
            <div style="font-size:13px;color:var(--muted);">En attente...</div>
        </div>`;

    // Réinitialiser finalistes
    [1,2,3].forEach(n => {
        document.getElementById('finaliste-' + n + '-nom').textContent = '—';
        document.getElementById('finaliste-' + n + '-pts').textContent = '0 pts';
    });

    // Réinitialiser scores finale
    document.getElementById('scores-finale').innerHTML = `
        <div style="text-align:center;padding:30px;">
            <div style="font-size:40px;margin-bottom:10px;">🏆</div>
            <div style="color:var(--muted);">En attente...</div>
        </div>`;

    // Réinitialiser rounds
    document.getElementById('round-badge').textContent       = '⏳ En attente';
    document.getElementById('round-badge').style.color       = 'var(--gold)';
    document.getElementById('q-progression').textContent     = '0 / 10';
    document.getElementById('progress-bar').style.width      = '0%';
    document.getElementById('nb-reponses').textContent       = '0';
    document.getElementById('progress-reponses').style.width = '0%';
    document.getElementById('panel-question').style.display  = 'none';
    document.getElementById('panel-stats-q').style.display   = 'none';

    // Réinitialiser la liste des questions
document.getElementById('table-questions').innerHTML = `
    <tr>
        <td colspan="8" style="text-align:center;padding:60px 20px;">
            <div style="font-size:48px;margin-bottom:12px;">📁</div>
            <div style="font-weight:700;font-size:15px;margin-bottom:6px;">
                Aucune question importée
            </div>
            <div style="font-size:13px;color:var(--muted);">
                Importez un fichier Excel ou ajoutez vos questions manuellement.
            </div>
        </td>
    </tr>`;

document.getElementById('count-questions').textContent = '(0)';
}

function showSection(name, el) {
    document.querySelectorAll('.section').forEach(s => s.style.display = 'none');
    document.querySelectorAll('.menu-item').forEach(m => m.classList.remove('active'));
    
    const section = document.getElementById('section-' + name);
    if (section) {
        section.style.display = 'block';
    }
    
    if (el) el.classList.add('active');

    // Charger les données selon la section
    if (name === 'participants') chargerParticipants();
    if (name === 'questions') chargerQuestions();
    if (name === 'finale') {
    chargerFinalistes();
    chargerScoresFinale();
}
if (name === 'stats') chargerStats();
}

function chargerParticipants() {
    fetch('../api/participant.php?action=list')
    .then(r => r.json())
    .then(participants => {
        const attente = participants.filter(p => !p.groupe_id);
        const groupes = participants.filter(p => p.groupe_id);

        document.getElementById('count-attente').textContent = attente.length;
        document.getElementById('count-groupes').textContent = groupes.length;

        const tbody = document.getElementById('table-attente');
        if (participants.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;
                color:var(--muted);padding:40px;">⏳ En attente de participants...</td></tr>`;
            return;
        }

        // Couleurs avatar par initiale
        const colors = ['#4F46E5','#7C3AED','#059669','#DC2626','#D97706','#0891B2'];

        tbody.innerHTML = participants.map((p, i) => {
            const initiale = p.nom.charAt(0).toUpperCase();
            const couleur = colors[i % colors.length];
            const groupeBadge = p.groupe_nom
                ? `<span style="background:rgba(245,166,35,0.15);color:var(--gold);
                               padding:5px 14px;border-radius:50px;font-size:11px;
                               font-weight:800;">${p.groupe_nom}</span>`
                : `<span style="background:rgba(0,255,136,0.1);color:var(--green);
                               padding:5px 14px;border-radius:50px;font-size:11px;
                               font-weight:700;">En attente</span>`;

            return `
            <tr style="border-bottom:1px solid var(--border);">
                <td style="padding:14px 16px;color:var(--muted);">${i+1}</td>
                <td style="padding:14px 16px;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:50%;
                                    background:${couleur};color:#fff;
                                    display:flex;align-items:center;justify-content:center;
                                    font-weight:800;font-size:13px;flex-shrink:0;">
                            ${initiale}
                        </div>
                        <span style="font-weight:600;">${p.nom}</span>
                    </div>
                </td>
                <td style="padding:14px 16px;color:var(--muted);">
                    ${p.created_at || "Aujourd'hui"}
                </td>
                <td style="padding:14px 16px;">${groupeBadge}</td>
                <td style="padding:14px 16px;">
                    <button onclick="supprimerParticipant(${p.id})"
                        style="background:rgba(255,75,75,0.1);border:1px solid rgba(255,75,75,0.2);
                               color:var(--red);border-radius:10px;padding:8px 12px;
                               font-size:14px;cursor:pointer;transition:.2s;"
                        onmouseover="this.style.background='rgba(255,75,75,0.2)'"
                        onmouseout="this.style.background='rgba(255,75,75,0.1)'">
                        🗑️
                    </button>
                </td>
            </tr>`;
        }).join('');

        if (groupes.length > 0) afficherGroupes(participants);
    });
}

function afficherGroupes(participants) {
    document.getElementById('groupes-panel').style.display = 'block';
    const colors = ['#4F46E5','#7C3AED','#059669','#DC2626','#D97706','#0891B2'];

    [1, 2, 3].forEach(g => {
        const membres = participants.filter(p => p.groupe_id == g);
        const countEl = document.getElementById('count-g' + g);
        if (countEl) countEl.textContent = membres.length + ' participant' + (membres.length > 1 ? 's' : '');

        const liste = membres.length === 0
            ? `<div style="text-align:center;padding:30px;color:var(--muted);">
                    <span style="font-size:28px;opacity:0.3;">👥</span>
                    <div style="margin-top:8px;font-size:13px;">Vide</div>
               </div>`
            : membres.map((p, i) => {
                const initiale = p.nom.charAt(0).toUpperCase();
                const couleur = colors[i % colors.length];
                return `
                <div style="display:flex;align-items:center;gap:10px;
                            padding:10px 0;border-bottom:1px solid var(--border);">
                    <div style="width:32px;height:32px;border-radius:50%;
                                background:${couleur};color:#fff;
                                display:flex;align-items:center;justify-content:center;
                                font-weight:800;font-size:12px;flex-shrink:0;">
                        ${initiale}
                    </div>
                    <span style="font-size:13px;font-weight:500;">${p.nom}</span>
                </div>`;
            }).join('');

        document.getElementById('groupe-' + g + '-list').innerHTML = liste;
    });
}

function lancerTirage() {
    const attente = document.getElementById('count-attente').textContent;
    if (attente < 3) {
        alert('Il faut au moins 3 participants pour lancer le tirage !');
        return;
    }
    if (!confirm('Lancer le tirage au sort ? Les participants seront répartis en 3 groupes.')) return;

    fetch('../api/participant.php?action=tirage', { method: 'POST' })
    .then(r => r.json())
    .then(data => {
        alert('✅ ' + data.message);
        chargerParticipants();
    });
}

function lancerQuestionDepartage(p1, p2) {
    if (!sessionCourante || !sessionCourante.id) {
        alert('❌ Aucune session active !');
        return;
    }
    
    if (!confirm(`⚔️ LANCER LE DÉPARTAGE ?\n\n${p1.nom} VS ${p2.nom}\n\nUne seule question les départagera !`)) return;

    fetch('../api/departage.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'lancer',
            session_id: sessionCourante.id,
            participants: [p1, p2]
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Afficher la question de départage dans l'interface admin
            afficherQuestionDepartage(data.question, data.participants);
        } else {
            alert('❌ ' + (data.error || 'Erreur inconnue'));
        }
    });
}

function afficherQuestionDepartage(question, participants) {
    // Créer/montrer une zone spéciale pour le départage
    const panelDepartage = document.getElementById('panel-departage');
    if (!panelDepartage) {
        // Créer le panneau s'il n'existe pas
        const div = document.createElement('div');
        div.id = 'panel-departage';
        div.className = 'panel';
        div.style.cssText = `
            background:linear-gradient(135deg,rgba(255,75,75,0.1),rgba(245,166,35,0.05));
            border:2px solid var(--gold);
            margin-bottom:24px;
            padding:24px;
            text-align:center;
        `;
        document.querySelector('#section-rounds .panel').after(div);
    }
    
    const panel = document.getElementById('panel-departage');
    panel.style.display = 'block';
    panel.innerHTML = `
        <div style="font-size:36px;margin-bottom:12px;">⚔️</div>
        <div style="font-size:20px;font-weight:900;color:var(--gold);margin-bottom:8px;">
            QUESTION DE DÉPARTAGE
        </div>
        <div style="font-size:16px;color:var(--muted);margin-bottom:20px;">
            ${participants[0].nom} VS ${participants[1].nom}
        </div>
        <div style="font-size:18px;font-weight:700;margin-bottom:24px;
                    padding:20px;background:rgba(245,166,35,0.06);
                    border:1px solid rgba(245,166,35,0.2);border-radius:16px;">
            ${question.texte}
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px;">
            ${[question.choix_1, question.choix_2, question.choix_3, question.choix_4].map((c, i) => `
                <div style="background:rgba(255,255,255,0.05);border:1px solid var(--border);
                            border-radius:12px;padding:14px;">
                    <span style="color:var(--gold);font-weight:800;">${i+1}.</span> ${c}
                </div>
            `).join('')}
        </div>
        <div style="display:flex;gap:12px;">
            <button onclick="topChronoDepartage(${question.id})"
                style="background:linear-gradient(135deg,#00FF88,#00cc66);
                       color:#000;font-weight:800;border:none;border-radius:50px;
                       padding:14px 28px;font-size:13px;cursor:pointer;flex:1;">
                ⏱ TOP CHRONO
            </button>
            <button onclick="annulerDepartage()"
                style="background:rgba(255,75,75,0.1);border:1px solid rgba(255,75,75,0.2);
                       color:var(--red);border-radius:50px;
                       padding:14px 28px;font-size:13px;cursor:pointer;flex:1;">
                ❌ Annuler
            </button>
        </div>
    `;
}

function annulerDepartage() {
    document.getElementById('panel-departage').style.display = 'none';
}
function topChronoDepartage(questionId) {
    console.log('⏱ TOP CHRONO DÉPARTAGE - Question', questionId);
    
    // 1. Créer un round spécial "departage" pour que les participants voient la question
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'demarrer_round_unifie',
            round: 'departage',
            question_id: questionId,
            session_id: sessionCourante.id,
            groupe_id: roundActuel
        })
    })
    .then(r => r.json())
    .then(data => {
        console.log('Round départage créé:', data);
        
        // 2. Lancer le chrono
        fetch('../api/departage.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'top_chrono',
                question_id: questionId
            })
        });
        
        // 3. Chrono visuel
        let temps = 10;
        const boutons = document.querySelectorAll('#panel-departage button');
        boutons.forEach(b => b.style.display = 'none');
        
        let chronoDiv = document.getElementById('chrono-departage');
        if (!chronoDiv) {
            chronoDiv = document.createElement('div');
            chronoDiv.id = 'chrono-departage';
            chronoDiv.style.cssText = `
                font-size:48px;font-weight:900;color:var(--gold);
                text-align:center;margin:20px 0;
            `;
            document.querySelector('#panel-departage').appendChild(chronoDiv);
        }
        
        const interval = setInterval(() => {
            temps--;
            chronoDiv.textContent = temps;
            if (temps <= 3) chronoDiv.style.color = 'var(--red)';
            else if (temps <= 5) chronoDiv.style.color = '#FF9500';
            
            if (temps <= 0) {
                clearInterval(interval);
                chronoDiv.textContent = '⏰';
                setTimeout(() => verifierResultatDepartage(questionId), 2000);
            }
        }, 1000);
    });
}

function verifierResultatDepartage(questionId) {
    const participants = window.exaequoRound 
        ? [window.exaequoRound.participant1, window.exaequoRound.participant2]
        : [];
    
    const participantIds = participants.map(p => p.id);
    
    fetch('../api/departage.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'verifier',
            question_id: questionId,
            participant_ids: participantIds
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.termine && data.gagnant) {
            alert(`🏆 VAINQUEUR DU DÉPARTAGE : ${data.gagnant.nom} !\n\n` +
                  `Raison : ${data.raison === 'temps' ? 'Plus rapide' : 'Bonne réponse'}`);
            
            // Mettre à jour le finaliste
            document.getElementById('finaliste-' + roundActuel + '-nom').textContent = data.gagnant.nom;
            document.getElementById('finaliste-' + roundActuel + '-pts').textContent = participants.find(p => p.id == data.gagnant.participant_id).total_points + ' pts';
            
            // Masquer le panneau de départage
            annulerDepartage();
            
        } else if (data.termine && !data.gagnant) {
            alert('❌ Aucun gagnant. Les deux participants n\'ont pas trouvé la bonne réponse.\n\nLancez une nouvelle question de départage.');
        } else {
            alert('⏳ En attente des réponses des participants...');
        }
    });
}

function supprimerParticipant(id) {
    if (!confirm('Supprimer ce participant ?')) return;
    fetch('../api/participant.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete', id })
    })
    .then(r => r.json())
    .then(() => chargerParticipants());
}


function chargerQuestions() {
    fetch('../api/questions.php?action=list')
    .then(r => r.json())
    .then(questions => {
        document.getElementById('count-questions').textContent = '(' + questions.length + ')';
        const tbody = document.getElementById('table-questions');
        if (questions.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px;">Aucune question</td></tr>';
            return;
        }
        tbody.innerHTML = questions.map((q, i) => `
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);">${i+1}</td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);font-weight:600;max-width:200px;">${q.texte}</td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);color:var(--muted);">${q.choix_1}</td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);color:var(--muted);">${q.choix_2}</td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);color:var(--muted);">${q.choix_3}</td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);color:var(--muted);">${q.choix_4}</td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);">
                    <span style="background:rgba(0,255,136,0.1);color:var(--green);padding:4px 12px;
                                 border-radius:50px;font-size:11px;font-weight:700;">
                        Choix ${q.bonne_reponse}
                    </span>
                </td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);">
                    <button onclick="supprimerQuestion(${q.id})"
                        style="background:rgba(255,75,75,0.1);border:1px solid rgba(255,75,75,0.2);
                               color:var(--red);border-radius:8px;padding:4px 10px;
                               font-size:11px;cursor:pointer;">
                        🗑️
                    </button>
                </td>
            </tr>
        `).join('');
    });
}

function ajouterQuestion() {
    const texte = document.getElementById('q-texte').value.trim();
    const c1 = document.getElementById('q-c1').value.trim();
    const c2 = document.getElementById('q-c2').value.trim();
    const c3 = document.getElementById('q-c3').value.trim();
    const c4 = document.getElementById('q-c4').value.trim();
    const rep = document.getElementById('q-correct').value;

    if (!texte || !c1 || !c2 || !c3 || !c4) {
        alert('Veuillez remplir tous les champs !');
        return;
    }

    fetch('../api/questions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: 'add', texte,
            choix_1: c1, choix_2: c2, choix_3: c3, choix_4: c4,
            bonne_reponse: rep
        })
    })
    .then(r => {
        // AJOUT DEBUG : voir la réponse brute du serveur
        return r.text();
    })
    .then(rawText => {
        console.log('Réponse brute PHP :', rawText);
        try {
            const data = JSON.parse(rawText);
            if (data.success) {
                alert('✅ Question ajoutée !');
                ['q-texte','q-c1','q-c2','q-c3','q-c4'].forEach(id => {
                    document.getElementById(id).value = '';
                });
                chargerQuestions();
            } else {
                alert('❌ Erreur : ' + (data.error || data.message || 'Réponse inattendue'));
            }
        } catch(e) {
            alert('❌ Le serveur a renvoyé une erreur :\n\n' + rawText.substring(0, 300));
        }
    })
    .catch(err => {
        alert('❌ Erreur réseau : ' + err.message);
    });
}

function supprimerQuestion(id) {
    if (!confirm('Supprimer cette question ?')) return;
    fetch('../api/questions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'delete', id })
    })
    .then(r => r.json())
    .then(() => chargerQuestions());
}

function importerQuestions() {
    const file = document.getElementById('excel-questions').files[0];
    if (!file) { alert('Choisissez un fichier Excel !'); return; }
    
    const formData = new FormData();
    formData.append('file', file);
    formData.append('action', 'import');
    
    fetch('../api/questions.php', { method: 'POST', body: formData })
    .then(r => r.text())
    .then(rawText => {
        console.log('Réponse import PHP :', rawText);
        try {
            const data = JSON.parse(rawText);
            document.getElementById('import-msg').innerHTML =
                `<span style="color:var(--green);">✅ ${data.message}</span>`;
            chargerQuestions();
        } catch(e) {
            alert('❌ Erreur serveur :\n\n' + rawText.substring(0, 300));
        }
    })
    .catch(err => alert('❌ Erreur réseau : ' + err.message));
}

function exporterQuestions() {
    window.location.href = '../api/questions.php?action=export';
}




// =========================
// VARIABLES ROUNDS
// =========================
let roundActuel = 1;
let questionIndex = 0;
let questionsRound = [];
let chronoInterval = null;
let chronoEnCours = false;

// =========================
// SÉLECTIONNER UN ROUND
// =========================
function selectionnerRound(num) {
    roundActuel = num;
    document.getElementById('round-titre').textContent = 'First Round ' + num;
    document.getElementById('panel-question').style.display = 'none';
    document.getElementById('panel-stats-q').style.display = 'none';

    // Vérifier le statut du round en base
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'statut_round', round: num })
    })
    .then(r => r.json())
    .then(data => {
        const btnDemarrer = document.getElementById('btn-demarrer');
        const badge = document.getElementById('round-badge');

        if (data.statut === 'termine') {
            // Round terminé — garder l'état terminé
            badge.textContent = '✅ Terminé';
            badge.style.color = 'var(--green)';
            document.getElementById('q-progression').textContent = data.total + ' / ' + data.total;
            document.getElementById('progress-bar').style.width = '100%';
            btnDemarrer.style.display = 'flex';
            btnDemarrer.disabled = true;
            btnDemarrer.style.opacity = '0.5';
            btnDemarrer.style.cursor = 'not-allowed';
            btnDemarrer.style.background = 'rgba(0,255,136,0.2)';
            btnDemarrer.innerHTML = '✅ &nbsp;Round terminé';

        } else if (data.statut === 'en_cours') {
            badge.textContent = '▶ En cours';
            badge.style.color = 'var(--green)';
            btnDemarrer.style.display = 'none';

        } else {
            // En attente — bouton actif
            badge.innerHTML = '⏳ En attente';
            badge.style.color = 'var(--gold)';
            document.getElementById('q-progression').textContent = '0 / 10';
            document.getElementById('progress-bar').style.width = '0%';
            btnDemarrer.style.display = 'flex';
            btnDemarrer.disabled = false;
            btnDemarrer.style.opacity = '1';
            btnDemarrer.style.cursor = 'pointer';
            btnDemarrer.style.background = 'linear-gradient(135deg,var(--gold2),var(--gold))';
            btnDemarrer.innerHTML = '➤ &nbsp;Démarrer le Round';
        }
    });

    // Styles boutons sélecteur
    [1,2,3].forEach(i => {
        const btn = document.getElementById('btn-r' + i);
        if (i === num) {
            btn.style.background = 'linear-gradient(135deg,var(--gold2),var(--gold))';
            btn.style.color = '#000';
            btn.style.border = 'none';
            btn.style.boxShadow = '0 0 20px rgba(245,166,35,0.4)';
        } else {
            btn.style.background = 'transparent';
            btn.style.color = 'var(--gold)';
            btn.style.border = '2px solid var(--gold)';
            btn.style.boxShadow = 'none';
        }
    });
}

// =========================
// DÉMARRER LE ROUND
// =========================
let nbParticipantsRound = 0;

function demarrerRound() {
    const element = document.getElementById('count-questions');

    if (!element) {
        console.error("Élément #count-questions introuvable !");
        return;
    }

    const texteBrut = element.textContent || "(0)";
    const nbQuestionsDispo = parseInt(texteBrut.replace(/[()]/g, ''), 10);

    

    if (!nbQuestionsDispo || nbQuestionsDispo === 0) {
        alert("Action impossible : Il n'y a aucune question chargée pour ce round !");
        return;
    }

    if (!confirm('Démarrer First Round ' + roundActuel + ' ?')) return;

    // Premier fetch pour compter (Optionnel si session.php le fait déjà, mais gardons-le)
    fetch('../api/participant.php?action=count_groupe&groupe_id=' + roundActuel)
    .then(r => r.json())
    .then(d => { nbParticipantsRound = d.count || 0; });

    // LE FETCH À MODIFIER
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'demarrer_round_unifie', round: roundActuel })
    })
    .then(async response => {
        // Au lieu de faire .json() direct, on récupère le texte brut
        const text = await response.text();
        
        try {
            // On essaie de transformer le texte en JSON manuellement
            return JSON.parse(text);
        } catch (err) {
            // SI ÇA PLANTE : On affiche le texte brut dans la console pour voir l'erreur PHP
            console.error("ERREUR DE PARSING JSON ! Contenu reçu du serveur :");
            console.log(text); 
            throw new Error("Le serveur a renvoyé du texte au lieu de JSON. Regarde la console (F12).");
        }
    })
    .then(data => {
        if (data.success) {
            nbParticipantsRound = data.nb_participants || 0;
            document.getElementById('nb-participants-round').textContent = nbParticipantsRound;
            questionsRound = data.questions || [];
            questionIndex = 0;
            document.getElementById('round-badge').textContent = '▶ En cours';
            document.getElementById('round-badge').style.color = 'var(--green)';
            document.getElementById('btn-demarrer').style.display = 'none';
            afficherQuestion();
        } else {
            alert('Erreur : ' + (data.error || JSON.stringify(data)));
        }
    })
    .catch(error => {
        console.error("Erreur globale :", error);
        alert(error.message);
    });
}


// =========================
// AFFICHER LA QUESTION
// =========================
function afficherQuestion() {
    if (questionIndex >= questionsRound.length) {
        finRound();
        return;
    }


    const q = questionsRound[questionIndex];
    const total = questionsRound.length;
    const num = questionIndex + 1;

    document.getElementById('panel-question').style.display = 'block';
    document.getElementById('q-num-badge').textContent = 'Q' + num + ' / ' + total;
    document.getElementById('q-texte-display').textContent = q.texte;
    document.getElementById('q-progression').textContent = num + ' / ' + total;
    document.getElementById('progress-bar').style.width = (num / total * 100) + '%';
    document.getElementById('panel-stats-q').style.display = 'none';
    document.getElementById('chrono-num').textContent = '10';
    document.getElementById('chrono-admin').style.borderColor = 'var(--gold)';
    document.getElementById('chrono-admin').style.color = 'var(--gold)';

    // Afficher les choix
    const choix = [q.choix_1, q.choix_2, q.choix_3, q.choix_4];
    document.getElementById('choix-display').innerHTML = choix.map((c, i) => `
        <div style="background:var(--card);border:1px solid var(--border);
                    border-radius:12px;padding:12px 16px;font-size:13px;">
            <span style="color:var(--gold);font-weight:800;margin-right:8px;">${i+1}.</span>${c}
        </div>
    `).join('');

    // Boutons
    document.getElementById('btn-top-chrono').style.display = 'block';
    document.getElementById('btn-stop-chrono').style.display = 'none';
    document.getElementById('btn-afficher-stats').style.display = 'none';
    document.getElementById('btn-suivante').style.display = 'none';

    // Réinitialiser réponses
    document.getElementById('nb-reponses').textContent = '0';
    document.getElementById('progress-reponses').style.width = '0%';

    // Polling réponses
    startPollingReponses(q.id);
}

// =========================
// TOP CHRONO
// =========================
function topChrono() {
    if (chronoInterval) { clearInterval(chronoInterval); chronoInterval = null; }
    chronoEnCours = true;
    let temps = 10;
    const el = document.getElementById('chrono-num');
    const box = document.getElementById('chrono-admin');
    el.textContent = temps;
    box.style.borderColor = 'var(--gold)';
    box.style.color = 'var(--gold)';
    document.getElementById('btn-top-chrono').style.display = 'none';
    document.getElementById('btn-stop-chrono').style.display = 'block';
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'top_chrono', question_id: questionsRound[questionIndex].id })
    });
    chronoInterval = setInterval(() => {
        temps--;
        if (temps < 0) { clearInterval(chronoInterval); chronoInterval = null; return; }
        el.textContent = temps;
        if (temps <= 3) { box.style.borderColor = 'var(--red)'; box.style.color = 'var(--red)'; }
        else if (temps <= 5) { box.style.borderColor = '#FF9500'; box.style.color = '#FF9500'; }
        if (temps === 0) {
            clearInterval(chronoInterval); chronoInterval = null; chronoEnCours = false;
            document.getElementById('btn-stop-chrono').style.display = 'none';
            document.getElementById('btn-afficher-stats').style.display = 'block';
            document.getElementById('btn-suivante').style.display = 'block';
        }
    }, 1000);
}

// =========================


// =========================
// VARIABLES FINALE
// =========================
let questionsFinale = [];
let questionFinaleIndex = 0;
let chronoFinaleInterval = null;

// =========================
// CHARGER LES FINALISTES
// =========================
function chargerFinalistes() {
    fetch('../api/participant.php?action=finalistes')
    .then(r => r.json())
    .then(data => {
        if (!data.finalistes || data.finalistes.length === 0) {
            alert('Aucun finaliste trouvé. Les 3 rounds doivent être terminés.');
            return;
        }
        data.finalistes.forEach((f, i) => {
            const n = i + 1;
            document.getElementById('finaliste-' + n + '-nom').textContent = f.nom || '—';
            document.getElementById('finaliste-' + n + '-pts').textContent = (f.total_points || 0) + ' pts';
        });
    });
}

// =========================
// DÉMARRER LA FINALE
// =========================
function demarrerFinale() {
    if (!confirm('Démarrer la FINALE avec 5 questions ?')) return;

    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'demarrer_round_unifie', round: 'finale' })
    })
    .then(r => r.json())
    .then(data => {
        console.log('demarrerFinale response:', data); // DEBUG
        if (data.success) {
            questionsFinale = data.questions || [];
            questionFinaleIndex = 0;
            document.getElementById('btn-demarrer-finale').style.display = 'none';
            afficherQuestionFinale();
        } else {
            alert('Erreur : ' + (data.error || JSON.stringify(data)));
        }
    })
    .catch(err => {
        console.log('demarrerFinale error:', err); // DEBUG
        alert('Erreur réseau : ' + err.message);
    });
}
// =========================
// AFFICHER QUESTION FINALE
// =========================
function afficherQuestionFinale() {
    if (questionFinaleIndex >= questionsFinale.length) {
        finFinale();
        return;
    }

    const q = questionsFinale[questionFinaleIndex];
    const total = questionsFinale.length;
    const num = questionFinaleIndex + 1;

    document.getElementById('panel-question-finale').style.display = 'block';
    document.getElementById('q-finale-badge').textContent = 'Q' + num + ' / ' + total;
    document.getElementById('q-finale-texte').textContent = q.texte;
    document.getElementById('finale-progression').textContent = num + ' / ' + total;
    document.getElementById('finale-progress-bar').style.width = (num / total * 100) + '%';
    // Après la ligne finale-progress-bar width
for (let s = 1; s <= 5; s++) {
    const stepEl = document.getElementById('step-finale-' + s);
    if (stepEl) {
        const circle = stepEl.querySelector('div');
        if (s <= num) {
            circle.style.background = 'linear-gradient(135deg,var(--gold2),var(--gold))';
            circle.style.color = '#000';
            circle.style.border = 'none';
        } else {
            circle.style.background = 'rgba(255,255,255,0.06)';
            circle.style.color = 'var(--muted)';
            circle.style.border = '1px solid rgba(255,255,255,0.15)';
        }
    }
}
    document.getElementById('chrono-finale-num').textContent = '10';
    document.getElementById('chrono-finale').style.borderColor = 'var(--gold)';
    document.getElementById('chrono-finale').style.color = 'var(--gold)';

    const choix = [q.choix_1, q.choix_2, q.choix_3, q.choix_4];
    document.getElementById('choix-finale-display').innerHTML = choix.map((c, i) => `
        <div style="background:var(--card);border:1px solid var(--border);
                    border-radius:12px;padding:12px 16px;font-size:13px;">
            <span style="color:var(--gold);font-weight:800;margin-right:8px;">${i+1}.</span>${c}
        </div>
    `).join('');

    document.getElementById('btn-top-finale').style.display = 'block';
    document.getElementById('btn-stop-finale').style.display = 'none';
    document.getElementById('btn-stats-finale').style.display = 'none';
    document.getElementById('btn-suivante-finale').style.display = 'none';

    chargerScoresFinale();
}

// =========================
// TOP CHRONO FINALE
// =========================
function topChronoFinale() {
    if (chronoFinaleInterval) { clearInterval(chronoFinaleInterval); chronoFinaleInterval = null; }
    let temps = 10;
    const el = document.getElementById('chrono-finale-num');
    const box = document.getElementById('chrono-finale');
    el.textContent = temps;
    box.style.borderColor = 'var(--gold)';
    box.style.color = 'var(--gold)';
    document.getElementById('btn-top-finale').style.display = 'none';
    document.getElementById('btn-stop-finale').style.display = 'block';
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            action: 'top_chrono', 
            question_id: questionsFinale[questionFinaleIndex].id  // AJOUT
        })
    });
    chronoFinaleInterval = setInterval(() => {
        temps--;
        if (temps < 0) { clearInterval(chronoFinaleInterval); chronoFinaleInterval = null; return; }
        el.textContent = temps;
        if (temps <= 3) { box.style.borderColor = 'var(--red)'; box.style.color = 'var(--red)'; }
        else if (temps <= 5) { box.style.borderColor = '#FF9500'; box.style.color = '#FF9500'; }
        if (temps === 0) {
            clearInterval(chronoFinaleInterval); chronoFinaleInterval = null;
            document.getElementById('btn-stop-finale').style.display = 'none';
            document.getElementById('btn-stats-finale').style.display = 'block';
            document.getElementById('btn-suivante-finale').style.display = 'block';
        }
    }, 1000);
}

// =========================
// STOP CHRONO FINALE
// =========================
function stopChronoFinale() {
    clearInterval(chronoFinaleInterval);
    document.getElementById('btn-stop-finale').style.display = 'none';
    document.getElementById('btn-stats-finale').style.display = 'block';
    document.getElementById('btn-suivante-finale').style.display = 'block';
}

// =========================
// STATS FINALE
// =========================
function afficherStatsFinale() {
    const q = questionsFinale[questionFinaleIndex];
    fetch('../api/stats.php?question_id=' + q.id)
    .then(r => r.json())
    .then(data => {
        alert('📊 Stats : ' + JSON.stringify(data.repartition));
    });
}

// =========================
// QUESTION SUIVANTE FINALE
// =========================
function questionSuivanteFinale() {
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'suivante' })
    })
    .then(r => r.json())
    .then(data => {
        if (data.termine) {
            finFinale();
        } else {
            questionFinaleIndex++;
            afficherQuestionFinale();
        }
    });
}

// =========================
// FIN DE FINALE
// =========================
function finFinale() {
    document.getElementById('panel-question-finale').style.display = 'none';
    document.getElementById('panel-podium').style.display = 'block';
 
    // Toujours passer type=finale — session_id est récupéré
    // automatiquement par classement.php si non fourni
    fetch(`../api/classement.php?type=finale`)
    .then(r => r.json())
    .then(data => {
        console.log('Podium finale data:', data); // DEBUG
 
        if (!Array.isArray(data) || data.length === 0) {
            console.log('Aucun score finale disponible');
            return;
        }
 
        const p1 = data[0];
        const p2 = data[1];
        const p3 = data[2];
 
        if (p1) {
            document.getElementById('podium-1-nom').textContent = p1.nom;
            document.getElementById('podium-1-pts').textContent = p1.total_points + ' pts';
        }
        if (p2) {
            document.getElementById('podium-2-nom').textContent = p2.nom;
            document.getElementById('podium-2-pts').textContent = p2.total_points + ' pts';
        }
        if (p3) {
            document.getElementById('podium-3-nom').textContent = p3.nom;
            document.getElementById('podium-3-pts').textContent = p3.total_points + ' pts';
        }
 
        // Vérifier ex-aequo entre 1er et 2ème
        if (p1 && p2 && p1.total_points === p2.total_points) {
            document.getElementById('exaequo-section').style.display = 'block';
            document.getElementById('exaequo-msg').textContent =
                p1.nom + ' et ' + p2.nom + ' sont ex-aequo avec ' +
                p1.total_points + ' pts !';
        }
    });
}
// =========================
// QUESTION D'OR
// =========================
function lancerQuestionOr() {
    alert('✨ Question d\'Or lancée ! Les ex-aequo vont répondre à une question supplémentaire.');
    // À connecter avec le backend
}

// =========================
// SCORES FINALE EN DIRECT
// =========================
function chargerScoresFinale() {
    // Toujours type=finale pour ne voir QUE les scores de la finale
    fetch(`../api/classement.php?type=finale`)
    .then(r => r.json())
    .then(data => {
        if (!Array.isArray(data) || data.length === 0) {
            document.getElementById('scores-finale').innerHTML = `
                <div style="text-align:center;padding:30px;">
                    <div style="font-size:40px;margin-bottom:10px;">🏆</div>
                    <div style="color:var(--muted);">En attente du début de la finale...</div>
                </div>`;
            return;
        }
 
        const medals = ['🥇','🥈','🥉'];
        document.getElementById('scores-finale').innerHTML = data.slice(0,3).map((p, i) => `
            <div style="display:flex;justify-content:space-between;align-items:center;
                        padding:12px 0;border-bottom:1px solid var(--border);">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="font-size:18px;">${medals[i] || (i+1)}</span>
                    <span style="font-weight:600;font-size:13px;">${p.nom}</span>
                </div>
                <span style="color:var(--gold);font-weight:800;">${p.total_points} pts</span>
            </div>
        `).join('');
    });
}



function chargerStats() {
    // Classement complet
    fetch('../api/classement.php')
    .then(r => r.json())
    .then(data => {
        if (!Array.isArray(data) || data.length === 0) return;

        const medals = ['🥇','🥈','🥉'];
        document.getElementById('stat-total-participants').textContent = data.length;

        document.getElementById('table-classement-complet').innerHTML = data.map((p, i) => `
            <tr>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);">
                    ${medals[i] || (i+1)}
                </td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);font-weight:600;">
                    ${p.nom}
                </td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);">
                    <span style="background:rgba(245,166,35,0.1);color:var(--gold);
                                 padding:3px 10px;border-radius:50px;font-size:11px;font-weight:700;">
                        ${p.groupe}
                    </span>
                </td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);">
                    <span style="color:var(--gold);font-weight:800;">${p.total_points} pts</span>
                </td>
                <td style="padding:12px 16px;border-bottom:1px solid var(--border);">
                    <div style="background:rgba(255,255,255,0.08);border-radius:50px;height:6px;width:80px;">
                        <div style="height:100%;border-radius:50px;
                                    background:linear-gradient(90deg,var(--gold2),var(--gold));
                                    width:${Math.min(p.total_points/100,100)}%;"></div>
                    </div>
                </td>
            </tr>
        `).join('');

        // Stats par groupe
        const groupes = {};
        data.forEach(p => {
            if (!groupes[p.groupe]) groupes[p.groupe] = { total: 0, count: 0 };
            groupes[p.groupe].total += p.total_points;
            groupes[p.groupe].count++;
        });

        const colors = { 'First Round 1': 'var(--gold)', 'First Round 2': '#A78BFA', 'First Round 3': '#38BDF8' };
        document.getElementById('stats-groupes').innerHTML = Object.entries(groupes).map(([nom, g]) => `
            <div>
                <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px;">
                    <span style="font-weight:600;">${nom}</span>
                    <span style="color:${colors[nom] || 'var(--gold)'};">
                        Moy: ${Math.round(g.total/g.count)} pts
                    </span>
                </div>
                <div style="background:rgba(255,255,255,0.08);border-radius:50px;height:8px;">
                    <div style="height:100%;border-radius:50px;
                                background:${colors[nom] || 'var(--gold)'};
                                width:${Math.min(g.total/g.count/10,100)}%;"></div>
                </div>
            </div>
        `).join('');
    });

    // Stats globales
    fetch('../api/stats_globales.php')
    .then(r => r.json())
    .then(data => {
        document.getElementById('stat-total-reponses').textContent = data.total_reponses || 0;
        document.getElementById('stat-taux-reussite').textContent = (data.taux_reussite || 0) + '%';
        document.getElementById('stat-temps-moyen').textContent = (data.temps_moyen || 0) + 's';

        // Stats par question
        if (data.par_question) {
            document.getElementById('stats-questions-list').innerHTML = data.par_question.map((q, i) => `
                <div style="padding:10px;background:rgba(255,255,255,0.03);
                            border:1px solid var(--border);border-radius:12px;">
                    <div style="font-size:12px;font-weight:600;margin-bottom:6px;">
                        Q${i+1}. ${q.texte.substring(0,40)}...
                    </div>
                    <div style="display:flex;gap:8px;font-size:11px;color:var(--muted);">
                        <span>✅ ${q.taux}% réussite</span>
                        <span>⏱ ${q.temps_moyen}s moy.</span>
                        <span>📝 ${q.nb_reponses} rép.</span>
                    </div>
                </div>
            `).join('');
        }
    });
}



// =========================
// VARIABLES SESSION
// =========================
let sessionCourante = null;
let sessionPollingTimer = null;

// =========================
// GÉNÉRER UN CODE
// =========================
function genererCode() {
    fetch('../api/session.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ action: 'creer' })
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) { alert('Erreur : ' + data.error); return; }

        // Réinitialiser toutes les variables
        sessionCourante      = { id: data.session_id, code: data.code };
        roundActuel          = 1;
        questionIndex        = 0;
        questionsRound       = [];
        nbParticipantsRound  = 0;
        questionsFinale      = [];
        questionFinaleIndex  = 0;

        // Réinitialiser l'UI rounds
        document.getElementById('panel-question').style.display   = 'none';
        document.getElementById('panel-stats-q').style.display    = 'none';
        document.getElementById('btn-demarrer').style.display     = 'flex';
        document.getElementById('btn-demarrer').disabled          = false;
        document.getElementById('btn-demarrer').style.opacity     = '1';
        document.getElementById('btn-demarrer').innerHTML         = '➤ &nbsp;Démarrer le Round';
        document.getElementById('round-badge').textContent        = '⏳ En attente';
        document.getElementById('round-badge').style.color        = 'var(--gold)';
        document.getElementById('q-progression').textContent      = '0 / 10';
        document.getElementById('progress-bar').style.width       = '0%';
        document.getElementById('nb-reponses').textContent        = '0';
        document.getElementById('progress-reponses').style.width  = '0%';

        // Réinitialiser top 3
        document.getElementById('top3-list').innerHTML = `
            <div style="text-align:center;padding:20px;">
                <img src="../assets/img/trophy.png"
                     style="width:200px;height:auto;object-fit:contain;display:block;
                            margin:0 auto 8px auto;
                            filter:drop-shadow(0 0 15px rgba(245,166,35,0.4));
                            animation:trophyFloat 3s ease-in-out infinite;">
                <div style="font-size:13px;color:var(--muted);">En attente...</div>
            </div>`;

        // Réinitialiser finalistes
        [1,2,3].forEach(n => {
            document.getElementById('finaliste-' + n + '-nom').textContent = '—';
            document.getElementById('finaliste-' + n + '-pts').textContent = '0 pts';
        });

        // Réinitialiser scores finale
        document.getElementById('scores-finale').innerHTML = `
            <div style="text-align:center;padding:30px;">
                <div style="font-size:40px;margin-bottom:10px;">🏆</div>
                <div style="color:var(--muted);">En attente...</div>
            </div>`;

        // Afficher le code
        const c = data.code;
        document.getElementById('session-code-display').textContent =
            c.slice(0,3) + ' ' + c.slice(3);

        document.getElementById('session-nb-wrap').style.display  = 'block';
        document.getElementById('btn-demarrer-session').style.display = 'flex';
        document.getElementById('session-live-badge').style.display   = 'flex';
        document.getElementById('session-msg').innerHTML =
            '<span style="color:var(--green);">✅ Code généré ! Les participants peuvent rejoindre.</span>';

        // Redémarrer polling participants
        if (sessionPollingTimer) clearInterval(sessionPollingTimer);
        sessionPollingTimer = setInterval(actualiserParticipants, 2000);
        actualiserParticipants();
    })
    .catch(() => alert('Erreur réseau'));
}

// =========================
// ACTUALISER PARTICIPANTS LIVE
// =========================
function actualiserParticipants() {
    if (!sessionCourante) return;

    fetch('../api/session.php?action=participants_session&session_id=' + sessionCourante.id)
    .then(r => r.json())
    .then(participants => {
        document.getElementById('session-nb-participants').textContent = participants.length;

        const colors = ['#4F46E5','#7C3AED','#059669','#DC2626','#D97706','#0891B2','#DB2777','#0284C7'];

        if (participants.length === 0) {
            document.getElementById('session-participants-list').innerHTML =
                `<div style="text-align:center;padding:40px;color:var(--muted);">
                    <div style="font-size:30px;margin-bottom:8px;">⏳</div>
                    <div style="font-size:13px;">En attente des participants...</div>
                </div>`;
            return;
        }

        document.getElementById('session-participants-list').innerHTML =
            participants.map((p, i) => {
                const initiale = p.nom.charAt(0).toUpperCase();
                const couleur = colors[i % colors.length];
                const heure = p.created_at
                    ? new Date(p.created_at).toLocaleTimeString('fr-FR', {hour:'2-digit', minute:'2-digit'})
                    : '';
                return `
                <div style="display:flex;align-items:center;gap:12px;
                            padding:10px 14px;border-radius:14px;
                            background:rgba(255,255,255,0.04);
                            border:1px solid rgba(255,255,255,0.06);">
                    <div style="width:36px;height:36px;border-radius:50%;flex-shrink:0;
                                background:${couleur};color:#fff;
                                display:flex;align-items:center;justify-content:center;
                                font-weight:800;font-size:13px;">
                        ${initiale}
                    </div>
                    <span style="font-size:14px;font-weight:600;flex:1;">${p.nom}</span>
                    <span style="font-size:11px;color:var(--muted);">${heure}</span>
                </div>`;
            }).join('');
    });
}

// =========================
// DÉMARRER LA SESSION
// =========================
function demarrerSession() {
    if (!sessionCourante) { alert('Générez d\'abord un code !'); return; }
    if (!confirm('Démarrer la session ? Les participants ne pourront plus rejoindre.')) return;

    fetch('../api/session.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ action: 'demarrer_session', session_id: sessionCourante.id })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            clearInterval(sessionPollingTimer);
            document.getElementById('btn-demarrer-session').style.display = 'none';
            document.getElementById('session-msg').innerHTML =
                '<span style="color:var(--green);">🚀 Session démarrée ! Passez à l\'onglet Participants.</span>';

            // Activer le bouton tirage
            const btnTirage = document.getElementById('btn-tirage');
            if (btnTirage) {
                btnTirage.disabled = false;
                btnTirage.style.opacity = '1';
                btnTirage.style.cursor = 'pointer';
            }

            setTimeout(() => {
                showSection('participants', document.querySelector('[onclick*=participants]'));
            }, 1500);
        }
    });
}


// =========================
// STOP CHRONO
// =========================
function stopChrono() {
    clearInterval(chronoInterval);
    chronoInterval = null;
    chronoEnCours = false;
    document.getElementById('btn-stop-chrono').style.display = 'none';
    document.getElementById('btn-afficher-stats').style.display = 'block';
    document.getElementById('btn-suivante').style.display = 'block';
}

// =========================
// AFFICHER STATS
// =========================
function afficherStats() {
    const q = questionsRound[questionIndex];
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'stats_question', question_id: q.id })
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('panel-stats-q').style.display = 'block';
        document.getElementById('bonne-rep-display').textContent = 'Choix ' + data.bonne_reponse;
        const couleurs = ['#4F46E5','#00FF88','#FF4B4B','#F5A623'];
        document.getElementById('stats-choix').innerHTML = (data.repartition || []).map((r, i) => `
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="width:60px;font-size:12px;color:var(--muted);">Choix ${r.reponse}</span>
                <div style="flex:1;background:rgba(255,255,255,0.06);border-radius:50px;height:8px;">
                    <div style="height:100%;border-radius:50px;width:${Math.min(r.nb * 10, 100)}%;
                                background:${couleurs[i % couleurs.length]};"></div>
                </div>
                <span style="font-size:12px;font-weight:700;">${r.nb}</span>
            </div>
        `).join('');
    });
}

// =========================
// QUESTION SUIVANTE
// =========================
function questionSuivante() {
    fetch('../api/session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'suivante' })
    })
    .then(r => r.json())
    .then(data => {
        if (data.termine) {
            finRound();
        } else {
            questionIndex++;
            afficherQuestion();
        }
    });
}




// =========================
// POLLING RÉPONSES
// =========================
function startPollingReponses(questionId) {
    if (window.pollingReponsesTimer) clearInterval(window.pollingReponsesTimer);
    
    const sessionId = sessionCourante ? sessionCourante.id : '';
    
    console.log('sessionCourante:', sessionCourante); // DEBUG
    console.log('sessionId:', sessionId);             // DEBUG
    console.log('roundActuel:', roundActuel);         // DEBUG

    window.pollingReponsesTimer = setInterval(() => {
        fetch(`../api/participant.php?action=count_reponses&question_id=${questionId}&groupe_id=${roundActuel}&session_id=${sessionId}`)
        .then(r => r.json())
        .then(data => {
            console.log('reponses count:', data); // DEBUG
            const nb = data.count || 0;
            document.getElementById('nb-reponses').textContent = nb;
            const pct = nbParticipantsRound > 0 ? Math.min(nb / nbParticipantsRound * 100, 100) : 0;
            document.getElementById('progress-reponses').style.width = pct + '%';
        });
    }, 2000);
}
// =========================
// FIN DU ROUND (VERSION UNIQUE)
// =========================
function finRound() {
    console.log('🏁 finRound() appelée - Round', roundActuel);
    
    document.getElementById('panel-question').style.display = 'none';
    document.getElementById('round-badge').textContent = '✅ Terminé';
    document.getElementById('round-badge').style.color = 'var(--green)';
    document.getElementById('btn-demarrer').disabled = true;
    document.getElementById('btn-demarrer').style.opacity = '0.5';
    document.getElementById('btn-demarrer').innerHTML = '✅ &nbsp;Round terminé';

    // Charger le top 3 du round avec filtre session + groupe
    const sessionId = sessionCourante ? sessionCourante.id : '';
    console.log('Session ID utilisé:', sessionId);

    fetch(`../api/classement.php?groupe_id=${roundActuel}&session_id=${sessionId}`)
    .then(r => r.json())
    .then(data => {
        console.log('📊 Données classement reçues:', data);
        
        if (!Array.isArray(data) || data.length === 0) {
            console.log('❌ Aucune donnée de classement');
            document.getElementById('top3-list').innerHTML = `
                <div style="text-align:center;padding:20px;color:var(--muted);">
                    Aucun score disponible.
                </div>`;
            return;
        }

        // Afficher chaque participant dans la console
        data.forEach((p, i) => {
            console.log(`#${i+1}: ${p.nom} - ${p.total_points} pts`);
        });

        // === DÉTECTION EX-AEQUO ===
        const premier = data[0];
        const deuxieme = data[1];
        
        console.log('Premier:', premier);
        console.log('Deuxième:', deuxieme);
        
        if (premier && deuxieme) {
            console.log(`🔍 Comparaison: ${premier.total_points} === ${deuxieme.total_points} ?`);
            
            if (premier.total_points === deuxieme.total_points) {
    console.log('⚠️⚠️⚠️ EX-AEQUO DÉTECTÉ ! ⚠️⚠️⚠️');
    
    // Stocker les infos pour le départage
    window.exaequoRound = {
        round: roundActuel,
        participant1: premier,
        participant2: deuxieme
    };
    
    // Lancer automatiquement le départage
    lancerQuestionDepartage(premier, deuxieme);
} else {
                console.log('✅ Pas d\'ex-aequo');
            }
        } else {
            console.log('❌ Pas assez de participants pour comparer (moins de 2)');
        }

        // === AFFICHAGE TOP 3 ===
        const medals  = ['🥇', '🥈', '🥉'];
        const couleurs = ['var(--gold)', '#A78BFA', '#38BDF8'];

        document.getElementById('top3-list').innerHTML = data.slice(0, 3).map((p, i) => `
            <div style="display:flex;align-items:center;gap:12px;
                        padding:14px;border-radius:16px;
                        background:rgba(245,166,35,0.05);
                        border:1px solid rgba(245,166,35,0.15);
                        margin-bottom:8px;">
                <span style="font-size:22px;">${medals[i]}</span>
                <div style="flex:1;">
                    <div style="font-weight:800;font-size:14px;">${p.nom}</div>
                    <div style="font-size:11px;color:var(--muted);">First Round ${roundActuel}</div>
                </div>
                <div style="font-weight:900;color:${couleurs[i]};font-size:16px;">
                    ${p.total_points} pts
                </div>
            </div>
        `).join('');

        // Mettre à jour les finalistes
        if (data[0]) {
            document.getElementById('finaliste-' + roundActuel + '-nom').textContent = data[0].nom;
            document.getElementById('finaliste-' + roundActuel + '-pts').textContent = data[0].total_points + ' pts';
            console.log('✅ Finaliste mis à jour:', data[0].nom);
        }
    })
    .catch(error => {
        console.error('❌ Erreur lors du chargement du classement:', error);
    });
}

function chargerTop3() {
    const sessionId = sessionCourante ? sessionCourante.id : '';

    fetch(`../api/classement.php?groupe_id=${roundActuel}&session_id=${sessionId}`)
    .then(r => r.json())
    .then(data => {
        if (!Array.isArray(data) || data.length === 0) {
            document.getElementById('top3-list').innerHTML = `
                <div style="text-align:center;padding:20px;color:var(--muted);">
                    <div style="font-size:40px;margin-bottom:8px;">⏳</div>
                    <div>En attente des réponses...</div>
                </div>`;
            return;
        }

        const medals  = ['🥇', '🥈', '🥉'];
        const couleurs = ['var(--gold)', '#A78BFA', '#38BDF8'];

        // Prendre jusqu'à 3, même s'il y en a moins
        const top = data.slice(0, 3);

        document.getElementById('top3-list').innerHTML = top.map((p, i) => `
            <div style="display:flex;align-items:center;gap:12px;
                        padding:14px;border-radius:16px;
                        background:rgba(245,166,35,0.05);
                        border:1px solid rgba(245,166,35,0.15);
                        margin-bottom:8px;transition:.3s;">
                <span style="font-size:24px;">${medals[i]}</span>
                <div style="flex:1;">
                    <div style="font-weight:800;font-size:14px;">${p.nom}</div>
                    <div style="font-size:11px;color:var(--muted);">First Round ${roundActuel}</div>
                </div>
                <div style="font-weight:900;color:${couleurs[i]};font-size:16px;">
                    ${p.total_points} pts
                </div>
            </div>
        `).join('');
    });
}
</script>

</body>
</html>

