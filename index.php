<?php
// Détection mobile
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

// Redirection vers la version appropriée
if (isMobile()) {
    header('Location: mobile.php');
    exit();
} else {
    header('Location: desktop.php');
    exit();
}
?>
