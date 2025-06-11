<?php
session_start();
include '../db.php';

// Vérification de session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Récupération des conversations
$stmt = $pdo->prepare("
    SELECT DISTINCT 
        u.id,
        u.nom,
        u.profile_picture,
        u.age,
        u.ville,
        (
            SELECT m.contenu 
            FROM messages m 
            WHERE (m.expediteur_id = ? AND m.destinataire_id = u.id) 
            OR (m.expediteur_id = u.id AND m.destinataire_id = ?)
            ORDER BY m.date_envoi DESC 
            LIMIT 1
        ) as dernier_message,
        (
            SELECT m.date_envoi 
            FROM messages m 
            WHERE (m.expediteur_id = ? AND m.destinataire_id = u.id) 
            OR (m.expediteur_id = u.id AND m.destinataire_id = ?)
            ORDER BY m.date_envoi DESC 
            LIMIT 1
        ) as date_dernier_message
    FROM users u
    INNER JOIN messages m ON 
        (m.expediteur_id = ? AND m.destinataire_id = u.id) 
        OR (m.expediteur_id = u.id AND m.destinataire_id = ?)
    WHERE u.id != ?
    GROUP BY u.id
    ORDER BY date_dernier_message DESC
");
$stmt->execute([$userId, $userId, $userId, $userId, $userId, $userId, $userId]);
$conversations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove | Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff2d55;
            --primary-hover: #e61e4d;
            --secondary: #ff7b8b;
            --white: #ffffff;
            --light-gray: #f0f2f5;
            --medium-gray: #dddfe2;
            --dark-gray: #65676b;
            --black: #1c1e21;
            --shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--black);
            height: 100vh;
            display: flex;
            flex-direction: column;
            max-width: 500px;
            margin: 0 auto;
        }
        
        /* Header */
        .header {
            background-color: var(--white);
            padding: 16px;
            text-align: center;
            border-bottom: 1px solid var(--medium-gray);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header h1 {
            font-size: 1.5rem;
            color: var(--black);
        }
        
        /* Conversations */
        .conversations {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }
        
        .conversation-card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            gap: 12px;
            align-items: center;
            text-decoration: none;
            color: var(--black);
            transition: var(--transition);
            box-shadow: var(--shadow);
        }
        
        .conversation-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .conversation-info {
            flex: 1;
        }
        
        .user-name {
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .user-details {
            font-size: 0.8rem;
            color: var(--dark-gray);
            margin-bottom: 4px;
        }
        
        .last-message {
            font-size: 0.9rem;
            color: var(--dark-gray);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        
        .message-time {
            font-size: 0.8rem;
            color: var(--dark-gray);
            margin-left: 8px;
        }
        
        /* Bottom Navigation */
        .bottom-nav {
            background-color: var(--white);
            padding: 12px 16px;
            display: flex;
            justify-content: space-around;
            border-top: 1px solid var(--medium-gray);
        }
        
        .nav-item {
            color: var(--dark-gray);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: 0.8rem;
        }
        
        .nav-item i {
            font-size: 1.2rem;
        }
        
        .nav-item.active {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Messages</h1>
    </div>

    <!-- Conversations -->
    <div class="conversations">
        <?php if (empty($conversations)): ?>
            <div style="text-align: center; padding: 32px; color: var(--dark-gray);">
                Vous n'avez pas encore de conversations
            </div>
        <?php else: ?>
            <?php foreach($conversations as $conv): ?>
                <a href="chat.php?user_id=<?= $conv['id'] ?>" class="conversation-card">
                    <img src="<?= !empty($conv['profile_picture']) ? '../uploads/' . $conv['profile_picture'] : 'https://randomuser.me/api/portraits/women/44.jpg' ?>" 
                         alt="Profil" 
                         class="user-avatar">
                    <div class="conversation-info">
                        <div class="user-name"><?= htmlspecialchars($conv['nom']) ?></div>
                        <div class="user-details">
                            <?= $conv['age'] ?> ans • <?= htmlspecialchars($conv['ville']) ?>
                        </div>
                        <div class="last-message">
                            <?= htmlspecialchars($conv['dernier_message']) ?>
                            <span class="message-time">
                                <?= date('H:i', strtotime($conv['date_dernier_message'])) ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="dashboard.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="decouvrir.php" class="nav-item">
            <i class="fas fa-compass"></i>
            <span>Découvrir</span>
        </a>
        <a href="new_message.php" class="nav-item active">
            <i class="fas fa-comment"></i>
            <span>Messages</span>
        </a>
        <a href="profil.php" class="nav-item">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </div>
</body>
</html>
