<?php
session_start();
include '../db.php';

// Vérification de session utilisateur
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$otherUserId = $_GET['user_id'] ?? null;

if (!$otherUserId) {
    header('Location: decouvrir.php');
    exit();
}

// Récupération des informations de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();

// Récupération des informations de l'autre utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$otherUserId]);
$otherUser = $stmt->fetch();

// Traitement de l'envoi de message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO messages (expediteur_id, destinataire_id, contenu, date_envoi) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$userId, $otherUserId, $message]);
    }
}

// Récupération des messages
$stmt = $pdo->prepare("
    SELECT m.*, u.nom, u.profile_picture 
    FROM messages m 
    JOIN users u ON m.expediteur_id = u.id 
    WHERE (m.expediteur_id = ? AND m.destinataire_id = ?) 
    OR (m.expediteur_id = ? AND m.destinataire_id = ?) 
    ORDER BY m.date_envoi ASC
");
$stmt->execute([$userId, $otherUserId, $otherUserId, $userId]);
$messages = $stmt->fetchAll();


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove | Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
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
            position: relative;
            overflow: hidden;
        }
        
        /* Header */
        .chat-header {
            background-color: var(--white);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--medium-gray);
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 500px;
            z-index: 100;
            height: 70px;
        }
        
        .back-button {
            color: var(--dark-gray);
            text-decoration: none;
            font-size: 1.2rem;
        }
        
        .user-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--black);
        }
        
        .user-status {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }
        
        /* Messages */
        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 70px;
            margin-bottom: 70px;
            height: calc(100vh - 140px);
            min-height: 600px;
            position: relative;
            background-color: var(--light-gray);
        }
        
        .message {
            max-width: 70%;
            padding: 12px;
            border-radius: 16px;
            position: relative;
            word-wrap: break-word;
            margin-bottom: 10px;
        }
        
        .message.your_message {
            background-color: var(--primary);
            color: var(--white);
            margin-left: auto;
            margin-right: 0;
            border-bottom-right-radius: 4px;
        }
        
        .message.others_message {
            background-color: var(--white);
            color: var(--black);
            margin-right: auto;
            margin-left: 0;
            border-bottom-left-radius: 4px;
        }
        
        .autre_message_info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }
        
        .date {
            font-size: 0.7rem;
            margin-top: 4px;
            opacity: 0.8;
            text-align: right;
        }
        
        /* Input */
        .message-input-container {
            background-color: var(--white);
            padding: 12px 16px;
            border-top: 1px solid var(--medium-gray);
            display: flex;
            gap: 12px;
            align-items: center;
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 500px;
            height: 70px;
            z-index: 100;
        }
        
        .message-input {
            flex: 1;
            border: none;
            background-color: var(--light-gray);
            padding: 12px;
            border-radius: 24px;
            font-size: 1rem;
            resize: none;
            max-height: 100px;
            min-height: 24px;
        }
        
        .message-input:focus {
            outline: none;
        }
        
        .send-button {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .send-button:hover {
            background-color: var(--primary-hover);
            transform: scale(1.05);
        }
        
        .send-button:disabled {
            background-color: var(--medium-gray);
            cursor: not-allowed;
            transform: none;
        }
        
        /* Scrollbar personnalisée */
        .messages-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .messages-container::-webkit-scrollbar-track {
            background: var(--light-gray);
        }
        
        .messages-container::-webkit-scrollbar-thumb {
            background: var(--medium-gray);
            border-radius: 3px;
        }
        
        .messages-container::-webkit-scrollbar-thumb:hover {
            background: var(--dark-gray);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="chat-header fixed-top">
        <a href="decouvrir.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="user-info">
            <img src="<?= !empty($otherUser['profile_picture']) ? '../uploads/' . $otherUser['profile_picture'] : 'https://randomuser.me/api/portraits/women/44.jpg' ?>" 
                 alt="Profil" 
                 class="user-avatar">
            <div>
                <div class="user-name"><?= htmlspecialchars($otherUser['nom']) ?></div>
                <div class="user-status">En ligne</div>
            </div>
        </div>
    </div>

    <div class="messages-container" id="messagesContainer">
    <?php
    if (isset($_SESSION['user_id'])) {
    $recup_message = $pdo->query('SELECT * FROM messages ORDER BY id ASC');

    if($recup_message->rowCount() > 0){

        while ($exist_msg = $recup_message->fetch()) {
            if ($exist_msg["destinataire_id"] == $otherUserId) {
            ?>
                <div class="message your_message">
                    <span>Vous</span>
                    <p><?= $exist_msg['contenu'] ?></p>
                    <p class="date"><?= $exist_msg['date_envoi'] ?></p>
                </div>
    
            <?php
                }else if ( $exist_msg["destinataire_id"] == $userId && $exist_msg["expediteur_id"] == $otherUserId) {
                    ?>
                        <div class="message others_message">
                            <div class="autre_message_info">
                                <p><?= $exist_msg['contenu'] ?></p>
                            </div>
                            <p><?= $exist_msg['contenu'] ?></p>
                            <p class="date"><?= $exist_msg['date_envoi'] ?></p>
                        </div>
                    <?php
            
                    }
        }
    }else{
        echo "La boite de messagerie est vide";
    }
}
?>
</div> 

    <!-- Messages -->
    <div class="messages-container p-5" id="messagesContainer">
        <?php foreach($messages as $message): ?>
            <div class="message <?= $message['expediteur_id'] == $userId ? 'sent' : 'received' ?>">
                <div class="message-content">
                    <?= htmlspecialchars($message['contenu']) ?>
                </div>
                <div class="message-time">
                    <?= date('H:i', strtotime($message['date_envoi'])) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Input -->
    <form class="message-input-container" method="POST" id="messageForm">
        <textarea name="message" class="message-input" placeholder="Écrivez votre message..." required></textarea>
        <button type="submit" class="send-button" id="sendButton">
            <i class="fas fa-paper-plane"></i>
        </button>
    </form>

    <script>
        // Auto-scroll to bottom
        const messagesContainer = document.getElementById('messagesContainer');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Auto-resize textarea
        const messageInput = document.querySelector('.message-input');
        const sendButton = document.getElementById('sendButton');

        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            sendButton.disabled = !this.value.trim();
        });

        // Form submission
        const messageForm = document.getElementById('messageForm');
        messageForm.addEventListener('submit', function(e) {
            if (!messageInput.value.trim()) {
                e.preventDefault();
            }
        });

        // Auto-scroll on new message
        const observer = new MutationObserver(() => {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });

        observer.observe(messagesContainer, {
            childList: true,
            subtree: true
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html> 