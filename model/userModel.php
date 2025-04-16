<?php
namespace Model;

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM utente");
        return $stmt->fetchAll();
    }

    public function createUser($nome, $cognome, $email, $password, $classe)
    {
        $stmt = $this->pdo->prepare("INSERT INTO utente (nome, cognome, email, password, classe) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $cognome, $email, $password, $classe]);
    }

    public function authenticateUserByEmail($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utente WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]);
        $user = $stmt->fetch();

        // Debug log to verify query results
        error_log("Query executed for email: $email");
        if ($user) {
            error_log("User found: " . print_r($user, true));
        } else {
            error_log("No user found for email: $email");
        }

        return $user;
    }
}