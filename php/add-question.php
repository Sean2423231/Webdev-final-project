<?php
$databaseFile = __DIR__ . '/webdev.sqlite';

try {
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they don't exist.
    $pdo->exec("CREATE TABLE IF NOT EXISTS questions_of_the_day (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        question TEXT NOT NULL,
        question_date DATE NOT NULL,
        date_added DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS answers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        question_id INTEGER,
        answer TEXT NOT NULL,
        date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(question_id) REFERENCES questions_of_the_day(id)
    )");

    // Check if the 'question_date' column exists.
    $stmt = $pdo->query("PRAGMA table_info(questions_of_the_day)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $columnExists = false;
    foreach ($columns as $column) {
        if ($column['name'] === 'question_date') {
            $columnExists = true;
            break;
        }
    }
    if (!$columnExists) {
        $pdo->exec("ALTER TABLE questions_of_the_day 
                    ADD COLUMN question_date DATE NOT NULL DEFAULT '2025-01-01'");
    }

    // Handle form submission for adding/updating a question.
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question'], $_POST['question_date'])) {
        $question = $_POST['question'];
        $question_date = $_POST['question_date']; // Expected format: YYYY-MM-DD

        // Check if a question already exists for the submitted date.
        $checkStmt = $pdo->prepare("
            SELECT id FROM questions_of_the_day 
            WHERE question_date = :question_date 
            LIMIT 1
        ");
        $checkStmt->bindParam(':question_date', $question_date, PDO::PARAM_STR);
        $checkStmt->execute();
        $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Update the existing question.
            $updateStmt = $pdo->prepare("
                UPDATE questions_of_the_day
                SET question = :question, date_added = CURRENT_TIMESTAMP
                WHERE id = :id
            ");
            $updateStmt->bindParam(':question', $question, PDO::PARAM_STR);
            $updateStmt->bindParam(':id', $existing['id'], PDO::PARAM_INT);
            if ($updateStmt->execute()) {
                echo "Question for $question_date updated successfully. ";
                echo "<a href='question-of-the-day.php'>Go to Question of the Day</a>";
                exit();
            } else {
                echo "Error: Could not update question.";
            }
        } else {
            // Insert a new question.
            $insertStmt = $pdo->prepare("
                INSERT INTO questions_of_the_day (question, question_date)
                VALUES (:question, :question_date)
            ");
            $insertStmt->bindParam(':question', $question, PDO::PARAM_STR);
            $insertStmt->bindParam(':question_date', $question_date, PDO::PARAM_STR);
            if ($insertStmt->execute()) {
                echo "New question added successfully. ";
                echo "<a href='question-of-the-day.php'>Go to Question of the Day</a>";
                exit();
            } else {
                echo "Error: Could not insert question.";
            }
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Question of the Day</title>
    <!-- Add existing CSS files for styling -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components.css">
    <link rel="stylesheet" href="responsive.css">
</head>
<body>
    <h2>Add New Question of the Day</h2>
    <form method="POST" action="add-question.php">
        <label for="question">Question:</label><br>
        <textarea id="question"
                  name="question"
                  placeholder="Enter the question here..."
                  required></textarea><br><br>

        <label for="question_date">Question Date (YYYY-MM-DD):</label><br>
        <input type="date" id="question_date" name="question_date" required><br><br>

        <button type="submit">Add / Update Question</button>
    </form>

    <hr>

    <?php
    // LIST REQUESTED QUESTIONS
    $requestedDbFile = __DIR__ . '/requested-questions.sqlite';
    if (file_exists($requestedDbFile)) {
        try {
            $pdoReq = new PDO('sqlite:' . $requestedDbFile);
            $pdoReq->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch all requested questions
            $reqData = $pdoReq->query("
                SELECT question, email, date_added
                FROM requested_questions
                ORDER BY date_added DESC
            ")->fetchAll(PDO::FETCH_ASSOC);

            if ($reqData) {
                echo "<h3>Requested Questions</h3>";
                echo "<ul>";
                foreach ($reqData as $rq) {
                    echo "<li><strong>" 
                         . htmlspecialchars($rq['email']) 
                         . ":</strong> "
                         . htmlspecialchars($rq['question']) 
                         . " <em>(" . htmlspecialchars($rq['date_added']) . ")</em></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No requested questions found.</p>";
            }
        } catch (PDOException $ex) {
            echo "Error reading requested-questions DB: " . $ex->getMessage();
        }
    } else {
        echo "<p>No requested-questions.sqlite database found.</p>";
    }
    ?>
</body>
</html>