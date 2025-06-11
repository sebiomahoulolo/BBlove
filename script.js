document.addEventListener('DOMContentLoaded', () => {

    // ===== GESTION GLOBALE =====
    const canvas = document.getElementById('romantic-bg');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let particles = {
        ascendingHearts: [],
        nebulaHearts: [],
        vortexHearts: [],
        confettiHearts: []
    };
    
    let isMouseDown = false;
    let mouse = { x: 0, y: 0 };

    // ===== 1. ANIMATION D'ENTRÉE (Inchangée) =====
    gsap.from(".logo span", { duration: 1.5, opacity: 0, y: 30, scale: 0.5, ease: "elastic.out(1, 0.5)", stagger: 0.1, delay: 0.5 });
    
    // ===== 2. INITIALISATION DES CARROUSELS (Inchangée) =====
    new Swiper('.profile-swiper', { effect: 'coverflow', grabCursor: true, centeredSlides: true, slidesPerView: 'auto', loop: true, coverflowEffect: { rotate: 30, stretch: 0, depth: 200, modifier: 1, slideShadows: true }, autoplay: { delay: 3500, disableOnInteraction: false } });
    new Swiper('.event-swiper', { effect: 'fade', loop: true, autoplay: { delay: 4000, disableOnInteraction: false }, pagination: { el: '.swiper-pagination', clickable: true } });
    new Swiper('.testimony-swiper', { effect: 'cards', grabCursor: true, loop: true, autoplay: { delay: 5000, disableOnInteraction: false } });


    // ===== 3. CLASSES DE PARTICULES (MULTI-EFFETS) =====

    // --- Cœurs ascendants (comme avant) ---
    class AscendingHeart {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height + canvas.height;
            this.size = Math.random() * 20 + 10;
            this.speedY = Math.random() * 1 + 0.5;
            this.opacity = Math.random() * 0.7 + 0.1;
            this.color = Math.random() > 0.3 ? 'rgba(231, 76, 60, 0.8)' : 'rgba(255, 255, 255, 0.8)';
        }
        update() {
            this.y -= this.speedY;
            if (this.y < -this.size) {
                this.y = canvas.height + this.size;
                this.x = Math.random() * canvas.width;
            }
        }
        draw() { drawHeart(this.x, this.y, this.size, this.color, this.opacity); }
    }

    // --- NOUVEAU : Cœurs de la nébuleuse (pulsants) ---
    class NebulaHeart {
        constructor() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 8 + 2;
            this.initialOpacity = Math.random() * 0.2 + 0.1;
            this.opacity = this.initialOpacity;
            this.color = 'rgba(231, 76, 60, 0.5)';
            this.pulseSpeed = Math.random() * 0.04;
        }
        update() {
            // Fait pulser l'opacité
            this.opacity = this.initialOpacity + (Math.sin(Date.now() * this.pulseSpeed) * this.initialOpacity);
        }
        draw() { drawHeart(this.x, this.y, this.size, this.color, this.opacity); }
    }
    
    // --- NOUVEAU : Cœurs du vortex (au toucher maintenu) ---
    class VortexHeart {
        constructor(x, y) {
            this.centerX = x;
            this.centerY = y;
            this.radius = Math.random() * 50 + 80;
            this.angle = Math.random() * Math.PI * 2;
            this.speed = Math.random() * 0.05 + 0.02;
            this.size = Math.random() * 10 + 2;
            this.color = Math.random() > 0.3 ? 'rgba(231, 76, 60, 1)' : 'rgba(255, 215, 0, 1)'; // Rouge & Or
            this.life = 1;
        }
        update() {
            this.angle += this.speed;
            this.radius -= 0.8;
            this.x = this.centerX + Math.cos(this.angle) * this.radius;
            this.y = this.centerY + Math.sin(this.angle) * this.radius;
            if (this.radius <= 0) this.life = 0;
        }
        draw() { drawHeart(this.x, this.y, this.size, this.color, 1); }
    }

    // --- NOUVEAU : Confettis de cœurs (au clic) ---
    class ConfettiHeart {
        constructor(x, y) {
            this.x = x;
            this.y = y;
            this.size = Math.random() * 12 + 5;
            this.speedX = Math.random() * 8 - 4;
            this.speedY = Math.random() * -10 - 5; // Propulsé vers le haut
            this.gravity = 0.2;
            this.color = `hsl(${Math.random() * 30 + 340}, 100%, 70%)`; // Nuances de rose/rouge
            this.life = 1;
            this.opacity = 1;
        }
        update() {
            this.speedY += this.gravity;
            this.x += this.speedX;
            this.y += this.speedY;
            this.opacity -= 0.01;
            if(this.opacity <= 0) this.life = 0;
        }
        draw() { drawHeart(this.x, this.y, this.size, this.color, this.opacity); }
    }

    // ===== 4. FONCTIONS DE GESTION =====

    // Fonction de dessin de cœur (réutilisable)
    function drawHeart(x, y, size, color, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;
        ctx.fillStyle = color;
        ctx.beginPath();
        const topCurveHeight = size * 0.3;
        ctx.moveTo(x, y + topCurveHeight);
        ctx.bezierCurveTo(x, y, x - size / 2, y, x - size / 2, y + topCurveHeight);
        ctx.bezierCurveTo(x - size / 2, y + (size + topCurveHeight) / 2, x, y + (size + topCurveHeight) / 2, x, y + size);
        ctx.bezierCurveTo(x, y + (size + topCurveHeight) / 2, x + size / 2, y + (size + topCurveHeight) / 2, x + size / 2, y + topCurveHeight);
        ctx.bezierCurveTo(x + size / 2, y, x, y, x, y + topCurveHeight);
        ctx.closePath();
        ctx.fill();
        ctx.restore();
    }
    
    // Initialisation des particules
    function init() {
        for (let i = 0; i < 40; i++) particles.ascendingHearts.push(new AscendingHeart());
        for (let i = 0; i < 60; i++) particles.nebulaHearts.push(new NebulaHeart());
    }

    // Boucle d'animation principale
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Si le doigt est maintenu, créer le vortex
        if (isMouseDown) {
            for(let i=0; i<3; i++) particles.vortexHearts.push(new VortexHeart(mouse.x, mouse.y));
        }

        // Mettre à jour et dessiner toutes les particules
        for (const type in particles) {
            for (let i = particles[type].length - 1; i >= 0; i--) {
                const p = particles[type][i];
                p.update();
                p.draw();
                // Nettoyer les particules mortes (pour la performance)
                if (p.life === 0) {
                    particles[type].splice(i, 1);
                }
            }
        }
        
        requestAnimationFrame(animate);
    }

    // ===== 5. ÉVÉNEMENTS UTILISATEUR =====
    
    window.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });
    
    window.addEventListener('touchstart', (e) => {
        isMouseDown = true;
        mouse.x = e.touches[0].clientX;
        mouse.y = e.touches[0].clientY;
    });

    window.addEventListener('mouseup', () => { isMouseDown = false; });
    window.addEventListener('touchend', () => { isMouseDown = false; });
    
    window.addEventListener('mousemove', (e) => {
        if(isMouseDown) {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        }
    });

    window.addEventListener('touchmove', (e) => {
        if(isMouseDown) {
            mouse.x = e.touches[0].clientX;
            mouse.y = e.touches[0].clientY;
        }
    });
    
    // Pour l'explosion de confettis au clic
    window.addEventListener('click', (e) => {
        for(let i=0; i < 30; i++) {
             particles.confettiHearts.push(new ConfettiHeart(e.clientX, e.clientY));
        }
    });

    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        // Réinitialiser les particules statiques
        particles.ascendingHearts = [];
        particles.nebulaHearts = [];
        init();
    });

    // Lancement
    init();
    animate();
});