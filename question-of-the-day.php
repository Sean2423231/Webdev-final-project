<?php require_once 'question-of-the-day-logic.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Question of the Day</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Question of the Day</h1>
        <?php if ($questionId > 0): ?>
            <div class="question">
                <p class="question-text"><?php echo htmlspecialchars($question); ?></p>
                <p class="question-date">Scheduled for: <?php echo htmlspecialchars($question_date); ?></p>
            </div>
            <form method="POST" action="submit-answer.php">
                <input type="hidden" name="question_id" value="<?php echo $questionId; ?>">
                <label for="email">Your @scu.edu Email:</label><br>
                <input type="email" id="email" name="email" placeholder="you@scu.edu" required
                       pattern="^[A-Za-z0-9._%+-]+@scu\.edu$"
                       title="Please enter a valid @scu.edu email address"><br><br>
                <textarea class="answer" name="answer" placeholder="Enter your answer here..." required></textarea><br>
                <button type="submit" class="btn btn-primary">Submit Answer</button>
            </form>
        <?php else: ?>
            <p><?php echo htmlspecialchars($question); ?></p>
        <?php endif; ?>
        <div class="answers">
            <h3>Answers</h3>
            <?php if (!empty($answers)): ?>
                <?php foreach ($answers as $a): ?>
                    <div class="answer-item">
                        <strong><?php echo htmlspecialchars($a['email']); ?></strong><br>
                        <?php echo htmlspecialchars($a['answer']); ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No answers submitted yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>