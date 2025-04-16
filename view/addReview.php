<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Recensione</title>
</head>
<body>
    <h1>Aggiungi Recensione</h1>
    <form action="index.php?url=addReview" method="post">
        <label for="gita_id">Gita:</label>
        <select id="gita_id" name="gita_id" required>
            <?php
                // Recupera le gite approvate per l'utente loggato
                session_start();
                $userId = $_SESSION['id'];
                $query = $pdo->prepare("SELECT gita.id, gita.nome FROM appartiene JOIN gita ON appartiene.g_id = gita.id WHERE appartiene.u_id = ? AND appartiene.approvato = 1");
                $query->execute([$userId]);
                while ($row = $query->fetch()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
            ?>
        </select><br>

        <label for="stelle">Stelle (1-5):</label>
        <input type="number" id="stelle" name="stelle" min="1" max="5" required><br>

        <label for="testo">Recensione:</label><br>
        <textarea id="testo" name="testo" rows="4" cols="50" required></textarea><br>

        <input type="submit" value="Aggiungi Recensione">
    </form>
</body>
</html>