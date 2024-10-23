<?php

// กำหนดค่าการเชื่อมต่อฐานข้อมูล
$host = 'db';
$db   = 'myappv2'; // ชื่อฐานข้อมูล
$user = 'user'; // ชื่อผู้ใช้ฐานข้อมูล
$pass = 'password';  // รหัสผ่านฐานข้อมูล

$dsn = "pgsql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Set the client encoding to UTF-8
    $pdo->exec("SET NAMES 'utf8'");
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
