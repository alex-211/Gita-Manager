<?php
namespace Model;

class GiteModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllGite()
    {
        $stmt = $this->pdo->query("SELECT gita.id, gita.nome, gita.data_inizio, gita.data_fine, meta.citta, meta.prezzo FROM gita JOIN meta ON gita.m_id = meta.id");
        return $stmt->fetchAll();
    }

    public function getApprovedGite($userId)
    {
        $stmt = $this->pdo->prepare("SELECT gita.id, gita.nome, gita.data_inizio, gita.data_fine, meta.citta, meta.prezzo FROM appartiene JOIN gita ON appartiene.g_id = gita.id JOIN meta ON gita.m_id = meta.id WHERE appartiene.u_id = ? AND appartiene.approvato = 1");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAvailableGiteForUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT gita.id, gita.nome FROM appartiene JOIN gita ON appartiene.g_id = gita.id WHERE appartiene.u_id = ? AND appartiene.approvato = 1");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function addGita($nome, $data_inizio, $data_fine, $meta, $max_partecipanti)
    {
        $stmt = $this->pdo->prepare("INSERT INTO gita (nome, data_inizio, data_fine, m_id, `max-partecipanti`) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $data_inizio, $data_fine, $meta, $max_partecipanti]);
    }

    public function addReview($testo, $stelle, $userId, $gita_id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO recensione (testo, stelle, utente_id, gita_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$testo, $stelle, $userId, $gita_id]);
    }

    public function getAllGiteForPRF()
    {
        $stmt = $this->pdo->query("SELECT gita.id, gita.nome, gita.data_inizio, gita.data_fine, meta.citta, meta.prezzo FROM gita JOIN meta ON gita.m_id = meta.id");
        return $stmt->fetchAll();
    }
}