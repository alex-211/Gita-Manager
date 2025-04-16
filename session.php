<?php
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION['id'])) {
    header('Location: index.php?url=login');
    exit();
}