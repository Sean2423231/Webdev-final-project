<?php
$servername = "localhost";
$username   = "root";      // update as needed
$password   = "";          // update as needed
$dbname     = "webdev";     // update as needed

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the table if it doesn't exist
$tableSql = "CREATE TABLE IF NOT EXISTS questions_of_the_day (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($tableSql) === TRUE) {
    echo "Table created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert sample questions
$insertSql = "INSERT INTO questions_of_the_day (question) VALUES 
('What is your question of the day?'),
('How do you define success?'),
('What motivates you to be productive?')";
if ($conn->query($insertSql) === TRUE) {
    echo "Questions inserted successfully.";
} else {
    echo "Error inserting questions: " . $conn->error;
}

$conn->close();
?>