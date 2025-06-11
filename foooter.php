<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<!-- Animation des coeurs -->
<div class="floating-hearts"></div>

<footer class="bblove-footer">
  <div class="bblove-container">

    <!-- Bloc 1 : Logo et message -->
    <div class="footer-section brand">
      <img src="images/logooo.png" alt="BBLove Logo" class="logo">
      <p class="tagline">Rencontrez l'amour avec élégance et sécurité.</p>
      <a href="register.php" class="start-btn">Commencez l'aventure</a>
    </div>

    <!-- Bloc 2 : Navigation -->
    <div class="footer-section links">
      <h4>Navigation</h4>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="a propos.php">À propos</a></li>
        <li><a href="even.php">Événements</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="contacts.php">Contacts</a></li>
      </ul>
    </div>

    <!-- Bloc 3 : Contact -->
    <div class="footer-section contact">
      <h4>Nous contacter</h4>
      <p><i class="fas fa-map-marker-alt"></i> Kindonou, Cotonou</p>
      <p><i class="fas fa-phone"></i> +229 01 69 81 30 70</p>
      <p><i class="fas fa-envelope"></i> contactbblove2@gmail.com</p>
    </div>

    <!-- Bloc 4 : Réseaux sociaux -->
    <div class="footer-section social">
      <h4>Suivez-nous</h4>
      <div class="icons">
        <a href="https://www.facebook.com/profile.php?id=61576845142304" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://wa.me/2290169813070" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
      </div>
    </div>

    <!-- Bloc 5 : Présence -->
    <div class="footer-section presence">
      <h4>Présence dans le monde</h4>
      <div class="flags">
        <img src="img/benin.png" alt="Bénin">
        <img src="img/senegal.png" alt="Sénégal">
        <img src="img/cote-divoire.png" alt="Côte d'Ivoire">
        <img src="img/mali.png" alt="Mali">
        <img src="img/togo.png" alt="Togo">
        <img src="img/france.png" alt="France">
        <img src="img/usa.png" alt="USA">
      </div>
    </div>

    <!-- Bloc 6 : Formulaire rapide -->
    <div class="footer-section signup" id="quick-signup-container">
      <h4>Inscription rapide</h4>
      <form id="quick-signup" action="register.php" method="POST">
        <input type="text" name="prenom" placeholder="Votre prénom" required>
        <input type="email" name="email" placeholder="Votre email" required>
        <button type="submit">Je m'inscris ❤️</button>
      </form>
    </div>
  </div>

    <hr class="footer-separator" />

  <div class="bblove-bottom">
    <p id="love-counter">Déjà <strong>2 342</strong> histoires d'amour créées sur BBLove ❤️</p>
    <p>&copy; 2025 <strong>BBLove</strong>. Tous droits réservés — 
      <a href="https://fhcgroupebenin.com/" target="_blank">FHC GROUPE sarl</a>
    </p>
    <p><a href="mentions-legales.php">Mentions légales</a> | <a href="privacy_policy.php">Politique de confidentialité</a></p>
  </div>
</footer>

  <!-- Bouton WhatsApp flottant -->
<a href="https://wa.me/2290169813070" 
   class="whatsapp-btn" 
   target="_blank" 
   aria-label="Contact WhatsApp">
   <i class="fab fa-whatsapp"></i>
</a>

<style>
/* Footer général */
.bblove-footer {
  background: linear-gradient(to bottom, #fff4f6, #fde2e6);
  color: #3a3a3a;
  font-family: 'Segoe UI', sans-serif;
  padding: 60px 20px 30px;
  position: relative;
  overflow: hidden;
}

.bblove-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 30px;
  max-width: 1300px;
  margin: auto;
}

.footer-section h4 {
  color: #d7263d;
  margin-bottom: 15px;
}

.footer-section p, .footer-section ul {
  font-size: 15px;
  line-height: 1.6;
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section ul li a {
  color: #3a3a3a;
  text-decoration: none;
  display: block;
  margin-bottom: 8px;
  transition: color 0.3s;
}

.footer-section ul li a:hover {
  color: #d7263d;
}

.logo {
  width: 250px;
}

.tagline {
  margin: 10px 0;
  font-style: italic;
  text-align: justify;
}

.start-btn {
  display: inline-block;
  background: #d7263d;
  color: white;
  padding: 10px 20px;
  border-radius: 30px;
  text-decoration: none;
  transition: background 0.3s ease;
  margin-top: 10px;
}

.start-btn:hover {
  background: #b91d2c;
}

.icons i.fa-facebook-f { color: #0000ff; }
.icons i.fa-whatsapp { color: #25D366; }
.icons i.fa-linkedin-in { color: #0077b5; }
.icons i.fa-tiktok { color: #f71b1b; }

.icons a {
  font-size: 22px;
  margin-right: 15px;
  color: #3a3a3a;
  transition: transform 0.3s, color 0.3s;
}

.icons a:hover {
  color: #d7263d;
  transform: scale(1.2);
}

.presence .flags {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  padding-top: 10px;
}

.flags img {
  width: 32px;
  height: auto;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Formulaire rapide */
#quick-signup-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #fff;
  padding: 15px 20px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  width: 280px;
  z-index: 10000;
  font-family: 'Segoe UI', sans-serif;
}

#quick-signup-container h4 {
  margin: 0 0 12px 0;
  color: #f44c61;
  font-weight: 700;
  font-size: 18px;
  text-align: center;
}

#quick-signup input[type="text"],
#quick-signup input[type="email"] {
  width: 100%;
  padding: 8px 12px;
  margin-bottom: 10px;
  border: 1.5px solid #f44c61;
  border-radius: 8px;
  font-size: 15px;
  box-sizing: border-box;
  outline: none;
  transition: border-color 0.3s ease;
}

#quick-signup input[type="text"]:focus,
#quick-signup input[type="email"]:focus {
  border-color: #e53e55;
}

#quick-signup button {
  width: 100%;
  background-color: #f44c61;
  color: white;
  border: none;
  border-radius: 25px;
  padding: 10px 0;
  font-weight: 700;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

#quick-signup button:hover {
  background-color: #e53e55;
}


/* Bas de page */
.bblove-bottom {
  text-align: center;
  margin-top: 30px;
  font-size: 14px;
  z-index: 2;
  position: relative;
}

.bblove-bottom hr {
  width: 70%;
  margin: 0 auto 15px;
  border: 1px solid #fbb6c2;
}

.bblove-bottom a {
  color: #d7263d;
  text-decoration: none;
  font-weight: 500;
}

.bblove-bottom a:hover {
  text-decoration: underline;
}

/* Coeurs flottants */
.floating-hearts::before {
  content: "❤️ ❤️ 💕 💗 💖 💘";
  position: absolute;
  top: -50px;
  left: 0;
  width: 100%;
  font-size: 20px;
  animation: floatHearts 10s infinite linear;
  white-space: nowrap;
  opacity: 0.2;
  z-index: 1;
}

@media (max-width: 768px) {
  .floating-hearts::before {
    font-size: 14px;
    top: -30px;
    opacity: 0.1;
    display: none;
  }
}




@keyframes floatHearts {
  0% {
    transform: translateY(0) translateX(-100%);
  }
  100% {
    transform: translateY(100px) translateX(100%);
  }
}

/* Responsive */
@media (max-width: 600px) {
  .icons a {
    font-size: 26px;
  }
  .flags img {
    width: 28px;
  }
}

/* Sur les petits écrans, on réduit la taille */
@media (max-width: 480px) {
  .logo {
    width: 150px;
    margin: 0 auto 15px; /* Centré et un peu plus de marge en bas */
    display: block;
  }
}

/* Sur mobile, on annule le flottant et on adapte le style */
@media (max-width: 768px) {
  #quick-signup-container {
    position: static;  /* Plus flottant */
    width: 100%;
    max-width: 200px;
    margin: 20px auto 0 auto; /* Centré horizontalement */
    box-shadow: none;
    border-radius: 0;
    padding: 10px 15px;
  }
  
  /* Optionnel : réduire la taille du formulaire */
  #quick-signup-container h4 {
    font-size: 16px;
  }
}

/* Logo responsive */
.logo {
  width: 250px;
  max-width: 100%;
  height: auto;
}

@media (max-width: 480px) {
  .logo {
    width: 150px;
    display: block;
  }
}


  /* Bouton WhatsApp flottant */
  .whatsapp-btn {
    position: fixed;
    bottom: 100px;
    left: 20px;
    background-color: #25D366;
    color: white;
    border-radius: 50px;
    padding: 12px 15px;
    font-size: 32px;
    text-decoration: none;
    z-index: 9999;
    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    transition: background-color 0.3s ease;
  }

  .whatsapp-btn:hover {
    background-color: #1ebe57;
  }
</style>

<script>
// Compteur dynamique
let compteur = 2000;
setInterval(() => {
  compteur += Math.floor(Math.random() * 2); // 0 ou 1 de plus
  document.getElementById('love-counter').innerHTML = `Déjà <strong>${compteur.toLocaleString()}</strong> histoires d'amour créées sur BBLove ❤️`;
}, 5000);
</script>



<!-- Bouton flottant 💬
<div id="bb-chat-toggle">💬</div>

Boîte de chat masquée au départ 
<div id="bb-chat-box" style="display: none;">
    <div id="chat-header">💬 BBLove Chat</div>
    <div id="chat-messages"></div>
    <form id="chat-form">
        <input type="text" id="chat-input" placeholder="Écris ton message..." autocomplete="off" />
        <button type="submit">Envoyer</button>
    </form>
</div> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- <script>
$(function(){
    function chargerMessages() {
        $('#chat-messages').load('chat/afficher_messages.php');
    }

    $('#chat-form').on('submit', function(e){
        e.preventDefault();
        $.post('chat/envoyer_message.php', {message: $('#chat-input').val()}, function(){
            $('#chat-input').val('');
            chargerMessages();
        });
    });

    setInterval(chargerMessages, 2000);
    chargerMessages();
});
</script> -->


<style>
#bb-chat-toggle {
    position: fixed;
    bottom: 10px;
    left: 10px;
    background:rgb(250, 51, 58);
    color: white;
    border-radius: 50%;
    width: 70px;
    height: 70px;
    font-size: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10000;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

#bb-chat-box {
    position: fixed;
    bottom: 90px; /* au-dessus du bouton */
    left: 10px;
    width: 300px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    font-family: sans-serif;
    z-index: 9999;
}
#chat-header {
    background: #ff5a5f;
    color: #fff;
    padding: 10px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
#chat-messages {
    height: 200px;
    overflow-y: auto;
    padding: 20px;
}
#chat-form {
    display: flex;
}
#chat-input {
    flex: 1;
    padding: 8px;
    border: none;
    border-top: 1px solid #ddd;
}
#chat-form button {
    padding: 8px 12px;
    background: #ff5a5f;
    color: #fff;
    border: none;
    border-top: 1px solid #ddd;
}

.msg {
    padding: 8px;
    margin-bottom: 5px;
    border-radius: 6px;
}
.admin-msg {
    background-color:rgb(252, 228, 228);
}
.coach-msg {
    background-color:rgb(217, 231, 250);
}
.user-msg {
    background-color: #f0f0f0;
}
.system-msg {
    background-color:rgb(252, 249, 229);
}

</style>

<script>
// Toggle de la boîte de chat
document.getElementById('bb-chat-toggle').addEventListener('click', function() {
    const chatBox = document.getElementById('bb-chat-box');
    chatBox.style.display = (chatBox.style.display === 'none' || chatBox.style.display === '') ? 'block' : 'none';
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bouton flottant d'ouverture -->
<div id="chat-toggle" style="
  position: fixed;
  bottom: 20px;
  left: 20px; /* Changement ici: bouton à droite */
  background: #ff5a5f;
  color: white;
  padding: 12px 16px;
  border-radius: 50%;
  cursor: pointer;
  font-size: 20px;
  z-index: 10000;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
">
  💬
</div>

<!-- Zone de chat masquée -->
<div id="chat-widget" style="
  position: fixed;
  bottom: 80px;
  left: 20px; /* Changement ici: zone à droite */
  width: 320px;
  background: white;
  border: 1px solid #ccc;
  border-radius: 12px;
  display: none;
  flex-direction: column;
  z-index: 9999;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
">
  <div class="chat-header" style="
    background: #ff5a5f;
    color: white;
    padding: 10px;
    border-radius: 12px 12px 0 0;
    font-weight: bold;
  ">
    💬 Chat Public
  </div>

  <div id="chat-messages" style="
    height: 220px;
    overflow-y: auto;
    padding: 10px;
    font-size: 14px;
    background: #f9f9f9;
  "></div>

<form id="chat-form" style="display: flex; flex-direction: column; border-top: 1px solid #ccc; gap: 5px; 
padding: 5px;">
  <input type="text" id="chat-name" placeholder="Votre nom ou pseudo..." style="padding: 8px;" required>
  <div style="display: flex;">
    <input type="text" id="chat-input" placeholder="Écrivez un message..." style="flex: 1; padding: 8px;" required>
    <button type="submit" style="padding: 8px; background: #005fa5; color: white; border: none;">📤</button>
  </div>
</form>

</div>

<!-- Script jQuery -->

<script>
$(function(){
  $('#chat-toggle').click(function() {
    $('#chat-widget').fadeToggle();
  });

  function chargerMessages() {
    $('#chat-messages').load('chat/afficher_message.php', function(){
      $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
    });
  }

  $('#chat-form').on('submit', function(e){
    e.preventDefault();
    const message = $('#chat-input').val().trim();
    const name = $('#chat-name').val().trim();

    if (message && name) {
      $.post('chat/envoyer_message.php', { message, name }, function(response){
        console.log("Réponse serveur : ", response);
        $('#chat-input').val('');
        chargerMessages();
      });
    }
  });

  setInterval(chargerMessages, 3000);
  chargerMessages();
});


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
