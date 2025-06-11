<?php include 'navbar.php'; ?>

<style>
.image-reduite {
    width: 100%;
    max-width: 500px;
    height: auto;
    display: block;
    margin: auto;
}

.valeurs-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
}

.card-valeur {
    background-color: #fff;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    max-width: 300px;
    width: 100%;
    text-align: center;
}
</style>

<div class="container py-5">

    <!-- Mission Section -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">
                <h2>Notre mission</h2>
                <p>
                    BBLove, une filiale de FHC GROUPE SARL est une plateforme de rencontre en ligne conçue pour connecter les 
                    cœurs sincères.<br>
                    Nous croyons que chaque rencontre a le potentiel de devenir une belle histoire, qu'elle soit amoureuse, amicale ou simplement humaine.<br>
                    Notre mission est d’offrir un espace bienveillant, sécurisé et inclusif à tous ceux qui souhaitent faire une vraie rencontre.
                </p>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <img src="images/mission.jpeg" alt="Notre mission BBLove" class="img-fluid image-reduite">
        </div>
    </div>

    <!-- Valeurs Section -->
    <div class="valeurs-section text-center">
        <h2 style="font-size: 2rem; color: #FF5A5F; font-weight: bold;">Nos valeurs</h2>
        <div class="valeurs-cards">
            <div class="card-valeur">
                <h4>Sincérité</h4>
                <p>Encourager des profils authentiques et vérifiés.</p>
            </div>
            <div class="card-valeur">
                <h4>Sécurité</h4>
                <p>Protéger les données et l’intimité de nos membres.</p>
            </div>
            <div class="card-valeur">
                <h4>Respect</h4>
                <p>Promouvoir des interactions positives et respectueuses.</p>
            </div>
            <div class="card-valeur">
                <h4>Diversité</h4>
                <p>Valoriser les différences culturelles et personnelles.</p>
            </div>
        </div>
    </div>

    <!-- Plateforme Section -->
    <div class="row align-items-center mt-5">
        <div class="col-lg-6 text-center mb-4 mb-lg-0">
            <img src="images/logo1.png" alt="Rencontre pour tous" class="img-fluid image-reduite">
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">
                <h2 style="font-size: 2rem; color: #FF5A5F; font-weight: bold; text-align: center;">Une plateforme adaptée à tous</h2>
                <p>
                    Que vous soyez jeune actif, parent célibataire, senior ou simplement curieux de nouvelles rencontres,
                    BBLove s’adresse à tous les profils. Notre algorithme intelligent vous propose des partenaires
                    compatibles en fonction de vos intérêts, de votre personnalité et de votre localisation.
                </p>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'foooter.php'; ?>
