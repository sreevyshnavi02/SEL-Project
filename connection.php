<?php
    session_start();
    $dsn = 'mysql:host=localhost;dbname=sel_project';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

?>
