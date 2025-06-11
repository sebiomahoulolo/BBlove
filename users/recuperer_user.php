<?php
session_start();
include '../db.php';

// Vérification de session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Récupération des utilisateurs avec qui l'utilisateur a échangé des messages
$stmt = $pdo->prepare("
    SELECT DISTINCT 
        u.id,
        u.nom,
        p.photo,
        p.age,
        p.ville,
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
    LEFT JOIN profils p ON u.id = p.user_id
    INNER JOIN messages m ON 
        (m.expediteur_id = ? AND m.destinataire_id = u.id) 
        OR (m.expediteur_id = u.id AND m.destinataire_id = ?)
    WHERE u.id != ?
    GROUP BY u.id
    ORDER BY date_dernier_message DESC
");
$stmt->execute([$userId, $userId, $userId, $userId, $userId, $userId, $userId]);
$users = $stmt->fetchAll();

// Mise à jour de la dernière activité
$stmt = $pdo->prepare("UPDATE users SET last_activity = NOW() WHERE id = ?");
$stmt->execute([$userId]);
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
            --secondary: #ff7b8b;
            --dark: #1e1e1e;
            --light: #f5f5f5;
            --white: #ffffff;
            --gray: #e4e6eb;
            --dark-gray: #b0b3b8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            height: 100vh;
            display: flex;
            flex-direction: column;
            max-width: 500px;
            margin: 0 auto;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        /* Header */
        .header {
            background-color: var(--white);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--gray);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 8px;
        }

        /* Messages List */
        .messages-list {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background-color: var(--white);
        }

        .message-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid var(--gray);
            text-decoration: none;
            color: var(--dark);
            transition: background-color 0.2s ease;
        }

        .message-item:hover {
            background-color: var(--light);
        }

        .message-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            border: 2px solid var(--primary);
        }

        .message-content {
            flex: 1;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .message-name {
            font-weight: 600;
            color: var(--dark);
        }

        .message-time {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }

        .message-preview {
            font-size: 0.9rem;
            color: var(--dark-gray);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .no-messages {
            text-align: center;
            padding: 40px 20px;
            color: var(--dark-gray);
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: 500px;
            background-color: var(--white);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 1px solid var(--gray);
            z-index: 100;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--dark-gray);
            text-decoration: none;
            font-size: 0.7rem;
        }
        
        .nav-item i {
            font-size: 1.3rem;
            margin-bottom: 3px;
        }
        
        .nav-item.active {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <a href="./../dashboard.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <i class="fas fa-heart"></i>
            <span>BBLove</span>
        </div>
    </div>

    <!-- Messages List -->
    <div class="messages-list">
        <?php if (empty($users)): ?>
            <div class="no-messages">
                <i class="fas fa-comments fa-3x mb-3"></i>
                <p>Vous n'avez pas encore de conversations</p>
            </div>
        <?php else: ?>
            <?php foreach ($users as $user): ?>
                <a href="chat.php?user_id=<?= $user['id'] ?>" class="message-item">
                    <img src="<?= !empty($user['photo']) ? $user['photo'] : 'https://randomuser.me/api/portraits/men/1.jpg' ?>" 
                         alt="Profil" 
                         class="message-avatar">
                    <div class="message-content">
                        <div class="message-header">
                            <span class="message-name"><?= htmlspecialchars($user['nom']) ?></span>
                            <?php if ($user['date_dernier_message']): ?>
                                <span class="message-time">
                                    <?= date('H:i', strtotime($user['date_dernier_message'])) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="message-preview">
                            <?= htmlspecialchars($user['dernier_message'] ?? '') ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="./../dashboard.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="decouvrir.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Découvrir</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-bars"></i>
            <span>Rencontres</span>
        </a>
        <a href="#" class="nav-item active">
            <i class="fas fa-comment-dots"></i>
            <span>Messages</span>
        </a>
        <a href="new_profil.php?user_id=<?= htmlspecialchars($userId) ?>" class="nav-item">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
    </div>
</body>
</html>
