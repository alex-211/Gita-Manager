<?php
$host = 'localhost';
$dbname = 'gite2';
$username = 'php';
$password = 'php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Non riesco a connettermi al database $dbname: " . $e->getMessage());
}