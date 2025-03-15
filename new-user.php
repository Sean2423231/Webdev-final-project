// THIS WILL PROBABLY BE SCRAPPED<?php
try {
    // Create (or open) the SQLite database file in the current directory.
    $pdo = new PDO('sqlite:' . __DIR__ . '/database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the users table if it doesn't already exist.
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL
    )");

    // Prepare an INSERT statement to add a new user.
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

    // Example user data. Replace these with data from a form or other sources as needed.
    $username = 'newusername';
    $email = 'newuser@example.com';
    $password = password_hash('secret', PASSWORD_DEFAULT);

    // Execute the query with the provided values.
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
    ]);

    echo "New user added successfully!";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
