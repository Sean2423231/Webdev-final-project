<?php
session_start();
$pageTitle = "Question of the Day";
$currentPage = "question";
require_once '../includes/header.php';

// Initialize answers array in session if it doesn't exist
if (!isset($_SESSION['answers'])) {
    $_SESSION['answers'] = [];
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['answer'])) {
    $answer = [
        'question' => "What's your favorite spot on campus and why?",
        'answer' => $_POST['answer'],
        'date' => date('F j, Y')
    ];
    
    // Add answer to the beginning of the array (most recent first)
    array_unshift($_SESSION['answers'], $answer);
    
    // Keep only the 5 most recent answers
    if (count($_SESSION['answers']) > 5) {
        array_pop($_SESSION['answers']);
    }
    
    $message = '<div class="alert alert-success">Your answer has been submitted successfully!</div>';
}
?>

<div class="question-container">
    <div class="card question-card">
        <h2>Today's Question</h2>
        <p class="question-text">What's your favorite spot on campus and why?</p>
        
        <?php if ($message): ?>
            <?php echo $message; ?>
        <?php endif; ?>
        
        <form class="answer-form" method="POST" action="">
            <div class="form-group">
                <label for="answer" class="form-label">Your Answer</label>
                <textarea id="answer" name="answer" class="form-input" rows="5" placeholder="Share your thoughts..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Answer</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 