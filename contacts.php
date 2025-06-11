<?php include 'navbar.php'; ?>


<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color:rgb(253, 252, 252); margin: 0; padding: 0;">
    <div style="max-width: 1100px; margin: 60px auto; padding: 40px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-wrap: wrap; gap: 30px; justify-content: space-between;">
        
        <!-- Formulaire -->
        <div style="flex: 1 1 60%; min-width: 300px;">
            <h1 style="color: #ff5a5f; margin-bottom: 10px;">Contactez-nous</h1>
            <p style="color: #666; margin-bottom: 30px;">Une question ? Un besoin ? Écrivez-nous, on vous répond avec amour 💌</p>

            <form action="traitement_contact.php" method="post">
                <div style="margin-bottom: 15px;">
                    <label for="nom" style="display: block; font-weight: bold; color: black;">Nom</label>
                    <input type="text" id="nom" name="nom" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="prenom" style="display: block; font-weight: bold; color: black;">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="email" style="display: block; font-weight: bold; color: black;">Email</label>
                    <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="message" style="display: block; font-weight: bold; color: black;">Message</label>
                    <textarea id="message" name="message" rows="6" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;"></textarea>
                </div>

                <div style="text-align: left;">
                    <button type="submit" style="background-color: #ff5a5f; color: white; border: none; padding: 12px 30px; font-size: 1rem; border-radius: 30px; cursor: pointer;">
                        <i class="fas fa-paper-plane"></i> Envoyer
                    </button>
                </div>
            </form>
        </div>

        <!-- Carte contact -->
        <div style="flex: 1 1 35%; min-width: 280px; background-color:rgb(253, 249, 249); padding: 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <h2 style="color: #ff5a5f; margin-bottom: 20px;"><i class="fas fa-address-book"></i> Contact</h2>
            <p style="margin-bottom: 15px; color: black;"><i class="fas fa-map-marker-alt" style="color: #ff5a5f; margin-right: 8px;"></i>Kindonou, Cotonou</p>
            <p style="margin-bottom: 15px;  color: black;"><i class="fas fa-phone" style="color: #ff5a5f; margin-right: 8px;"></i>+229 01 69 81 30 70</p>
            <p style=" color: black;"><i class="fas fa-envelope" style="color: #ff5a5f; margin-right: 8px;"></i>contactbblove2@gmail.com</p>
        </div>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<?php include 'foooter.php'; ?>