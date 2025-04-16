<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Gita</title>
</head>
<body>
    <?php require_once __DIR__ . '/../session.php'; ?>
    <h1>Aggiungi Gita</h1>
    <form action="index.php?url=addGita" method="post">
        <label for="nome">Nome Gita:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="data_inizio">Data Inizio:</label>
        <input type="date" id="data_inizio" name="data_inizio" required><br>

        <label for="data_fine">Data Fine:</label>
        <input type="date" id="data_fine" name="data_fine" required><br>

        <label for="meta">Meta:</label>
        <select id="meta" name="meta" required>
            <?php
                // Recupera le mete dal database
                $query = $pdo->query("SELECT id, citta FROM meta");
                while ($row = $query->fetch()) {
                    echo "<option value='{$row['id']}'>{$row['citta']}</option>";
                }
            ?>
        </select><br>

        <label for="max_partecipanti">Numero massimo di partecipanti:</label>
        <input type="number" id="max_partecipanti" name="max_partecipanti" required><br>

        <input type="submit" value="Aggiungi Gita">
    </form>
</body>
</html>