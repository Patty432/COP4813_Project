<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Connect to SQLite database (creates file if not exist)
$db = new SQLite3('../Database/users.db');

// Create table if not exists
$db->exec("CREATE TABLE IF NOT EXISTS Users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    firstName TEXT NOT NULL,
    lastName TEXT NOT NULL,
    major TEXT NOT NULL,
    email TEXT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Collect form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$major = $_POST['major'];
$email = $_POST['email'];

// Prepare and insert
$stmt = $db->prepare('INSERT INTO Users (firstName, lastName, major, email) VALUES (:firstName, :lastName, :major, :email)');
$stmt->bindValue(':firstName', $firstName, SQLITE3_TEXT);
$stmt->bindValue(':lastName', $lastName, SQLITE3_TEXT);
$stmt->bindValue(':major', $major, SQLITE3_TEXT);
$stmt->bindValue(':email', $email, SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
    echo "Registration successful!";
} else {
    echo "Error: " . $db->lastErrorMsg();
}

$db->close();
?>
