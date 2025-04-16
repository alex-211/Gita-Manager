<?php
require_once __DIR__ . '/../session.php';

if ($_SESSION['classe'] === 'PRF') {
    $gite = $giteController->getAllGite(); // Fetch all gites for PRF users
    $approvedGite = []; // Initialize as an empty array for PRF users
} else {
    $gite = $giteController->getApprovedGiteByUser($_SESSION['id']); // Fetch approved gites for other users
    $approvedGite = $giteController->getApprovedGiteByUser($_SESSION['id']);
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['id'], $_SESSION['classe']);
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le mie Gite</title>
</head>
<body>
    <nav>
        <a href="index.php">Home</a> |
        <a href="index.php?url=login">Login</a> |
        <a href="index.php?url=signup">Signup</a>
        <?php if (isset($_SESSION['id'])): ?>
            | <a href="index.php?url=myGite">Le mie Gite</a>
            | <a href="index.php?url=myGite&action=logout">Logout</a>
        <?php endif; ?>
    </nav>

    <h1>Le mie Gite</h1>

    <?php if ($_SESSION['classe'] === 'PRF'): ?>
        <a href="index.php?url=addGita"><button>Aggiungi Gita</button></a>
        <a href="index.php?url=addTour"><button>Aggiungi Tour</button></a>
    <?php endif; ?>

    <?php if ($_SESSION['classe'] !== 'PRF'): ?>
        <h2>Gite Disponibili</h2>
        <?php
            foreach ($gite as $gita) {
                echo "<p>";
                echo "<strong>Nome:</strong> {$gita['nome']}<br>";
                echo "<strong>Data Inizio:</strong> {$gita['data_inizio']}<br>";
                echo "<strong>Data Fine:</strong> {$gita['data_fine']}<br>";
                echo "<strong>Meta:</strong> {$gita['citta']}<br>";
                echo "<strong>Prezzo:</strong> {$gita['prezzo']}€<br>";
                echo "<a href='index.php?url=joinGita&gita_id={$gita['id']}'><button>Iscriviti</button></a>";
                echo "</p>";
            }
        ?>
    <?php endif; ?>

    <h2>Gite Approvate</h2>
    <?php
        foreach ($approvedGite as $gita) {
            echo "<p>";
            echo "<strong>Nome:</strong> {$gita['nome']}<br>";
            echo "<strong>Data Inizio:</strong> {$gita['data_inizio']}<br>";
            echo "<strong>Data Fine:</strong> {$gita['data_fine']}<br>";
            echo "<strong>Meta:</strong> {$gita['citta']}<br>";
            echo "<strong>Prezzo:</strong> {$gita['prezzo']}€<br>";
            echo "<a href='index.php?url=viewGita&gita_id={$gita['id']}'><button>Visualizza</button></a>";
            if ($_SESSION['classe'] === 'PRF') {
                echo "<a href='index.php?url=editGita&gita_id={$gita['id']}'><button>Modifica</button></a>";
            }
            echo "</p>";
        }
    ?>
</body>
</html>