<?php
$pageTitle = "Question of the Day";
$currentPage = "question-of-the-day";
require_once __DIR__ . '/includes/header.php';
require_once 'question-of-the-day-logic.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Question of the Day</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="responsive.css">
  <link rel="stylesheet" href="components.css">
  <link rel="stylesheet" href="question-of-the-day.css">
</head>
<body>
  <div class="container">
    <?php if ($questionId > 0): ?>
      <div class="question-card card">
        <h2>Question of the Day</h2>
        <p class="question-text"><?php echo htmlspecialchars($question); ?></p>
        <p class="question-date">Today: <?php echo htmlspecialchars($question_date); ?></p>
      </div>
      <div class="answer-form card">
        <form method="POST" action="submit-answer.php">
          <input type="hidden" name="question_id" value="<?php echo $questionId; ?>">
          <div class="form-group">
            <label for="email" class="form-label">Your @scu.edu Email:</label>
            <input type="email"
                   id="email"
                   name="email"
                   placeholder="you@scu.edu"
                   required
                   pattern="^[A-Za-z0-9._%+-]+@scu\.edu$"
                   title="Please enter a valid @scu.edu email address"
                   class="form-input">
          </div>
          <div class="form-group">
            <label for="answer" class="form-label">Your Answer:</label>
            <textarea id="answer"
                      name="answer"
                      placeholder="Enter your answer here..."
                      required
                      class="form-input"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit Answer</button>
        </form>
      </div>
    <?php endif; ?>

    <div class="answers">
      <h3>Answers</h3>
      <?php if (!empty($answers)): ?>
        <div class="question-card">
          <?php foreach ($answers as $a): ?>
            <div class="answer-item card">
              <strong><?php echo htmlspecialchars($a['email']); ?></strong><br>
              <?php echo htmlspecialchars($a['answer']); ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p>No answers submitted yet.</p>
      <?php endif; ?>
    </div>
  </div>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>