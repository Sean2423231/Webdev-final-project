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

// Retrieve a random question
$sql = "SELECT question FROM questions_of_the_day ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $question = $row['question'];
} else {
    $question = "No question available for today.";
}

$conn->close();
?>