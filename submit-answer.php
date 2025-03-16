<?php
$databaseFile = __DIR__ . '/webdev.sqlite';

try {
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create questions_of_the_day table if not exists.
    $pdo->exec("CREATE TABLE IF NOT EXISTS questions_of_the_day (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        question TEXT NOT NULL,
        question_date DATE NOT NULL,
        date_added DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create answers table if it doesn't exist.
    $pdo->exec("CREATE TABLE IF NOT EXISTS answers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        question_id INTEGER,
        answer TEXT NOT NULL,
        date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(question_id) REFERENCES questions_of_the_day(id)
    )");

    // Check if the 'email' column exists in the answers table.
    $stmt = $pdo->query("PRAGMA table_info(answers)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $emailExists = false;
    foreach ($columns as $column) {
        if ($column['name'] === 'email') {
            $emailExists = true;
            break;
        }
    }
    if (!$emailExists) {
        // Add the email column with a default empty string.
        $pdo->exec("ALTER TABLE answers ADD COLUMN email TEXT NOT NULL DEFAULT ''");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' 
        && isset($_POST['question_id'], $_POST['answer'], $_POST['email'])) {
        $questionId = (int) $_POST['question_id'];
        if ($questionId === 0) {
            echo "Invalid question.";
            exit();
        }
        $answer = $_POST['answer'];
        $email = trim($_POST['email']);

        // Validate the email — ensure it is a valid email and ends with @scu.edu.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@scu\.edu$/i", $email)) {
            echo "Please use a valid @scu.edu email address.";
            exit();
        }

        // Insert the answer including the email.
        $stmt = $pdo->prepare("INSERT INTO answers (question_id, answer, email) VALUES (:question_id, :answer, :email)");
        $stmt->bindParam(':question_id', $questionId, PDO::PARAM_INT);
        $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: question-of-the-day.php");
            exit();
        } else {
            echo "Error: Could not insert answer.";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>