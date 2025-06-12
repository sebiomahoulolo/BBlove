<?php
include '../db.php';
session_start();

$userId = $_SESSION['user_id'];

$getUser = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$getUser->execute([$userId]);
$getUser = $getUser->fetch();

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id']; // Assure-toi que l'utilisateur est connecté
    $content = trim($_POST['content']);
    $imageName = null;

    // Gestion de l'image
    if (!empty($_FILES['image']['name'])) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageType = $_FILES['image']['type'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        if (in_array($imageType, $allowedTypes)) {
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = '../uploads/' . $imageName;
            move_uploaded_file($imageTmp, $targetPath);
        } else {
            echo "Type d'image non supporté.";
            exit;
        }
    }

    // Enregistrement dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $content, $imageName]);

        echo "✅ Publication enregistrée avec succès !";
        // Optionnel : redirection
        // header("Location: fil_actu.php");
    } catch (PDOException $e) {
        echo "❌ Erreur : " . $e->getMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBLove | Créer un post</title>
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
            max-width: 500px;
            margin: 0 auto;
            min-height: 100vh;
        }
        
        /* Navbar stabilisée */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background-color: var(--white);
            border-bottom: 1px solid var(--medium-gray);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
        }
        
        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .navbar-title i {
            font-size: 1.3rem;
        }
        
        .navbar-actions {
            display: flex;
            gap: 16px;
        }
        
        .navbar-icon {
            font-size: 1.25rem;
            color: var(--dark-gray);
            position: relative;
            padding: 8px;
            border-radius: 50%;
            transition: var(--transition);
        }
        
        .navbar-icon:hover {
            background-color: var(--light-gray);
            transform: translateY(-2px);
        }
        
        .navbar-icon.active {
            color: var(--primary);
        }
        
        .navbar-icon.active::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background-color: var(--primary);
            border-radius: 50%;
        }
        
        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: var(--primary);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 600;
        }
        
        /* Contenu stabilisé */
        .create-post-container {
            background-color: var(--white);
            margin: 16px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 16px;
        }
        
        .post-header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        
        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            border: 2px solid var(--primary);
        }
        
        .post-input-container {
            flex: 1;
            position: relative;
        }
        
        .post-input {
            width: 100%;
            border: none;
            font-size: 1.1rem;
            padding: 12px;
            resize: none;
            min-height: 100px;
            background-color: var(--light-gray);
            border-radius: 12px;
            transition: var(--transition);
        }
        
        .post-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary);
        }
        
        .post-input::placeholder {
            color: var(--dark-gray);
        }
        
        .emoji-picker {
            position: absolute;
            right: 12px;
            bottom: 12px;
            color: var(--dark-gray);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .emoji-picker:hover {
            color: var(--primary);
            transform: scale(1.1);
        }
        
        .post-options {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--medium-gray);
            padding-top: 16px;
            margin-top: 16px;
        }
        
        .options-left {
            display: flex;
            gap: 8px;
        }
        
        .option {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.95rem;
            transition: var(--transition);
        }
        
        .option:hover {
            transform: translateY(-2px);
        }
        
        .option i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        
        .photo-option {
            color: #45bd62;
            background-color: rgba(69, 189, 98, 0.1);
        }
        
        .tag-option {
            color: #1877f2;
            background-color: rgba(24, 119, 242, 0.1);
        }
        
        .feeling-option {
            color: #f7b928;
            background-color: rgba(247, 185, 40, 0.1);
        }
        
        .post-button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            opacity: 0.7;
            transition: var(--transition);
        }
        
        .post-button.enabled {
            opacity: 1;
            box-shadow: 0 4px 12px rgba(255, 45, 85, 0.3);
        }
        
        .post-button.enabled:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 45, 85, 0.4);
        }
    </style>
</head>
<body>
    <!-- Barre de navigation finale -->
    <nav class="navbar">
        <div class="navbar-title">
            <a href="./../dashboard.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
            <i class="fas fa-heart"></i>
            <span>BBLove</span>
        </div>
        <div class="navbar-actions">
            <!-- <a href="#" class="navbar-icon" title="Recherche">
                <i class="fas fa-search"></i>
            </a>
            <a href="#" class="navbar-icon active" title="Créer">
                <i class="fas fa-plus-square"></i>
            </a>
            <a href="#" class="navbar-icon" title="Messages">
                <i class="fas fa-comment-dots"></i>
                <span class="notification-badge">3</span>
            </a> -->
            <a href="./new_profil.php?user_id=<?= $userId ?>" class="navbar-icon" title="Profil">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </nav>

    <!-- Zone de création de post finale -->
    <div class="create-post-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="post-header">
                
                <img src="<?= !empty($getUser['profile_picture']) ? '../uploads/' . $getUser['profile_picture'] : 'https://randomuser.me/api/portraits/women/44.jpg' ?>" alt="Profil" class="user-avatar">
                <div class="post-input-container">
                    <textarea name="content" class="post-input" placeholder="À quoi pensez-vous ?" required maxlength="500"></textarea>
                    <div class="emoji-picker" title="Émojis">
                        <i class="far fa-smile"></i>
                    </div>
                </div>
            </div>
            
            <div class="post-options">
                <div class="options-left">
                    <label class="option photo-option" title="Ajouter une photo">
                        <i class="fas fa-camera"></i>
                        <span>Photo</span>
                        <input type="file" name="image" accept="image/*" style="display: none;" id="imageInput">
                    </label>
                    <!-- <button type="button" class="option tag-option" title="Tagger quelqu'un">
                        <i class="fas fa-user-tag"></i>
                        <span>Personne</span>
                    </button> -->
                </div>
                <button type="submit" class="post-button" id="postButton">Publier</button>
            </div>
        </form>
    </div>

    <script>
        // Activation dynamique du bouton
        const postInput = document.querySelector('.post-input');
        const postButton = document.getElementById('postButton');
        const imageInput = document.getElementById('imageInput');
        
        postInput.addEventListener('input', function() {
            const hasContent = this.value.trim() !== '';
            postButton.classList.toggle('enabled', hasContent);
        });
        
        // Gestion de l'upload d'image
        imageInput.addEventListener('change', function() {
            if(this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const label = this.parentElement;
                label.querySelector('span').textContent = fileName;
            }
        });
        
        // Gestion des options
        document.querySelectorAll('.option').forEach(option => {
            option.addEventListener('click', () => {
                option.style.transform = 'scale(0.95)';
                setTimeout(() => option.style.transform = 'translateY(-2px)', 150);
            });
        });
        
        // Émoji picker
        document.querySelector('.emoji-picker').addEventListener('click', () => {
            alert('Sélecteur d\'émoticônes ouvert');
        });
    </script>
</body>
</html>