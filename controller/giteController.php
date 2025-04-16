<?php
namespace Controller;

require_once __DIR__ . '/../model/giteModel.php';

use Model\GiteModel;

class GiteController
{
    private $pdo;
    private $giteModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->giteModel = new GiteModel($pdo);
    }

    public function addGita($nome, $data_inizio, $data_fine, $meta, $max_partecipanti)
    {
        // Controlla se l'utente è un professore
        session_start();
        if ($_SESSION['classe'] !== 'PRF') {
            echo "<script>alert('Accesso negato: solo i professori possono aggiungere gite.'); window.location.href = 'index.php';</script>";
            return;
        }

        // Inserisce la gita nel database
        $stmt = $this->pdo->prepare("INSERT INTO gita (nome, data_inizio, data_fine, m_id, `max-partecipanti`) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $data_inizio, $data_fine, $meta, $max_partecipanti]);

        echo "<script>alert('Gita aggiunta con successo!'); window.location.href = 'index.php';</script>";
    }

    public function joinGita($gita_id)
    {
        session_start();
        $userId = $_SESSION['id'];

        // Controlla se la gita è piena
        $query = $this->pdo->prepare("SELECT COUNT(*) as count, `max-partecipanti` FROM appartiene JOIN gita ON appartiene.g_id = gita.id WHERE gita.id = ?");
        $query->execute([$gita_id]);
        $result = $query->fetch();

        if ($result['count'] >= $result['max-partecipanti']) {
            echo "<script>alert('La gita è piena. Non puoi iscriverti.'); window.location.href = 'index.php?url=myGite';</script>";
            return;
        }

        // Controlla se l'utente è già iscritto
        $query = $this->pdo->prepare("SELECT * FROM appartiene WHERE u_id = ? AND g_id = ?");
        $query->execute([$userId, $gita_id]);

        if ($query->rowCount() > 0) {
            echo "<script>alert('Sei già iscritto a questa gita.'); window.location.href = 'index.php?url=myGite';</script>";
            return;
        }

        // Inserisce l'iscrizione con approvazione automatica per PRF
        $approvato = ($_SESSION['classe'] === 'PRF') ? 1 : 0;
        $stmt = $this->pdo->prepare("INSERT INTO appartiene (u_id, g_id, gestisce, approvato) VALUES (?, ?, 0, ?)");
        $stmt->execute([$userId, $gita_id, $approvato]);

        echo "<script>alert('Iscrizione effettuata con successo.'); window.location.href = 'index.php?url=myGite';</script>";
    }

    public function addReview($gita_id, $stelle, $testo)
    {
        session_start();
        $userId = $_SESSION['id'];

        // Inserisce la recensione nel database
        $stmt = $this->pdo->prepare("INSERT INTO recensione (testo, stelle, utente_id, gita_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$testo, $stelle, $userId, $gita_id]);

        echo "<script>alert('Recensione aggiunta con successo!'); window.location.href = 'index.php?url=myGite';</script>";
    }

    public function editGita($gitaId, $nome, $data_inizio, $data_fine, $meta, $max_partecipanti)
    {
        session_start();
        if ($_SESSION['classe'] !== 'PRF') {
            echo "<script>alert('Accesso negato: solo i professori possono modificare le gite.'); window.location.href = 'index.php';</script>";
            return;
        }

        $stmt = $this->pdo->prepare("UPDATE gita SET nome = ?, data_inizio = ?, data_fine = ?, m_id = ?, `max-partecipanti` = ? WHERE id = ?");
        $stmt->execute([$nome, $data_inizio, $data_fine, $meta, $max_partecipanti, $gitaId]);

        echo "<script>alert('Gita modificata con successo!'); window.location.href = 'index.php';</script>";
    }

    public function getStudentsForGita($gitaId)
    {
        $stmt = $this->pdo->prepare("SELECT utente.id, utente.nome, utente.cognome, utente.classe, appartiene.approvato FROM appartiene JOIN utente ON appartiene.u_id = utente.id WHERE appartiene.g_id = ?");
        $stmt->execute([$gitaId]);
        return $stmt->fetchAll();
    }

    public function approveStudent($gitaId, $studentId)
    {
        session_start();
        if ($_SESSION['classe'] !== 'PRF') {
            echo "<script>alert('Accesso negato: solo i professori possono approvare gli studenti.'); window.location.href = 'index.php';</script>";
            return;
        }

        $stmt = $this->pdo->prepare("UPDATE appartiene SET approvato = 1 WHERE g_id = ? AND u_id = ?");
        $stmt->execute([$gitaId, $studentId]);

        echo "<script>alert('Studente approvato con successo!'); window.location.href = 'index.php?url=editGita&gita_id=$gitaId';</script>";
    }

    public function getToursForGita($gitaId)
    {
        $stmt = $this->pdo->prepare("SELECT tour.id, tour.nome, tour.prezzo, tour.descrizione FROM include JOIN tour ON include.t_id = tour.id WHERE include.g_id = ?");
        $stmt->execute([$gitaId]);
        return $stmt->fetchAll();
    }

    public function addTour($gitaId, $nome, $prezzo, $descrizione)
    {
        session_start();
        if ($_SESSION['classe'] !== 'PRF') {
            echo "<script>alert('Accesso negato: solo i professori possono aggiungere tour.'); window.location.href = 'index.php';</script>";
            return;
        }

        // Inserisce il tour nel database
        $stmt = $this->pdo->prepare("INSERT INTO tour (nome, prezzo, descrizione) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $prezzo, $descrizione]);

        // Ottiene l'ID del tour appena inserito
        $tourId = $this->pdo->lastInsertId();

        // Inserisce la relazione tra il tour e la gita nella tabella include
        $stmt = $this->pdo->prepare("INSERT INTO include (g_id, t_id) VALUES (?, ?)");
        $stmt->execute([$gitaId, $tourId]);

        echo "<script>alert('Tour aggiunto con successo!'); window.location.href = 'index.php?url=viewGita&gita_id=$gitaId';</script>";
    }

    public function editTour($tourId, $nome, $prezzo, $descrizione)
    {
        session_start();
        if ($_SESSION['classe'] !== 'PRF') {
            echo "<script>alert('Accesso negato: solo i professori possono modificare i tour.'); window.location.href = 'index.php';</script>";
            return;
        }

        $stmt = $this->pdo->prepare("UPDATE tour SET nome = ?, prezzo = ?, descrizione = ? WHERE id = ?");
        $stmt->execute([$nome, $prezzo, $descrizione, $tourId]);

        echo "<script>alert('Tour modificato con successo!'); window.location.href = 'index.php';</script>";
    }

    public function deleteTour($tourId)
    {
        session_start();
        if ($_SESSION['classe'] !== 'PRF') {
            echo "<script>alert('Accesso negato: solo i professori possono eliminare i tour.'); window.location.href = 'index.php';</script>";
            return;
        }

        $stmt = $this->pdo->prepare("DELETE FROM tour WHERE id = ?");
        $stmt->execute([$tourId]);

        echo "<script>alert('Tour eliminato con successo!'); window.location.href = 'index.php';</script>";
    }

    public function deleteGita($gitaId)
    {
        session_start();
        if ($_SESSION['classe'] !== 'PRF') {
            echo "<script>alert('Accesso negato: solo i professori possono eliminare le gite.'); window.location.href = 'index.php';</script>";
            return;
        }

        // Elimina la gita dal database
        $stmt = $this->pdo->prepare("DELETE FROM gita WHERE id = ?");
        $stmt->execute([$gitaId]);

        echo "<script>alert('Gita eliminata con successo!'); window.location.href = 'index.php?url=myGite';</script>";
    }

    public function getAllGite()
    {
        $stmt = $this->pdo->query("SELECT gita.id, gita.nome, gita.data_inizio, gita.data_fine, meta.citta, meta.prezzo FROM gita JOIN meta ON gita.m_id = meta.id");
        return $stmt->fetchAll();
    }

    public function getApprovedGiteByUser($userId)
    {
        return $this->giteModel->getApprovedGite($userId);
    }

    public function getGitaDetails($gitaId)
    {
        $stmt = $this->pdo->prepare("SELECT gita.id, gita.nome, gita.data_inizio, gita.data_fine, meta.citta, meta.prezzo FROM gita JOIN meta ON gita.m_id = meta.id WHERE gita.id = ?");
        $stmt->execute([$gitaId]);
        return $stmt->fetch();
    }

    public function getTourByGita($gitaId)
    {
        $stmt = $this->pdo->prepare("SELECT tour.id, tour.nome, tour.prezzo, tour.descrizione FROM include JOIN tour ON include.t_id = tour.id WHERE include.g_id = ?");
        $stmt->execute([$gitaId]);
        return $stmt->fetchAll();
    }
}