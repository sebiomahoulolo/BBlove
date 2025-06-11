<?php
session_start();

// Vérification admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'db.php';

// Traitement des actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'supprimer') {
        $pdo->prepare("DELETE FROM participants WHERE id = ?")->execute([$id]);
        header("Location: ?page=participants");
        exit();
    }
    if ($_GET['action'] === 'bloquer') {
        $pdo->prepare("UPDATE participants SET bloque = 1 WHERE id = ?")->execute([$id]);
        header("Location: ?page=participants");
        exit();
    }
    if ($_GET['action'] === 'debloquer') {
        $pdo->prepare("UPDATE participants SET bloque = 0 WHERE id = ?")->execute([$id]);
        header("Location: ?page=participants");
        exit();
    }
}

// Statistiques
$totalUtilisateurs = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalAdmins = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
$inscriptionsAujourdHui = $pdo->query("SELECT COUNT(*) FROM users WHERE DATE(date_inscription) = CURDATE()")->fetchColumn();

// Liste des admins
$admins = $pdo->query("SELECT * FROM users WHERE role = 'admin'")->fetchAll();

// Liste des coachs
$coachs = $pdo->query("SELECT * FROM users WHERE role = 'coach'")->fetchAll();

// Total coachs
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'coach'");
$totalCoachs = $stmt->fetchColumn();

// Nombre d'utilisateurs connectés (par exemple, en supposant que tu as un champ 'last_activity' dans la table users)
$utilisateursConnectes = $pdo->query("SELECT * FROM users WHERE TIMESTAMPDIFF(MINUTE, last_activity, NOW()) <= 10")->fetchAll(); // actifs dans les 10 dernières minutes
$totalConnectes = count($utilisateursConnectes);

$utilisateursConnectes = $pdo->prepare("
    SELECT * FROM users 
    WHERE last_activity >= NOW() - INTERVAL 10 MINUTE
    ORDER BY last_activity DESC
");
$utilisateursConnectes->execute();
$utilisateursConnectes = $utilisateursConnectes->fetchAll(PDO::FETCH_ASSOC);

// Total utilisateurs connectés (ceux ayant une session active récemment — à adapter selon ton système de tracking)
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE last_activity >= NOW() - INTERVAL 10 MINUTE ORDER BY last_activity DESC"); // suppose que tu as une colonne `statut_connexion`
$totalConnectes = $stmt->fetchColumn();

// Inscrits aujourd'hui
$utilisateursAujourdhui = $pdo->query("SELECT * FROM users WHERE DATE(date_inscription) = CURDATE()")->fetchAll();
$totalAujourdhui = count($utilisateursAujourdhui);

// Inscriptions aujourd'hui
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE DATE(date_inscription) = CURDATE()");
$inscriptionsAujourdHui = $stmt->fetchColumn();

// Inscrits hier
$utilisateursHier = $pdo->query("SELECT * FROM users WHERE DATE(date_inscription) = CURDATE() - INTERVAL 1 DAY")->fetchAll();
$totalHier = count($utilisateursHier);

// Inscription hier
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE DATE(date_inscription) = CURDATE() - INTERVAL 1 DAY");
$inscriptionsHier = $stmt->fetchColumn();

// Inscrits cette semaine (depuis lundi)
$utilisateursSemaine = $pdo->query("SELECT * FROM users WHERE YEARWEEK(date_inscription, 1) = YEARWEEK(CURDATE(), 1)")->fetchAll();
$totalSemaine = count($utilisateursSemaine);

// Inscriptions cette semaine
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE YEARWEEK(date_inscription, 1) = YEARWEEK(CURDATE(), 1)");
$inscriptionsSemaine = $stmt->fetchColumn();

// Inscrits ce mois
$utilisateursMois = $pdo->query("SELECT * FROM users WHERE MONTH(date_inscription) = MONTH(CURDATE()) AND YEAR(date_inscription) = YEAR(CURDATE())")->fetchAll();
$totalMois = count($utilisateursMois);

// Inscriptions ce mois
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE MONTH(date_inscription) = MONTH(CURDATE()) AND YEAR(date_inscription) = YEAR(CURDATE())");
$inscriptionsMois = $stmt->fetchColumn();


// Récupérer tous les événements (standard + pays)
$evenements = $pdo->query("SELECT id, titre FROM evenements ORDER BY titre ASC")->fetchAll();
$evenementsPays = $pdo->query("SELECT id, titre FROM evenements_pays ORDER BY titre ASC")->fetchAll();
$filtreEvent = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;

// Participants standard
$stmt = $pdo->prepare("SELECT p.*, e.titre FROM participants p JOIN evenements e ON p.evenement_id = e.id WHERE p.type_event IS NULL OR p.type_event = 'standard' ORDER BY p.date_inscription DESC");
$stmt->execute();
$participantsStandard = $stmt->fetchAll();

// Participants par pays
$stmtPays = $pdo->prepare("SELECT p.*, ep.titre, ep.pays FROM participants p JOIN evenements_pays ep ON p.evenement_id = ep.id WHERE p.type_event = 'pays' ORDER BY p.date_inscription DESC");
$stmtPays->execute();
$participantsPays = $stmtPays->fetchAll();

$totalParticipants = count($participantsStandard) + count($participantsPays);
$totalPayes = 0;
foreach (array_merge($participantsStandard, $participantsPays) as $p) {
  if (!empty($p['paiement'])) $totalPayes++;
}

$utilisateurs = $pdo->query("SELECT * FROM users ORDER BY date_inscription DESC")->fetchAll();
$page = $_GET['page'] ?? '';

// Récupération des événements pour le filtre
$evenements = $pdo->query("SELECT id, titre FROM evenements ORDER BY titre ASC")->fetchAll();
$filtreEvent = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;

// Participants filtrés ou non
if ($filtreEvent > 0) {
  $stmt = $pdo->prepare("SELECT p.*, e.titre FROM participants p JOIN evenements e ON p.evenement_id = e.id WHERE p.evenement_id = ? ORDER BY p.date_inscription DESC");
  $stmt->execute([$filtreEvent]);
  $participants = $stmt->fetchAll();
} else {
  $participants = $pdo->query("SELECT p.*, e.titre FROM participants p JOIN evenements e ON p.evenement_id = e.id ORDER BY p.date_inscription DESC")->fetchAll();
}

$totalParticipants = count($participants);
$totalPayes = 0;
foreach ($participants as $p) {
  if ($p['paiement']) $totalPayes++;
}

// Récupération des utilisateurs
$utilisateurs = $pdo->query("
    SELECT users.*, profils.age, profils.ville 
    FROM users 
    LEFT JOIN profils ON profils.user_id = users.id 
    ORDER BY users.date_inscription DESC
")->fetchAll();
$page = $_GET['page'] ?? '';

// Récupérer tous les signalements
$stmt = $pdo->prepare("
  SELECT s.*, 
         u1.nom AS signalant_nom, 
         u1.identifiant AS signalant_identifiant,
         u2.nom AS cible_nom,
         u2.identifiant AS cible_identifiant
  FROM signalements s
  JOIN users u1 ON s.signalant_id = u1.id
  JOIN users u2 ON s.cible_id = u2.id
  ORDER BY s.date_signalement DESC
");
$stmt->execute();
$signalements = $stmt->fetchAll();



// Connexion PDO $pdo

$filterNom = isset($_GET['filter_nom']) ? trim($_GET['filter_nom']) : '';

$sql = "SELECT s.*, 
               signalant.nom AS signalant_nom, signalant.identifiant AS signalant_identifiant,
               cible.nom AS cible_nom, cible.identifiant AS cible_identifiant, cible.id AS cible_id
        FROM signalements s
        JOIN users signalant ON s.signalant_id = signalant.id
        JOIN users cible ON s.cible_id = cible.id
        WHERE 1=1";

$params = [];

if ($filterNom !== '') {
    $sql .= " AND cible.nom LIKE :filterNom";
    $params[':filterNom'] = "%$filterNom%";
}

$sql .= " ORDER BY s.date_signalement DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$signalements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// COMMANDES
$commandes = $pdo->query("SELECT * FROM commandes_surprise ORDER BY date_commande DESC")->fetchAll();

// Commande ajouté par l'admin
$surprises = $pdo->query("SELECT * FROM galerie_surprise ORDER BY id DESC")->fetchAll();

// Coaching rdv
if ($page === 'rdv_coaching') {
    $rdvs = $pdo->query("SELECT * FROM coaching_rdv ORDER BY date_reservation DESC")->fetchAll();
}


// Requête pour compter le nombre d'hommes et de femmes dans profils
$sql = "SELECT sexe, COUNT(*) AS total FROM profils GROUP BY sexe";
$stmt = $pdo->query($sql);
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialiser les compteurs
$totalFemmes = 0;
$totalHommes = 0;

// Parcourir les résultats
foreach ($stats as $stat) {
    if (strtolower($stat['sexe']) === 'femme') {
        $totalFemmes = (int)$stat['total'];
    } elseif (strtolower($stat['sexe']) === 'homme') {
        $totalHommes = (int)$stat['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BBLove Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background:rgb(247, 247, 249);
    }
    .sidebar {
      width: 278px;
      height: 100vh;
      position: fixed;
      background-color: #ff5a5f;
      padding: 20px;
      color: white;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 0;
      text-decoration: none;
      font-weight: bold;
    }
    .sidebar a:hover {
      background: rgba(255,255,255,0.2);
      border-radius: 8px;
    }
    .main-content {
      margin-left: 270px;
      padding: 20px;
    }
    .search {
      background: #ff5a5f;
      width: 100%;
      padding: 10px;
      display: flex;
    }

    .btn-outline {
      background-color:rgb(227, 228, 248);
    }

    .card-custom {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .table-users th, .table-users td {
      vertical-align: middle;
    }

    @media (max-width: 768px) {
   .search {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
  }

  .search form {
    width: 50%;
    margin-bottom: 10px;
  }

  .d-md-none {
    display: flex;
    justify-content: flex-end;
    
  }
  .card-custom h5 {
    font-size: 16px;
  }
  .card-custom h2 {
    font-size: 24px;
  }

    table.table th, table.table td {
      font-size: 14px;
      white-space: nowrap;
      width: 70%;
    }

    .btn {
      margin-bottom: 5px;
    }

    .btn i {
      margin-right: 4px;
    }

    td .btn {
      display: block;
      width: 70%;
    }

    h3, h4 {
      font-size: 18px;
    }

    .main-content {
    width: 100%;
    padding: 10px !important;
    margin-left: 0 !important;
    padding-left: 0 !important;
  }

  /* Menu mobile par-dessus */
#mobileSidebar {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  max-width: 350px;
  height: 80%;
  background-color:rgb(246, 246, 255);;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
  z-index: 1050; /* au-dessus du reste */
  padding: 30px;
  overflow-y: auto;
  color: #ff5a5f;
}

#mobileSidebar a{
  color:rgb(8, 8, 8);
  font-size: 1.2rem;
}

#mobileSidebar.show {
  display: block;
}

/* Empêcher le scroll en arrière-plan */
body.menu-open {
  overflow: hidden;
}
 
  }

  
  </style>
  <script>
    function confirmDelete(id) {
      if (confirm("Êtes-vous sûr de vouloir supprimer ce participant ?")) {
        window.location.href = '?page=participants&action=supprimer&id=' + id;
      }
    }
  </script>
</head>
<body>

<div id="mobileSidebar" class="sidebar">
  <h3 class="text-center mb-4">BBLove Admin</h3>
  <a href="?page=dashboard">Utilisateur</a>
  <a href="#" data-bs-toggle="collapse" data-bs-target="#blogMenu">Contenus Blog</a>
  <div id="blogMenu" class="collapse">
    <a href="blog/rupture.php"> Rupture amoureuse</a>
    <a href="blog/conseils.php"> Conseils de rencontres</a>
    <a href="blog/couple.php"> Vie de couple</a>
    <a href="blog/roman.php"> Le romantisme</a>
    <a href="blog/sexe.php"> La sexualité</a>
  </div>

  <a href="#" data-bs-toggle="collapse" data-bs-target="#eventMenu">Événements</a>
  <div id="eventMenu" class="collapse">
    <a href="even/soire.php">Soirée Célibataires</a>
    <a href="even/atelier.php">Atelier et Coaching</a>
    <a href="even/evenp.php">Evenement par pays</a>
    <a href="?page=participants">Participants</a>
  </div>

  <a href="admin_dashboard.php?page=evenements" class="nav-link">📅 Événements proposés</a>

<a href="admin_dashboard.php?page=even" class="nav-link">📅 Événements a valider</a>


  <a href="admin_dashboard.php?page=rdv_coaching" class="nav-link">📅 Rendez-vous Coaching</a>

  <a href="?page=ajouter_contenu" class="nav-link">Contenus Coeurs Brisés</a>
 
  <a href="?page=commandes">Commandes</a>

  <a href="#" data-bs-toggle="collapse" data-bs-target="#galerieMenu">Galeries Surprises</a>
  <div id="galerieMenu" class="collapse">
    <a href="?page=galerie_surprise">Ajouter une surprise</a>
    <a href="?page=voir_galerie">Voir la galerie</a>
  </div>

  <a class="nav-link <?= ($page === 'commandes_galerie') ? 'active' : '' ?>" href="admin_dashboard.php?page=commandes_galerie">
    🎁 Commandes Galerie
  </a>

  <a href="?page=abonnement">Voir les abonnements</a>


  <a href="?page=signalements">🚨 Signalements</a>

  <a href="admin/parametres.php" class="nav-link">Paramètres</a>

  <a href="logout.php">Déconnexion</a>
</div>


<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('mobileSidebar');
    sidebar.classList.toggle('show');
    document.body.classList.toggle('menu-open');
  }
</script>


<div class="main-content">   
      <div class="search m-2">
       <form method="GET" class="mb-3" style="max-width: 400px;">
        <input type="hidden" name="page" value="users"> <!-- ou coachs/articles -->
        
        <div class="input-group">
          <input type="text" name="q" placeholder="Recherche ..." class="form-control" 
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
          <button class="btn btn-outline" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
        </form>
          <!-- Bouton visible uniquement sur petits écrans -->
        <div class="d-md-none text-end bg-white">
          <button class="btn btn-outline-danger" onclick="toggleSidebar()">☰ Menu</button>
        </div>
      </div>

      <?php 
      if ($page === 'participants'): ?>
        <h2 class="mt-4" style="color: #ff5a5f;">Participants aux événements</h2>

        <div class="mb-4">
          <label for="filtreEvent" class="form-label">Filtrer par événement :</label>
          <select id="filtreEvent" class="form-select" onchange="filtrerParEvenement(this)">
            <option value="0">Tous les événements</option>
            <?php foreach ($evenements as $e): ?>
              <option value="<?php echo $e['id']; ?>" <?php echo ($filtreEvent == $e['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($e['titre']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="row g-4 my-4">
          <div class="col-md-6">
            <div class="card card-custom p-4 text-center">
              <h5>Total des participants</h5>
              <h2><?php echo $totalParticipants; ?></h2>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-custom p-4 text-center">
              <h5>Participants ayant payé</h5>
              <h2><?php echo $totalPayes; ?></h2>
            </div>
          </div>
        </div>

          <!-- Participants aux événements standards -->
          <h4 style="color: #ff5a5f;">Événements internes (soirées, ateliers)</h4>
          <div class="table-responsive card card-custom p-4">
            <table class="table table-hover">
              <thead>
              <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Événement</th>
                <th>Payé</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($participantsStandard as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= htmlspecialchars($p['prenom']) ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
                <td><?= htmlspecialchars($p['telephone']) ?></td>
                <td><?= htmlspecialchars($p['titre']) ?></td>
                <td><?= !empty($p['paiement']) ? 'Oui' : 'Non' ?></td>
                <td>
                  <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $p['id'] ?>)"><i class="fas fa-trash"></i> Supprimer</button>
                  <?php if (!empty($p['bloque'])): ?>
                    <a href="?page=participants&action=debloquer&id=<?= $p['id'] ?>" class="btn btn-sm btn-success"><i class="fas fa-unlock"></i> Débloquer</a>
                  <?php else: ?>
                    <a href="?page=participants&action=bloquer&id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary"><i class="fas fa-ban"></i> Bloquer</a>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Participants événements par pays -->
        <h4 style="color: #ff5a5f;">Événements par pays</h4>
         <div class="table-responsive card card-custom p-4">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Pays</th>
                <th>Événement</th>
                <th>Payé</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($participantsPays as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= htmlspecialchars($p['prenom']) ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
                <td><?= htmlspecialchars($p['telephone']) ?></td>
                <td><?= htmlspecialchars($p['pays']) ?></td>
                <td><?= htmlspecialchars($p['titre']) ?></td>
                <td><?= !empty($p['paiement']) ? 'Oui' : 'Non' ?></td>
                <td>
                  <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $p['id'] ?>)"><i class="fas fa-trash"></i> Supprimer</button>
                  <?php if (!empty($p['bloque'])): ?>
                    <a href="?page=participants&action=debloquer&id=<?= $p['id'] ?>" class="btn btn-sm btn-success"><i class="fas fa-unlock"></i> Débloquer</a>
                  <?php else: ?>
                    <a href="?page=participants&action=bloquer&id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary"><i class="fas fa-ban"></i> Bloquer</a>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

<?php elseif ($page === 'evenements'): ?>
  <h3 class="text-danger mb-4">📌 Événements ajoutés</h3>

  <?php
  // Récupération des événements validés
  $events = $pdo->query("SELECT * FROM evenements ORDER BY date_event DESC")->fetchAll();
  ?>

  <?php if (count($events) > 0): ?>
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-danger">
        <tr>
          <th>Titre</th>
          <th>Date</th>
          <th>Heure</th>
          <th>Lieu</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($events as $e): ?>
        <tr>
          <td><?= htmlspecialchars($e['titre']) ?></td>
          <td><?= htmlspecialchars($e['date_event']) ?></td>
          <td><?= htmlspecialchars($e['heure']) ?></td>
          <td><?= htmlspecialchars($e['lieu']) ?></td>
          <td>
            <a href="admin/modifier_even.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-primary me-2">Modifier</a>
            <a href="admin/supprimer_even.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet événement ?')">Supprimer</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">Aucun événement pour le moment.</div>
  <?php endif; ?>
</div>



<?php elseif ($page === 'even'): ?>
<div class="container mt-4">
  <h3 class="text-danger mb-4">📌 Événements à valider</h3>

  <?php
  $events = $pdo->query("SELECT * FROM even WHERE statut = 'en_attente' ORDER BY date_event DESC")->fetchAll();
  ?>

   <div class="table-responsive card card-custom p-4">
          <table class="table table-hover">
          <thead class="table-danger">
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Ville</th>
              <th>Téléphone</th>
              <th>Titre</th>
              <th>Date</th>
              <th>Heure</th>
              <th>Lieu</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
      <?php foreach ($events as $e): ?>
      <tr>
        <td><?= htmlspecialchars($e['nom']) ?></td>
        <td><?= htmlspecialchars($e['prenom']) ?></td>
        <td><?= htmlspecialchars($e['ville']) ?></td>
        <td><?= htmlspecialchars($e['telephone']) ?></td>
        <td><?= htmlspecialchars($e['titre']) ?></td>
        <td><?= htmlspecialchars($e['date_event']) ?></td>
        <td><?= htmlspecialchars($e['heure']) ?></td>
        <td><?= htmlspecialchars($e['lieu']) ?></td>
        <td>
          <?= ($e['statut'] === 'valide') 
              ? "<span class='badge bg-success'>Validé</span>" 
              : "<span class='badge bg-warning text-dark'>En attente</span>" ?>
        </td>
        <td>
          <a href="admin/valider_evenement.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-success">Valider</a>
          <a href="admin/supprimer_evenement.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Rejeter</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>



<?php elseif ($page === 'rdv_coaching'): ?>
  <div class="container mt-4">
    <h3 class="text-danger mb-4">📅 Rendez-vous Coaching</h3>

    <?php if (count($rdvs) === 0): ?>
      <div class="alert alert-info">Aucun rendez-vous pour le moment.</div>
    <?php else: ?>
      <div class="table-responsive card card-custom p-4">
          <table class="table table-hover ">
        <thead class="table-danger">
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Type de séance</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rdvs as $r): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['nom']) ?></td>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= htmlspecialchars($r['telephone']) ?></td>
            <td><?= htmlspecialchars($r['type_seance']) ?></td>
            <td><?= nl2br(htmlspecialchars($r['message'])) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($r['date_reservation'])) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>


  <?php 
      elseif ($page === 'commandes'): ?>
      <div class="container mt-4">
        <h3 class="text-danger mb-4">🎁 Commandes de surprise reçues</h3>

        <?php if (count($commandes) === 0): ?>
          <div class="alert alert-info">Aucune commande pour le moment.</div>
        <?php else: ?>
          <div class="table-responsive card card-custom p-4">
          <table class="table table-hover ">
            <thead class="table-danger">
              <tr>
                <th>#</th>
                <th>Expéditeur</th>
                <th>Destinataire</th>
                <th>Surprise</th>
                <th>Date/Heure</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($commandes as $cmd): ?>
                <tr>
                  <td><?= $cmd['id'] ?></td>
                  <td><?= htmlspecialchars($cmd['expediteur_nom']) ?><br><small><?= $cmd['expediteur_email'] ?></small></td>
                  <td><?= htmlspecialchars($cmd['destinataire_nom']) ?><br><small><?= $cmd['destinataire_tel'] ?></small></td>
                  <td><?= $cmd['type_surprise'] ?><br><small><?= nl2br($cmd['message']) ?></small></td>
                  <td><?= $cmd['date_livraison'] ?> à <?= $cmd['heure_livraison'] ?></td>
                  <td><?= $cmd['statut'] ?? 'En attente' ?></td>
                  <td>
                    <a href="admin/preparer_devis.php?id=<?= $cmd['id'] ?>" class="btn btn-sm btn-warning">Préparer un devis</a>
                    <a href="admin/envoyer_devis.php?id=<?= $cmd['id'] ?>" class="btn btn-sm btn-outline-primary">Envoyer devis</a>
                    <a href="admin/valider_commande.php?id=<?= $cmd['id'] ?>" class="btn btn-sm btn-success mt-1">Valider</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

      <?php elseif ($page === 'galerie_surprise'): ?>
        <div class="container mt-4">
          <h3 class="text-danger">🖼 Ajouter une galerie de surprise</h3>
          <form method="post" enctype="multipart/form-data" action="admin/ajouter_surprise.php" class="bg-light p-4 rounded shadow" style="max-width: 700px;">
            <div class="mb-3">
              <label class="form-label">Titre</label>
              <input type="text" name="titre" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Prix (FCFA)</label>
              <input type="number" name="prix" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Image</label>
              <input type="file" name="image" class="form-control" required>
            </div>
            <button class="btn btn-danger">✅ Ajouter à la galerie</button>
          </form>
        </div>


     <?php elseif ($page === 'voir_galerie'): ?>   
  <h4 class="mt-4" style="color:#ff5a5f;">Liste des surprises ajoutées</h4>

  <div class="table-responsive card card-custom p-4">
    <table class="table table-hover">
      <thead class="table-danger">
        <tr>
          <th>Image</th>
          <th>Titre</th>
          <th>Description</th>
          <th>Prix</th>
          <th>Date d'ajout</th>
          <th>Actions</th> <!-- ➕ Ajout de la colonne Actions -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($surprises as $surprise): ?>
          <tr>
            <td>
              <img src="<?= htmlspecialchars($surprise['image']) ?>" alt="Image" width="80" height="80" style="object-fit:cover;">
            </td>
            <td><?= htmlspecialchars($surprise['titre']) ?></td>
            <td><?= htmlspecialchars($surprise['description']) ?></td>
            <td><?= number_format($surprise['prix'], 2) ?> €</td>
            <td>
              <?= isset($surprise['date_ajout']) ? date('d/m/Y H:i', strtotime($surprise['date_ajout'])) : '—' ?>
            </td>
            <td>
              <a href="admin/modifier_surprise.php?id=<?= $surprise['id'] ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Modifier
              </a>
              <a href="admin/supprimer_surprise.php?id=<?= $surprise['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                <i class="fas fa-trash"></i> Supprimer
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>



  <?php elseif ($page === 'commandes_galerie'): ?>
  <div class="container mt-4">
    <h3 class="text-danger mb-4">🎁 Commandes effectuées depuis la galerie</h3>

    <?php
    $commandes = $pdo->query("SELECT * FROM commandes_galerie ORDER BY date_commande DESC")->fetchAll();
    ?>

    <?php if (count($commandes) === 0): ?>
      <div class="alert alert-info">Aucune commande galerie enregistrée.</div>
    <?php else: ?>
      <div class="table-responsive card card-custom p-4">
          <table class="table table-hover ">
          <thead class="table-danger">
          <tr>
            <th>#</th>
            <th>Expéditeur</th>
            <th>Destinataire</th>
            <th>Surprise</th>
            <th>Détails</th>
            <th>Date/Heure Livraison</th>
            <th>Statut</th>
            <th>Date commande</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($commandes as $c): ?>
            <tr>
              <td><?= $c['id'] ?></td>
              <td>
                <?= htmlspecialchars($c['expediteur_nom']) ?><br>
                <small><?= $c['expediteur_email'] ?><br><?= $c['expediteur_tel'] ?></small>
              </td>
              <td>
                <?= htmlspecialchars($c['destinataire_nom']) ?><br>
                <small><?= $c['destinataire_email'] ?><br><?= $c['destinataire_tel'] ?></small>
              </td>
              <td><?= htmlspecialchars($c['type_surprise']) ?></td>
              <td>
                <strong>Message :</strong><br> <?= nl2br(htmlspecialchars($c['message'])) ?><br>
                <strong>Détails :</strong><br> <?= nl2br(htmlspecialchars($c['details_commande'])) ?>
              </td>
              <td><?= $c['date_livraison'] ?> à <?= $c['heure_livraison'] ?></td>
              <td>
                <?= ($c['statut'] === 'validé') ? "<span class='badge bg-success'>Validée</span>" : "<span class='badge bg-warning text-dark'>En attente</span>" ?>
              </td>
              <td><?= date('d/m/Y H:i', strtotime($c['date_commande'])) ?></td>
            </tr> 
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

              <?php elseif ($page === 'ajouter_contenu'): ?>
                <div class="container mt-4">
                  <h3 class="text-danger">➕ Ajouter un contenu</h3>

                  <form action="admin/traitement_ajout.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                      <label for="type" class="form-label">Type de contenu *</label>
                      <select name="type" id="type" class="form-select" required onchange="toggleFields()">
                        <option value="">-- Sélectionner --</option>
                        <option value="article">📝 Article</option>
                        <option value="video">🎥 Vidéo</option>
                        <option value="seance">📘 Séance</option>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="titre" class="form-label">Titre *</label>
                      <input type="text" name="titre" id="titre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                      <label for="description" class="form-label">Description *</label>
                      <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                      <label for="image" class="form-label">Image d'illustration</label>
                      <input type="file" name="image" id="image" class="form-control" accept="image">
                      <small class="text-muted">Recommandée pour les articles ou séances.</small>
                    </div>

                    <div class="mb-3">
                      <label for="fichier" class="form-label">Fichier associé</label>
                      <input type="file" name="fichier" id="fichier" class="form-control" accept="video, audio, application/pdf">
                      <small class="text-muted">Obligatoire pour les vidéos et séances.</small>
                    </div>

                    <button class="btn btn-success">✅ Ajouter le contenu</button>
                  </form>
                </div>

                <script>
                  function toggleFields() {
                    const type = document.getElementById('type').value;
                    const fichier = document.getElementById('fichier');
                    const fichierLabel = fichier.previousElementSibling;
                    
                    if (type === 'video' || type === 'seance') {
                      fichier.required = true;
                      fichierLabel.innerText = "Fichier associé * (obligatoire)";
                    } else {
                      fichier.required = false;
                      fichierLabel.innerText = "Fichier associé (facultatif)";
                    }
                  }
              </script>


    <?php elseif ($page === 'abonnement'): ?>
        <?php
          include 'db.php';

          // Fonction pour obtenir les abonnés par type
          function getAbonnesParType($pdo, $type)
          {
              $stmt = $pdo->prepare("SELECT u.nom, u.prenom, u.pays, u.ville, u.telephone, a.date_debut, a.date_fin, u.id
                                      FROM users u
                                      JOIN abonnements a ON a.user_id = u.id
                                      WHERE a.type = ?");
              $stmt->execute([$type]);
              return $stmt->fetchAll();
          }

          // Utilisateurs non abonnés après 7 jours
          $stmt = $pdo->prepare("SELECT * FROM users u
                                  WHERE NOT EXISTS (
                                    SELECT 1 FROM abonnements a WHERE a.user_id = u.id
                                  ) AND DATEDIFF(NOW(), u.date_inscription) > 7");
          $stmt->execute();
          $nonAbonnes = $stmt->fetchAll();

          $types = [
              '2semaines' => 'Deux semaines',
              '1mois' => 'Un mois',
              '3mois' => 'Trois mois',
              '1an' => 'Un an'
          ];
          ?>

          <div class="container my-5">
              <h2 class="mb-4 text-primary">Gestion des Abonnements</h2>

              <?php foreach ($types as $key => $label): ?>
                  <div class="card mb-5">
                      <div class="card-header bg-primary text-white">
                          Abonnés - <?= $label ?>
                      </div>
                      <div class="card-body">
                          <?php $abonnes = getAbonnesParType($pdo, $key); ?>
                          <?php if (count($abonnes) > 0): ?>
                           <div class="table-responsive card card-custom p-4">
                                <table class="table table-hover">
                                <thead class="table-danger">
                                  <tr>
                                      <th>Nom</th><th>Prénom</th><th>Pays</th><th>Ville</th><th>Âge</th><th>Sexe</th>
                                      <th>Téléphone</th><th>Début</th><th>Fin</th><th>Actions</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php foreach ($abonnes as $user): ?>
                                      <tr>
                                          <td><?= htmlspecialchars($user['nom']) ?></td>
                                          <td><?= htmlspecialchars($user['prenom']) ?></td>
                                          <td><?= htmlspecialchars($user['pays']) ?></td>
                                          <td><?= htmlspecialchars($user['ville']) ?></td>
                                          <td><?= htmlspecialchars($user['age']) ?></td>
                                          <td><?= htmlspecialchars($user['sexe']) ?></td>
                                          <td><?= htmlspecialchars($user['telephone']) ?></td>
                                          <td><?= $user['date_debut'] ?></td>
                                          <td><?= $user['date_fin'] ?></td>
                                          <td>
                                              <a href="bloquer_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm">Bloquer</a>
                                              <a href="debloquer_user.php?id=<?= $user['id'] ?>" class="btn btn-success btn-sm">Débloquer</a>
                                          </td>
                                      </tr>
                                  <?php endforeach; ?>
                                  </tbody>
                              </table>
                          </div>
                          <?php else: ?>
                              <p>Aucun abonné pour cette catégorie.</p>
                          <?php endif; ?>
                      </div>
                  </div>
              <?php endforeach; ?>

              <div class="card mb-5">
                  <div class="card-header bg-danger text-white">Utilisateurs non abonnés après 7 jours</div>
                  <div class="card-body">
                      <?php if (count($nonAbonnes) > 0): ?>
                      <div class="table-responsive card card-custom p-4">
                        <table class="table table-hover">
                            <thead class="table-danger">
                              <tr>
                                  <th>Nom</th><th>Prénom</th><th>Pays</th><th>Ville</th>
                                  <th>Téléphone</th><th>Date inscription</th><th>Actions</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php foreach ($nonAbonnes as $user): ?>
                                  <tr>
                                      <td><?= htmlspecialchars($user['nom']) ?></td>
                                      <td><?= htmlspecialchars($user['prenom']) ?></td>
                                      <td><?= htmlspecialchars($user['pays']) ?></td>
                                      <td><?= htmlspecialchars($user['ville']) ?></td>
                                      <td><?= htmlspecialchars($user['telephone']) ?></td>
                                      <td><?= $user['date_inscription'] ?></td>
                                      <td>
                                          <a href="bloquer_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm">Bloquer</a>
                                          <a href="debloquer_user.php?id=<?= $user['id'] ?>" class="btn btn-success btn-sm">Débloquer</a>
                                      </td>
                                  </tr>
                              <?php endforeach; ?>
                              </tbody>
                          </table>
                      </div>
                      <?php else: ?>
                          <p>Aucun utilisateur concerné.</p>
                      <?php endif; ?>
                  </div>
              </div>
          </div>


  <?php elseif ($page === 'signalements'): ?>
    <div class="container mt-4">
      <h3 class="mb-4 text-danger">🚨 Signalements utilisateurs</h3>

      <?php if (count($signalements) === 0): ?>
        <div class="alert alert-info">Aucun signalement pour le moment.</div>
      <?php else: ?>

        <div class="container mt-4">
  <h3 class="mb-4 text-danger">🚨 Signalements utilisateurs</h3>

  <form method="GET" action="" class="mb-3">
    <input type="hidden" name="page" value="signalements">
    <div class="input-group">
      <input type="text" name="filter_nom" class="form-control" placeholder="Filtrer par nom (signalé)" value="<?= isset($_GET['filter_nom']) ? htmlspecialchars($_GET['filter_nom']) : '' ?>">
      <button type="submit" class="btn btn-primary">Filtrer</button>
      <a href="?page=signalements" class="btn btn-secondary ms-2">Réinitialiser</a>
    </div>
  </form>

          <table class="table table-hover">
          <thead class="table-danger">
            <tr>
              <th>#</th>
              <th>Signalé par</th>
              <th>Contre</th>
              <th>Type</th>
              <th>Message</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($signalements as $s): ?>
              <tr>
                <td><?= $s['id'] ?></td>
                <td><strong><?= htmlspecialchars($s['signalant_nom']) ?></strong><br><small>@<?= htmlspecialchars($s['signalant_identifiant']) ?></small></td>
                <td><strong><?= htmlspecialchars($s['cible_nom']) ?></strong><br><small>@<?= htmlspecialchars($s['cible_identifiant']) ?></small></td>
                <td><?= $s['type'] ?></td>
                <td><?= nl2br(htmlspecialchars($s['message'])) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($s['date_signalement'])) ?></td>
                <td>
                  <!-- Lien pour voir le profil -->
                  <a href="../public_profil.php?id=<?= $s['cible_id'] ?>" class="btn btn-sm btn-outline-primary mb-1" target="_blank">Voir profil</a><br>

                  <!-- Lien pour bloquer (à développer) -->
                  <a href="admin/blocage_admin.php?bloque_id=<?= $s['cible_id'] ?>" class="btn btn-sm btn-outline-danger">
                    Bloquer
                  </a>

                  <!-- Lien pour marquer comme traité -->
                  <a href="admin/supprimer_signalement.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-success mt-1">Marquer comme traité</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>


<?php else: ?>
  <h1 class="mt-4" style="color: #ff5a5f;">Tableau de bord</h1>
  <div class="row g-4 my-4">
  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Total utilisateurs</h5>
      <h2><?php echo $totalUtilisateurs; ?></h2>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Admins</h5>
      <h2><?php echo $totalAdmins; ?></h2>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Inscriptions aujourd'hui</h5>
      <h2><?php echo $inscriptionsAujourdHui; ?></h2>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Total Coachs</h5>
      <h2><?php echo $totalCoachs; ?></h2>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Utilisateurs connectés</h5>
      <h2><?php echo $totalConnectes; ?></h2>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Inscriptions hier</h5>
      <h2><?php echo $inscriptionsHier; ?></h2>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Inscriptions cette semaine</h5>
      <h2><?php echo $inscriptionsSemaine; ?></h2>
    </div>
  </div>

  <div class="col-12 col-md-4">
    <div class="card card-custom p-4 text-center">
      <h5>Inscriptions ce mois</h5>
      <h2><?php echo $inscriptionsMois; ?></h2>
    </div>
  </div>

    <div class="col-12 col-md-4">
      <div class="card card-custom p-4 text-center">
          <h2 class="card-title"><?= $totalFemmes ?></h2>
          <h5 class="card-text">Femmes</h5>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card card-custom p-4 text-center">
          <h2 class="card-title"><?= $totalHommes ?></h2>
          <h5 class="card-text">Hommes</h5>
      </div>
    </div>
</div>



  <h3 style="color: #ff5a5f;">Liste des utilisateurs</h3>
  <div class="table-responsive card card-custom p-4">
  <table class="table table-hover">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Âge</th>
          <th>Pays</th>
          <th>Téléphone</th>
          <th>Date d'inscription</th>
          <th>Actions</th>
        </tr>

      </thead>
      <tbody>
       <?php foreach ($utilisateurs as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['nom']) ?></td>
          <td><?= htmlspecialchars($user['prenom']) ?></td>
          <td><?= htmlspecialchars($user['age']) ?></td>
          <td><?= htmlspecialchars($user['pays']) ?></td>
          <td><?= htmlspecialchars($user['telephone']) ?></td>
          <td><?= date('d/m/Y', strtotime($user['date_inscription'])) ?></td>
          <td>
              <a href="admin/voir_profil.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-info">
                <i class="fas fa-user"></i> Voir le profil
              </a>
              <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Modifier le rôle
              </a>
              <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                <i class="fas fa-trash"></i> Supprimer le compte
              </a>
              <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
                <i class="fas fa-ban"></i> Bloquer le compte
              </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>


  <h3 class="mt-5" style="color:#ff5a5f;">Liste des Admins</h3>
  <div class="table-responsive">
  <table class="table table-hover">
      <thead class="table-blue">
        <tr>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Âge</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Date d'inscription</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($admins as $admin): ?>
          <tr>
            <td><?php echo htmlspecialchars($admin['nom']); ?></td>
            <td><?php echo htmlspecialchars($admin['prenom']); ?></td>
            <td><?php echo htmlspecialchars($admin['age']); ?></td>
            <td><?php echo htmlspecialchars($admin['email']); ?></td>
            <td><?php echo htmlspecialchars($admin['telephone']); ?></td>
            <td><?php echo htmlspecialchars($admin['date_inscription']); ?></td>
             <td>
            <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
              <i class="fas fa-edit"></i> Modifier le role
            </a>
            <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
              <i class="fas fa-trash"></i> Supprimer le compte
            </a>
            <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
              <i class="fas fa-ban"></i> Bloquer le compte
            </a>
          </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <h3 class="mt-5">Liste des Coachs</h3>
 <div class="table-responsive">
  <table class="table table-hover">
      <thead class="table-dark">
        <tr>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Âge</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Catégorie</th>
          <th>Date d'inscription</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($coachs as $coach): ?>
          <tr>
            <td><?php echo htmlspecialchars($coach['nom']); ?></td>
            <td><?php echo htmlspecialchars($coach['prenom']); ?></td>
            <td><?php echo htmlspecialchars($coach['age']); ?></td>
            <td><?php echo htmlspecialchars($coach['email']); ?></td>
            <td><?php echo htmlspecialchars($coach['telephone']); ?></td>
            <td><?php echo htmlspecialchars($coach['categorie'] ?? 'Non définie'); ?></td>
            <td><?php echo htmlspecialchars($coach['date_inscription']); ?></td>
            <td>
              <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Modifier le role
              </a>
              <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                <i class="fas fa-trash"></i> Supprimer le compte
              </a>
              <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
                <i class="fas fa-ban"></i> Bloquer le compte
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>


    <h4 style="color:#ff5a5f;">Utilisateurs connectés (10 dernières minutes)</h4>
    <div class="table-responsive card card-custom p-4">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Ville</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Dernière activité</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($utilisateursConnectes as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
              <td><?= htmlspecialchars($user['age']) ?></td>
              <td><?= htmlspecialchars($user['ville']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['telephone']) ?></td>
              <td><?= date('d/m/Y H:i', strtotime($user['last_activity'])) ?></td>
               <td>
                <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Modifier le role
                </a>
                <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                  <i class="fas fa-trash"></i> Supprimer le compte
                </a>
                <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
                  <i class="fas fa-ban"></i> Bloquer le compte
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

      <h4 class="mt-5" style="color:#ff5a5f;">Inscriptions aujourd'hui</h4>
      <div class="table-responsive card card-custom p-4">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Âge</th>
              <th>Ville</th>
              <th>Email</th>
              <th>Téléphone</th>
              <th>Date d'inscription</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($utilisateursAujourdhui as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['nom']) ?></td>
                <td><?= htmlspecialchars($user['prenom']) ?></td>
                <td><?= htmlspecialchars($user['age']) ?></td>
                <td><?= htmlspecialchars($user['ville']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['telephone']) ?></td>
                <td><?= date('d/m/Y', strtotime($user['date_inscription'])) ?></td>
                 <td>
                <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Modifier le role
                </a>
                <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                  <i class="fas fa-trash"></i> Supprimer le compte
                </a>
                <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
                  <i class="fas fa-ban"></i> Bloquer le compte
                </a>
              </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <h4 class="mt-5" style="color:#ff5a5f;">Inscriptions hier</h4>
      <div class="table-responsive card card-custom p-4">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Âge</th>
              <th>Ville</th>
              <th>Email</th>
              <th>Téléphone</th>
              <th>Date d'inscription</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($utilisateursHier as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['nom']) ?></td>
                <td><?= htmlspecialchars($user['prenom']) ?></td>
                <td><?= htmlspecialchars($user['age']) ?></td>
                <td><?= htmlspecialchars($user['ville']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['telephone']) ?></td>
                <td><?= date('d/m/Y', strtotime($user['date_inscription'])) ?></td>
                <td>
                  <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Modifier le role
                  </a>
                  <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                    <i class="fas fa-trash"></i> Supprimer le compte
                  </a>
                  <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
                    <i class="fas fa-ban"></i> Bloquer le compte
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    <h4 class="mt-5" style="color:#ff5a5f;">Inscriptions cette semaine </h4>
    <div class="table-responsive card card-custom p-4">
        <table class="table table-hover">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Ville</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date d'inscription</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($utilisateursSemaine as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
              <td><?= htmlspecialchars($user['age']) ?></td>
              <td><?= htmlspecialchars($user['ville']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['telephone']) ?></td>
              <td><?= date('d/m/Y', strtotime($user['date_inscription'])) ?></td>
              <td>
                <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Modifier le role
                </a>
                <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                  <i class="fas fa-trash"></i> Supprimer le compte
                </a>
                <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
                  <i class="fas fa-ban"></i> Bloquer le compte
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h4 class="mt-5" style="color:#ff5a5f;">Inscriptions ce mois-ci </h4>
    <div class="table-responsive card card-custom p-4">
        <table class="table table-hover">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Ville</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date d'inscription</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($utilisateursMois as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['nom']) ?></td>
              <td><?= htmlspecialchars($user['prenom']) ?></td>
              <td><?= htmlspecialchars($user['age']) ?></td>
              <td><?= htmlspecialchars($user['ville']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['telephone']) ?></td>
              <td><?= date('d/m/Y', strtotime($user['date_inscription'])) ?></td>
              <td>
                <a href="admin/modifier_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Modifier le role
                </a>
                <a href="admin/supprimer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?');">
                  <i class="fas fa-trash"></i> Supprimer le compte
                </a>
                <a href="admin/bloquer_utilisateur.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Bloquer cet utilisateur ?');">
                  <i class="fas fa-ban"></i> Bloquer le compte
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>


<?php endif; ?>
</div>


<!-- Bouton flottant 💬 -->
<div id="bb-chat-toggle">💬</div>

<!-- Boîte de chat masquée au départ -->
<div id="bb-chat-box" style="display: none;">
    <div id="chat-header">💬 BBLove Chat</div>
    <div id="chat-messages"></div>
    <form id="chat-form">
        <input type="text" id="chat-input" placeholder="Écris ton message..." autocomplete="off" />
        <button type="submit">Envoyer</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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
</script>


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




54
</body>
</html>
