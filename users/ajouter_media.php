<?php
include 'db.php';

$user_id = $_SESSION['user_id'];
$upload_dir = '../uploads/';
$message = '';

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $legende = $_POST['legende'] ?? '';
    $media = $_FILES['media']['name'];
    $tmp = $_FILES['media']['tmp_name'];

    if (!empty($media)) {
        $ext = strtolower(pathinfo($media, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'webm'];

        if (!in_array($ext, $allowed)) {
            $message = "❌ Extension non autorisée.";
        } else {
            $file_name = time() . '_' . basename($media);
            $upload_dir = realpath(__DIR__ . '/../uploads') . '/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $target_file = $upload_dir . $file_name;

            if (move_uploaded_file($tmp, $target_file)) {
                $stmt = $pdo->prepare("INSERT INTO galerie (user_id, type, fichier, legende) VALUES (?, ?, ?, ?)");
                $stmt->execute([$user_id, $type, 'uploads/' . $file_name, $legende]);
                $message = "✅ Média ajouté avec succès.";
            } else {
                $message = "❌ Erreur lors de l'envoi du fichier.";
            }
        }
    } else {
        $message = "Veuillez sélectionner un fichier.";
    }
}
?>

<body class="bg-light">
  <div class="container mt-5">
    <h3 class="text-danger mb-4">Ajouter une photo ou vidéo</h3>

    <?php if ($message): ?>
      <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-select" required>
          <option value="photo">Photo</option>
          <option value="video">Vidéo</option>
        </select>
      </div>
      <div class="mb-3">
        <label>Fichier</label>
        <input type="file" name="media" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Légende (optionnel)</label>
        <textarea name="legende" class="form-control" rows="2"></textarea>
      </div>
      <button type="submit" class="btn btn-danger">Ajouter</button>
    </form>
  </div>
</body>

