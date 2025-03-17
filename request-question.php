<?php
$pageTitle = "Request Question";
$currentPage = "Request_Question";
require_once __DIR__ . '/includes/header.php';
$databaseFile = __DIR__ . '/requested-questions.sqlite';

try {
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if it doesn't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS requested_questions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        question TEXT NOT NULL,
        email TEXT NOT NULL,
        date_added DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // If form was posted, insert new question request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question'], $_POST['email'])) {
        $question = $_POST['question'];
        $email    = $_POST['email']; // Must match @scu.edu

        $insertStmt = $pdo->prepare("
            INSERT INTO requested_questions (question, email)
            VALUES (:question, :email)
        ");
        $insertStmt->bindParam(':question', $question, PDO::PARAM_STR);
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            echo "New request added successfully. ";
            echo "<a href='home.php'>Return Home</a>";
            exit();
        } else {
            echo "Error: Could not insert request.";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>

<h2>Request a New Question</h2>
<form method="POST" action="request-question.php">
    <label for="question">Question:</label><br>
    <textarea id="question"
              name="question"
              placeholder="Enter your question here..."
              required></textarea><br><br>

    <label for="email">Your @scu.edu Email:</label><br>
    <input type="email"
           id="email"
           name="email"
           placeholder="you@scu.edu"
           required
           pattern="^[A-Za-z0-9._%+-]+@scu\.edu$"
           title="Please enter a valid @scu.edu email address"><br><br>

    <button type="submit">Add Request</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>