<?php
$tourGite = $giteController->getAllGite();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Tour</title>
</head>
<body>
    <h1>Aggiungi Tour</h1>
    <form action="index.php?url=addTour" method="post">
        <label for="nome">Nome Tour:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="prezzo">Prezzo:</label>
        <input type="number" id="prezzo" name="prezzo" step="0.01" required><br>

        <label for="descrizione">Descrizione:</label>
        <textarea id="descrizione" name="descrizione" rows="4" cols="50" required></textarea><br>

        <label for="gita_id">Gita Associata:</label>
        <select id="gita_id" name="gita_id" required>
            <?php
                foreach ($tourGite as $gita) {
                    echo "<option value='{$gita['id']}'>{$gita['nome']}</option>";
                }
            ?>
        </select><br>

        <input type="submit" value="Aggiungi Tour">
    </form>
</body>
</html>