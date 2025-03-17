<?php
$pageTitle = "Question of the Day";
$currentPage = "question";
require_once '../includes/header.php';
?>

<div class="question-container">
    <div class="card question-card">
        <h2>Today's Question</h2>
        <p class="question-text">What's your favorite spot on campus and why?</p>
        
        <form class="answer-form">
            <div class="form-group">
                <label for="answer" class="form-label">Your Answer</label>
                <textarea id="answer" class="form-input" rows="5" placeholder="Share your thoughts..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Answer</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 