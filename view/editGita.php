<?php
$gitaDetails = $giteController->getGitaDetails($gitaId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Gita</title>
</head>
<body>
    <h1>Modifica Gita</h1>
    <form action="index.php?url=editGita&gita_id=<?php echo $gitaId; ?>" method="post">
        <label for="nome">Nome Gita:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $gitaDetails['nome']; ?>" required><br>

        <label for="data_inizio">Data Inizio:</label>
        <input type="date" id="data_inizio" name="data_inizio" value="<?php echo $gitaDetails['data_inizio']; ?>" required><br>

        <label for="data_fine">Data Fine:</label>
        <input type="date" id="data_fine" name="data_fine" value="<?php echo $gitaDetails['data_fine']; ?>" required><br>

        <label for="meta">Meta:</label>
        <select id="meta" name="meta" required>
            <?php
                foreach ($giteController->getAllMete() as $meta) {
                    $selected = $meta['id'] == $gitaDetails['m_id'] ? 'selected' : '';
                    echo "<option value='{$meta['id']}' $selected>{$meta['citta']}</option>";
                }
            ?>
        </select><br>

        <label for="max_partecipanti">Numero massimo di partecipanti:</label>
        <input type="number" id="max_partecipanti" name="max_partecipanti" value="<?php echo $gitaDetails['max-partecipanti']; ?>" required><br>

        <input type="submit" value="Salva Modifiche">
    </form>

    <h2>Gestione Studenti</h2>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Classe</th>
            <th>Approvazione</th>
        </tr>
        <?php
        $students = $giteController->getStudentsForGita($gitaId);
        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>{$student['nome']}</td>";
            echo "<td>{$student['cognome']}</td>";
            echo "<td>{$student['classe']}</td>";
            echo "<td>";
            if ($student['approvato'] == 0) {
                echo "<form action='index.php?url=approveStudent&gita_id={$gitaId}&student_id={$student['id']}' method='post'>";
                echo "<button type='submit'>Approva</button>";
                echo "</form>";
            } else {
                echo "Approvato";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>