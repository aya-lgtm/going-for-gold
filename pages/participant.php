
<?php
// Pas de session PHP nécessaire — données lues depuis localStorage côté JS
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Going For Gold — Participant</title>
<link rel="stylesheet" href="../assets/css/style-participant.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="../assets/img/favicon.png">

</head>
<body>

<!-- ===================== TOPBAR ===================== -->
<div class="topbar">
    <div class="topbar-logo">
        <img src="../assets/img/logo.png" alt="Logo" onerror="this.style.display='none'">
        <div class="topbar-title">Going For <span>Gold</span></div>
    </div>

    <div id="topbar-right">
        <button class="theme-btn" onclick="toggleTheme()" id="themeBtn">🌙</button>
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
function toggleTheme(){

document.body.classList.toggle('light');

const isLight = document.body.classList.contains('light');

document.getElementById('themeBtn').innerText =
isLight ? '☀️' : '🌙';

localStorage.setItem('theme',
isLight ? 'light' : 'dark');

}

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
    canAnswer: false,
    tempsDebut:       null,
    pollingTimer:     null,
    questionIndex:    0,
    totalQuestions:   10,
    chronoEnCours: false,
    chronoInterval:   null,
    phase: 'attente',
    chronoDejaFait: false,
    pollingType: null  // 🔥 AJOUT : pour savoir quel polling est actif
};


function arreterTousPollings() {
    if (state.pollingTimer) {
        clearInterval(state.pollingTimer);
        state.pollingTimer = null;
    }
    if (state.chronoInterval) {
        clearInterval(state.chronoInterval);
        state.chronoInterval = null;
    }
    state.pollingType = null;
    state.chronoEnCours = false;
}


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
    demarrerPollingSession(); // 🔥 UN SEUL APPEL
}


async function demarrerPollingSession() {
    arreterTousPollings();
    

    const poll = async () => {
        try {
            const resDep = await fetch('../api/session.php?action=statut');
        const dataDep = await resDep.json();

        if (dataDep.round === 'departage' && dataDep.actif === true) {
    const resQ = await fetch('../api/session.php?action=question_actuelle');
    const dataQ = await resQ.json();
    if (dataQ.question && dataQ.question.id !== state.questionActuelle?.id) {
        arreterTousPollings();
        chargerQuestion(dataQ.question, dataQ.numero, dataQ.total, 'departage');
    }
    return; 
}
            const res = await fetch(
                `../api/participant.php?action=status&participant_id=${state.participantId}&update_activity=1`
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
                    arreterTousPollings();
                    chargerQuestion(
                        data.question,
                        data.question_index,
                        data.total_questions,
                        data.round
                    );
                } 
            }
            
            // 🔥 NOUVEAU : Détecter le départage même en phase attente
            if (data.session_phase === 'attente') {
                try {
                    const resDep = await fetch('../api/session.php?action=statut');
                    const dataDep = await resDep.json();
                    
                    if (dataDep.round === 'departage' && dataDep.actif === true) {
                    console.log('✅ DÉPARTAGE DÉTECTÉ - chargement direct');
                    clearInterval(state.pollingTimer);
                    state.pollingTimer = null;
                    state.pollingType = null;
                    
                    // Charger directement la question
                    const resQ = await fetch('../api/session.php?action=question_actuelle');
                    const dataQ = await resQ.json();
                    
                    if (dataQ.question) {
                        chargerQuestion(dataQ.question, dataQ.numero, dataQ.total, 'departage');
                    }
                    return;
                }
                } catch(e) {}
            }
        } catch(e) { /* silencieux */ }
    };

    await poll();
    state.pollingType = 'session';
    state.pollingTimer = setInterval(poll, 2000);
}


// ================================================================
// ÉCRAN 3 — QUESTION
// ================================================================
function chargerQuestion(question, index, total, round) {
    arreterTousPollings();

    state.chronoDejaFait = false;
    state.chronoEnCours = false;
    state.reponseEnvoyee = false;

     document.querySelectorAll('.choix-btn').forEach(b => {
        b.disabled = false;
        b.classList.remove('selected', 'correct', 'wrong', 'reveal-correct');
    });
    document.getElementById('reponse-msg').style.display = 'none';


    // Si on est déjà sur cette question, on ne recharge pas
  if (state.questionActuelle && state.questionActuelle.id === question.id) {
    if (round !== 'departage') {
        demarrerPollingChrono();
    }
    return;
}
    state.questionActuelle = question;
    state.reponseEnvoyee   = false;
    state.tempsDebut       = null;
    state.questionIndex    = index;
    state.totalQuestions   = total;
    state.chronoEnCours    = false;
    state.canAnswer        = false;

    // Mise à jour UI
const roundLabels = {
    'finale':    '✨ FINALE',
    'departage': '⚡ DÉPARTAGE'
};
document.getElementById('q-round-label').textContent = 
    roundLabels[round] || `FIRST ROUND ${round || ''}`;
        document.getElementById('q-badge').textContent = `Q${index} / ${total}`;
    document.getElementById('q-progress-fill').style.width = ((index / total) * 100) + '%';
    document.getElementById('q-texte').textContent = question.texte;

    const choixData = [question.choix_1, question.choix_2, question.choix_3, question.choix_4];
    document.getElementById('choix-grid').innerHTML = choixData.map((c, i) => `
        <button class="choix-btn" id="choix-${i+1}" onclick="repondre(${i+1})" disabled>
            <div class="choix-num">${i+1}</div>
            <span>${c}</span>
        </button>
    `).join('');

    // Reset visuel du chrono
    document.getElementById('chrono-num').textContent = '10';
    const arc = document.getElementById('chrono-arc');
    if (arc) arc.style.strokeDashoffset = '0';

    // Affichage écran
    showScreen('question');


    if(round === 'departage' ) {
        // 🔥 Pour le départage, démarrer le chrono immédiatement
        // sans attendre chrono_demarre du backend
        state.chronoDejaFait = true;
        demarrerChrono(10);
    } else {
        demarrerPollingChrono();
    }
    
}


// ================================================================
// CHRONO CIRCULAIRE SVG
// ================================================================
// Modifie ta fonction demarrerChrono comme ceci :
function demarrerChrono(duree) {
    if (state.chronoEnCours) {
        console.log("⚠️ Chrono déjà en cours, ignore");
        return;
    }
    if (state.chronoInterval) clearInterval(state.chronoInterval);

    console.log("✅ Lancement réel du chrono");
    state.chronoEnCours = true;
    activerReponses();

    const arc   = document.getElementById('chrono-arc');
    const numEl = document.getElementById('chrono-num');
    const circonference = 251;

    let restant = duree;
    state.tempsDebut = Date.now();

    const update = () => {
        numEl.textContent = restant;
        const ratio = restant / duree;
        arc.style.strokeDashoffset = circonference * (1 - ratio);

        if (restant <= 0) {
            clearInterval(state.chronoInterval);
            state.chronoInterval = null;
            state.chronoEnCours = false; 
            bloquerReponses();
            demarrerPollingResultat();
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
    
    }
}

function activerReponses() {
    state.canAnswer = true;
    // On retire l'attribut disabled de tous les boutons
    document.querySelectorAll('.choix-btn').forEach(btn => {
        btn.disabled = false;
    });
    
    // On cache le message d'attente
    const msg = document.getElementById('reponse-msg');
    msg.style.display = 'none';
}

// ================================================================
// RÉPONDRE À UNE QUESTION
// ================================================================
async function repondre(choix) {
    if (!state.canAnswer || state.reponseEnvoyee) return;
    if (!state.questionActuelle) return;

  state.reponseEnvoyee = true;  // 🔥 IMMÉDIATEMENT, avant tout
    state.canAnswer = false;   


    const maintenant = Date.now();
    const tempsEcoule = (maintenant - state.tempsDebut) / 1000;
    const tempsRestant = Math.max(0, 10 - tempsEcoule);


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

    // On mémorise l'id de la question pour laquelle on attend le résultat
    const questionIdAttendue = state.questionActuelle?.id;

    const poll = async () => {
        try {

        const resDep = await fetch('../api/session.php?action=statut');
        const dataDep = await resDep.json();

        if (dataDep.round === 'departage' && dataDep.actif === true) {
    const resQ = await fetch('../api/session.php?action=question_actuelle');
    const dataQ = await resQ.json();
    if (dataQ.question && dataQ.question.id !== state.questionActuelle?.id) {
        arreterTousPollings();
        chargerQuestion(dataQ.question, dataQ.numero, dataQ.total, 'departage');
            return; 

    }
}
            const res = await fetch(
                `../api/participant.php?action=prochaine_question&participant_id=${state.participantId}`
            );
            const data = await res.json();

            // ⚠️ CORRECTION : on ignore chrono_demarre ici, c'est demarrerPollingChrono qui gère ça
            // On ne fait QUE surveiller les transitions de phase

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
                       data.question_id !== questionIdAttendue) {
                // Nouvelle question détectée — charger ET laisser demarrerPollingChrono gérer le chrono
                clearInterval(state.pollingTimer);
                chargerQuestion(
                    data.question,
                    data.question_index,
                    data.total_questions,
                    data.round
                );
                // chargerQuestion appelle demarrerPollingChrono — ne pas démarrer le chrono ici

            } else if (data.phase === 'attente_suivante') {
                // Déjà répondu, on attend la prochaine — continuer à poller

            } else if (data.phase === 'fin') {
                    if (data.round === 'departage') {
        clearInterval(state.pollingTimer);
        entrerSalleAttente();
        return;
    }
                if (data.round === 'finale') {
    const resCheck = await fetch(
        `../api/participant.php?action=status&participant_id=${state.participantId}`
    );
    const dataCheck = await resCheck.json();
    if (dataCheck.session_phase === 'termine') {
        clearInterval(state.pollingTimer);
        afficherFin({ ...data, session_phase: 'termine' });
    }
} 

else {
                    clearInterval(state.pollingTimer);
                    afficherFin(data);
                }
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
    document.getElementById('result-title').textContent = correct ? 'Bonne réponse !' : '   Mauvaise réponse…';
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
    const questionIdAttendue = state.questionActuelle?.id;

    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=prochaine_question&participant_id=${state.participantId}`
            );
            const data = await res.json();

            if (data.phase === 'question' && data.question_id !== questionIdAttendue) {
                clearInterval(state.pollingTimer);
                chargerQuestion(data.question, data.question_index, data.total_questions, data.round);

            } else if (data.phase === 'classement') {
                clearInterval(state.pollingTimer);
                afficherClassement(data.classement, data.mon_rang, data.question_index);

            } else if (data.phase === 'fin') {
                if (data.round === 'finale') {
    const resCheck = await fetch(
        `../api/participant.php?action=status&participant_id=${state.participantId}`
    );
    const dataCheck = await resCheck.json();
    if (dataCheck.session_phase === 'termine') {
        clearInterval(state.pollingTimer);
        afficherFin({ ...data, session_phase: 'termine' });
    }
}else {                          // ← AJOUT : rounds non-finale
                    clearInterval(state.pollingTimer);
                    afficherFin(data);
                }                                 // ← ferme if/else(finale)
            }                                     // ← ferme else if(fin)
            // phase === 'attente_suivante' → continuer à poller

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

    if (estFinale && parseInt(rang)=== 1) {
        // 🏆 Champion
        document.getElementById('fin-emoji').textContent  = '🏆';
        document.getElementById('fin-label').textContent  = '🎉 CHAMPION GOING FOR GOLD';
        document.getElementById('fin-title').textContent  = 'Félicitations !';
        document.getElementById('fin-msg').textContent    =
            'Vous êtes le Grand Champion de la compétition Going For Gold !';

    } else if (estFinale && parseInt(rang)=== 2) {
        // 🥈 2ème
        document.getElementById('fin-emoji').textContent  = '🥈';
        document.getElementById('fin-label').textContent  = 'FINALE TERMINÉE';
        document.getElementById('fin-title').textContent  = 'Superbe performance !';
        document.getElementById('fin-msg').textContent    = 'Vous terminez à la 2ème place de la compétition.';

    } else if (estFinale && parseInt(rang)=== 3) {
        // 🥉 3ème
        document.getElementById('fin-emoji').textContent  = '🥉';
        document.getElementById('fin-label').textContent  = 'FINALE TERMINÉE';
        document.getElementById('fin-title').textContent  = 'Bien joué !';
        document.getElementById('fin-msg').textContent    = 'Vous terminez à la 3ème place de la compétition.';

    } else if (qualifie && !estFinale && data.session_phase !== 'termine' ) {
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
    if (qualifie && !estFinale && data.session_phase !== 'termine') {
        demarrerPollingFinale();
    }
}
// ================================================================
// POLLING FINALE — attendre le démarrage de la finale
// ================================================================
function demarrerPollingFinale() {
    if (state.pollingTimer) clearInterval(state.pollingTimer);
    
    arreterTousPollings();

    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=status&participant_id=${state.participantId}`
            );
            const data = await res.json();
            
            console.log('🔍 Polling finale - data:', data); // DEBUG

            // Si une question est disponible (finale ou départage)
            if (data.session_phase === 'en_cours' && data.question) {
                const nouvelleQuestion = !state.questionActuelle ||
                    state.questionActuelle.id !== data.question.id;

                if (nouvelleQuestion) {
                    console.log('🆕 Nouvelle question détectée !');
                    arreterTousPollings();
                    chargerQuestion(
                        data.question,
                        data.question_index,
                        data.total_questions,
                        data.round
                    );
                }
                return;
            }
            
            // Si phase attente, continuer à poller (le départage peut arriver)
            if (data.session_phase === 'attente') {
    try {
        const resDep = await fetch('../api/session.php?action=statut');
        const dataDep = await resDep.json();

        // Départage en cours
        if (dataDep.round === 'departage' && dataDep.actif === true) {
            const resQ = await fetch('../api/session.php?action=question_actuelle');
            const dataQ = await resQ.json();
            if (dataQ.question && dataQ.question.id !== state.questionActuelle?.id) {
                arreterTousPollings();
                chargerQuestion(dataQ.question, dataQ.numero, dataQ.total, 'departage');
            }
            return;
        }

        // 🔥 Finale terminée = session inactive ET aucun round en cours
        if (dataDep.actif === false && dataDep.round === null) {
            const resClassement = await fetch('../api/classement.php?type=finale');
            const podium = await resClassement.json();
            if (Array.isArray(podium) && podium.length > 0) {
                arreterTousPollings();
                const monRang  = podium.findIndex(p => p.id == state.participantId) + 1;
                const monScore = podium.find(p => p.id == state.participantId)?.total_points || 0;
                afficherFin({
                    round:         'finale',
                    session_phase: 'termine',
                    mon_rang:      monRang > 0 ? monRang : '—',
                    score_total:   monScore
                });
            }
        }
    } catch(e) {}
}   
            
            // Si terminé
            // Si terminé
if (data.session_phase === 'termine') {
    clearInterval(state.pollingTimer);
    try {
        const resClassement = await fetch('../api/classement.php?type=finale');
        const podium = await resClassement.json();
        const monRang  = podium.findIndex(p => p.id == state.participantId) + 1;
        const monScore = podium.find(p => p.id == state.participantId)?.total_points || 0;
        afficherFin({
            round:         'finale',
            session_phase: 'termine',
            mon_rang:      monRang > 0 ? monRang : '—',
            score_total:   monScore
        });
    } catch(e) {
        afficherFin({ ...data, round: 'finale', session_phase: 'termine' });
    }
    return;
}

        } catch(e) { }
    };

    poll();
    state.pollingType = 'finale';
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


function demarrerPollingChrono() {
    if (state.pollingType === 'chrono') return;
    
    arreterTousPollings();

    const questionIdCible = state.questionActuelle?.id;

    const poll = async () => {
        try {
            const res = await fetch(
                `../api/participant.php?action=status&participant_id=${state.participantId}`
            );
            const data = await res.json();

            if (data.session_phase === 'en_cours' && data.question) {
                if (data.question.id !== questionIdCible) {
                    arreterTousPollings();
                    chargerQuestion(data.question, data.question_index, data.total_questions, data.round);
                    return;
                }

                if (!state.questionActuelle || state.questionActuelle.id !== questionIdCible) {
                // Le polling n'a plus lieu d'être
                arreterTousPollings();
                return;
                }
                    // 🔥 Condition complète :
                // 1. Le backend dit que le chrono doit tourner
                // 2. Le chrono n'est pas déjà en cours
                // 3. Le participant n'a PAS encore répondu
                // 4. On n'a PAS déjà fait le chrono pour cette question
                if (data.chrono_demarre === true && !state.chronoEnCours && !state.reponseEnvoyee && !state.chronoDejaFait) {
                    console.log("⏰ DÉMARRAGE DU CHRONO (une seule fois)");
                    state.chronoDejaFait = true;  // ← IMPORTANT !
                    demarrerChrono(10);
                }
                else {
    console.log('⏳ En attente du chrono - chrono_demarre:', data.chrono_demarre, 
                'chronoEnCours:', state.chronoEnCours, 
                'reponseEnvoyee:', state.reponseEnvoyee,
                'chronoDejaFait:', state.chronoDejaFait);
}
            }
        } catch(e) {}
    };

    poll();
    state.pollingType = 'chrono';
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


document.addEventListener('DOMContentLoaded', async () => {
    if (!state.participantId || !state.nom) {
        window.location.href = 'index.php';
        return;
    }

    // Remplir l'UI
    document.getElementById('waiting-avatar').textContent =
        state.nom.charAt(0).toUpperCase();
    document.getElementById('waiting-name-display').textContent = state.nom;
    document.getElementById('attente-groupe').textContent =
        state.groupe ? state.groupe.replace('First Round ', 'G') : '—';
    document.getElementById('live-badge').style.display = 'flex';
    document.getElementById('badge-nom').textContent = state.nom;

    // Vérifier l'état actuel
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
            entrerSalleAttente(); // 🔥 UN SEUL APPEL
        }
    } catch(e) {
        entrerSalleAttente();
    }
});
</script>

</body>
</html>