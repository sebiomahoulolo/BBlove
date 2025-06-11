<?php
include '../db.php';

$stmt = $pdo->query("SELECT pseudo, message, created_at FROM mesages ORDER BY created_at ASC");
$messages = $stmt->fetchAll();

foreach ($messages as $msg) {
    $pseudo = htmlspecialchars($msg['pseudo']);
    $message = htmlspecialchars($msg['message']);
    $time = date('H:i', strtotime($msg['created_at']));

    echo "
    <div style='margin-bottom: 12px;'>
        <div style='font-weight: bold; color: #ff5a5f;'>$pseudo <span style='font-size: 12px; color: gray;'>[$time]</span></div>
        <div style='
            background-color:rgb(253, 208, 209);
            padding: 10px 14px;
            border-radius: 12px;
            display: inline-block;
            max-width: 85%;
            margin-top: 4px;
        '>$message</div>
    </div>
    ";
}
?>
