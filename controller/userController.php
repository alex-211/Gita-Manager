<?php
namespace Controller;

require_once __DIR__ . '/../model/userModel.php';

use Model\UserModel;

class UserController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new UserModel($pdo);
    }

    public function signup($nome, $cognome, $email, $password, $classe)
    {
        $this->userModel->createUser($nome, $cognome, $email, $password, $classe);
        echo "<script>alert('Registrazione completata con successo!'); window.location.href = 'index.php?url=login';</script>";
    }

    public function login($email, $password)
    {
        $user = $this->userModel->authenticateUserByEmail($email, $password);
        if ($user) {
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['classe'] = $user['classe'];
            echo "<script>alert('Login effettuato con successo!'); window.location.href = 'index.php?url=myGite';</script>";
        } else {
            echo "<script>alert('Credenziali non valide!'); window.location.href = 'index.php?url=login';</script>";
        }
    }
}