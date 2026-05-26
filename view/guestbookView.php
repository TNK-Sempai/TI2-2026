<?php
# view/guestbookView.php
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TI2 | Livre d'or</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@300;400;500&family=Instrument+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


</head>
<body>
   <div id="cur"></div>
    <div id="cur-ring"></div>

    <nav id="nav">
        <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/index.html" class="nav-logo">TANUKI</a>
        <div class="nav-links">
            <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/about.html" data-n="01" data-page="about.html">À propos</a>
            <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/projects.html" data-n="02" data-page="projects.html">Projets</a>
            <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/skills.html" data-n="03" data-page="skills.html">Skills</a>
        </div>
        <a href="mailto:thecurioustanuki@gmail.com" class="nav-cta">Disponible →</a>
        <button class="nav-burger" id="navBurger" aria-label="Menu"><span></span><span></span><span></span></button>
    </nav>
    <div class="nav-mobile" id="navMobile">
        <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/index.html" data-page="index.html">Accueil</a>
        <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/about.html" data-page="about.html">À propos</a>
        <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/projects.html" data-page="projects.html">Projets</a>
        <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/skills.html" data-page="skills.html">Skills</a>
        <a href="mailto:thecurioustanuki@gmail.com" class="nav-mobile-cta">Disponible →</a>
    </div>

    <section class="gb-hero">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="gb-hero-content">
            <div class="label reveal"><span class="label-n">26.05.2026 /</span> TI2 — Livre d'or</div>
            <h1 class="section-h reveal">Livre<em> d'or</em></h1>
            <p class="gb-subtitle reveal">Laissez un message, partagez votre avis — chaque mot compte.</p>
        </div>
    </section>

    <section class="gb-form-section">
        <div class="gb-form-grid">

            <div class="gb-illus-col reveal">
                <div class="gb-illus-box">
                    <img class="gb-illus" src="img/6171410.png" alt="Illustration inscription">
                    <div class="corner c-tl"></div>
                    <div class="corner c-tr"></div>
                    <div class="corner c-bl"></div>
                    <div class="corner c-br"></div>
                </div>
            </div>

            <div class="gb-form-col">
                <div class="label reveal"><span class="label-n">01 /</span> Nouveau message</div>
                <h2 class="section-h reveal" style="font-size:2.2rem;margin-bottom:2rem">Laissez-nous<em> un mot.</em></h2>

                <?php if ($successMessage): ?>
                    <div class="msg msg--success reveal" id="js-feedback">
                        <span class="msg-icon">✓</span> Votre message a bien été enregistré.
                    </div>
                <?php endif; ?>

                <?php if ($errorMessage): ?>
                    <div class="msg msg--error reveal" id="js-feedback">
                        <span class="msg-icon">✗</span> Une erreur est survenue. Vérifiez vos données.
                    </div>
                <?php endif; ?>

                <div id="js-errors" class="msg msg--error" style="display:none;"></div>

                <form id="guestbook-form" method="POST" action="" class="reveal">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstname">Prénom *</label>
                            <input type="text" id="firstname" name="firstname" maxlength="100" required placeholder="Votre prénom">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Nom *</label>
                            <input type="text" id="lastname" name="lastname" maxlength="100" required placeholder="Votre nom">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="usermail">E-mail *</label>
                            <input type="email" id="usermail" name="usermail" maxlength="200" required placeholder="prenom.nom@mail.com">
                        </div>
                    </div>

                    <div class="form-row form-row--half">
                        <div class="form-group">
                            <label for="postcode">C.postal *</label>
                            <input type="text" id="postcode" name="postcode" maxlength="4" required placeholder="1000">
                        </div>
                        <div class="form-group">
                            <label for="phone">Portable *</label>
                            <input type="tel" id="phone" name="phone" maxlength="10" required placeholder="0498150882">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="5" maxlength="300" required placeholder="Votre message..."></textarea>
                    </div>

                    <div class="form-footer">
                        <p class="char-counter"><span id="char-count">0</span> / 300 caractères</p>
                        <button type="submit" class="btn-submit">Envoyer <span class="btn-arrow">→</span></button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <section class="gb-messages-section">
        <div class="label reveal"><span class="label-n">02 /</span> Messages</div>
        <h2 class="section-h reveal">Les messages<em> précédents.</em></h2>

        <?php if ($nbEntries === 0): ?>
            <p class="gb-msg-count reveal">Pas encore de message</p>
        <?php elseif ($nbEntries === 1): ?>
            <p class="gb-msg-count reveal">Il y a 1 message</p>
        <?php else: ?>
            <p class="gb-msg-count reveal">Il y a actuellement <?= $nbEntries ?> messages</p>
        <?php endif; ?>

        <?php if (!empty($entries)): ?>
            <div class="gb-messages-grid">
                <?php foreach ($entries as $i => $entry): ?>
                    <div class="gb-message-card reveal">
                        <div class="gb-msg-idx"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>
                        <div class="gb-msg-content">
                            <div class="gb-msg-author">
                                <?= htmlspecialchars($entry['firstname']) ?>
                                <?= htmlspecialchars($entry['lastname']) ?>
                            </div>
                            <div class="gb-msg-meta">
                                <?= htmlspecialchars($entry['usermail']) ?> —
                                <?= htmlspecialchars($entry['datemessage']) ?>
                            </div>
                            <p class="gb-msg-body"><?= htmlspecialchars($entry['message']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="gb-back">
        <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/projects.html" class="gb-back-link">← Retour aux projets</a>
    </section>

    <footer>
        <div class="f-left">
            <span class="f-logo">LASS</span>
            <span class="f-copy">&copy; <?= date("Y") ?> · Tous droits réservés</span>
        </div>
        <div class="f-right">
            <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/about.html">À propos</a>
            <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/projects.html">Projets</a>
            <a href="https://2026.webdev-cf2m.be/Stagiaires/meidhy/portefolio/portfolio/skills.html">Skills</a>
        </div>
    </footer>

    <script src="js/validation.js"></script>
    <script src="js/main.js"></script>
    <script>

    const cur = document.getElementById('cur');
    const ring = document.getElementById('cur-ring');
    let mx = 0, my = 0, rx = 0, ry = 0;
    document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });
    (function loop() {
        rx += (mx - rx) * .15;
        ry += (my - ry) * .15;
        cur.style.left  = mx + 'px';
        cur.style.top   = my + 'px';
        ring.style.left = rx + 'px';
        ring.style.top  = ry + 'px';
        requestAnimationFrame(loop);
    })();

    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 40);
    });

    const burger = document.getElementById('navBurger');
    const mobile = document.getElementById('navMobile');
    if (burger && mobile) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('open');
            mobile.classList.toggle('open');
        });
    }

    document.querySelectorAll('.nav-links a, .nav-mobile a').forEach(a => {
        if (a.dataset.page && location.pathname.includes(a.dataset.page)) a.classList.add('active');
    });

    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
    }, { threshold: .12 });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

    const barObs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.style.width = e.target.dataset.w + '%'; barObs.unobserve(e.target); } });
    }, { threshold: .3 });
    document.querySelectorAll('.bar-inner').forEach(b => barObs.observe(b));
    </script>

</body>
</html>

