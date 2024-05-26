<?php

$servername = "localhost";
$email = "root";
$password = "";
$dbname = "stij3074_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $email, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

?>