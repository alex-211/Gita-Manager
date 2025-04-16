<?php
$gite = $giteController->getAllGite();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Benvenuto nel sistema di gestione delle gite scolastiche</h1>
    <nav>
        <a href="index.php">Home</a> |
        <a href="index.php?url=login">Login</a> |
        <a href="index.php?url=signup">Signup</a>
        <?php if (isset($_SESSION['id'])): ?>
            | <a href="index.php?url=myGite">Le mie Gite</a>
        <?php endif; ?>
    </nav>

    <h2>Gite Disponibili</h2>
    <?php
        foreach ($gite as $gita) {
            echo "<p>";
            echo "<strong>Nome:</strong> {$gita['nome']}<br>";
            echo "<strong>Data Inizio:</strong> {$gita['data_inizio']}<br>";
            echo "<strong>Data Fine:</strong> {$gita['data_fine']}<br>";
            echo "<strong>Meta:</strong> {$gita['citta']}<br>";
            echo "<strong>Prezzo:</strong> {$gita['prezzo']}€<br>";
            echo "</p>";
        }
    ?>
</body>
</html>