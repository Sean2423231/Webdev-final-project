<?php
// question-of-the-day-logic.php
date_default_timezone_set('America/Los_Angeles');
$databaseFile = __DIR__ . '/webdev.sqlite';

try {
    $pdo = new PDO('sqlite:' . $databaseFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

    $today = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT id, question, question_date FROM questions_of_the_day 
                           WHERE question_date = :today ORDER BY RANDOM() LIMIT 1");
    $stmt->bindParam(':today', $today, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $question = $row['question'];
        $questionId = $row['id'];
        $question_date = $row['question_date'];
    } else {
        $question = "No question available for today.";
        $questionId = 0;
        $question_date = "";
    }

    $answers = [];
    if ($questionId > 0) {
        $stmt = $pdo->prepare("SELECT answer, email FROM answers 
                               WHERE question_id = :qid ORDER BY date_added ASC");
        $stmt->bindParam(':qid', $questionId, PDO::PARAM_INT);
        $stmt->execute();
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>