<?php
require_once __DIR__ . '/../session.php';
$gitaDetails = $giteController->getGitaDetails($gitaId);
$tourDetails = $giteController->getTourByGita($gitaId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Gita</title>
</head>
<body>
    <nav>
        <a href="index.php">Home</a> |
        <a href="index.php?url=login">Login</a> |
        <a href="index.php?url=signup">Signup</a>
        <?php if (isset($_SESSION['id'])): ?>
            | <a href="index.php?url=myGite">Le mie Gite</a>
        <?php endif; ?>
    </nav>
    <h1>Dettagli Gita</h1>
    <p><strong>Nome:</strong> <?php echo $gitaDetails['nome']; ?></p>
    <p><strong>Data Inizio:</strong> <?php echo $gitaDetails['data_inizio']; ?></p>
    <p><strong>Data Fine:</strong> <?php echo $gitaDetails['data_fine']; ?></p>
    <p><strong>Meta:</strong> <?php echo $gitaDetails['citta']; ?></p>
    <p><strong>Prezzo:</strong> <?php echo $gitaDetails['prezzo']; ?>€</p>

    <h2>Tour Inclusi</h2>
    <?php
        foreach ($tourDetails as $tour) {
            echo "<p>";
            echo "<strong>Nome:</strong> {$tour['nome']}<br>";
            echo "<strong>Prezzo:</strong> {$tour['prezzo']}€<br>";
            echo "</p>";
        }
    ?>

    <?php if ($_SESSION['classe'] === 'PRF'): ?>
        <h2>Gestione Tour</h2>
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Descrizione</th>
                <th>Azioni</th>
            </tr>
            <?php
            $tours = $giteController->getToursForGita($gitaId);
            foreach ($tours as $tour) {
                echo "<tr>";
                echo "<td>{$tour['nome']}</td>";
                echo "<td>{$tour['prezzo']}€</td>";
                echo "<td>{$tour['descrizione']}</td>";
                echo "<td>";
                echo "<a href='index.php?url=editTour&tour_id={$tour['id']}'><button>Modifica</button></a> ";
                echo "<a href='index.php?url=deleteTour&tour_id={$tour['id']}'><button>Elimina</button></a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <a href="index.php?url=addTour&gita_id=<?php echo $gitaId; ?>"><button>Aggiungi Tour</button></a>
    <?php endif; ?>
</body>
</html>