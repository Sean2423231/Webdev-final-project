<?php
session_start();
$pageTitle = "Your Profile";
$currentPage = "profile";
require_once '../includes/header.php';

// Get recent answers from session or database (we'll simulate for now)
$hasAnswers = isset($_SESSION['answers']) && !empty($_SESSION['answers']);
$recentAnswers = $hasAnswers ? $_SESSION['answers'] : [];
?>

<div class="profile-container">
    <div class="card profile-card">
        <h2>Your Profile</h2>
        <div class="profile-info">
            <div class="profile-avatar">
                <div class="avatar-placeholder">S</div>
            </div>
            <div class="profile-details">
                <h3>Welcome, Student!</h3>
                <p class="profile-stats">
                    <span class="badge badge-primary">Questions Answered: <?php echo count($recentAnswers); ?></span>
                    <span class="badge badge-primary">Member Since: March 2025</span>
                </p>
            </div>
        </div>
        
        <div class="profile-answers">
            <h3>Your Recent Answers</h3>
            <?php if ($hasAnswers): ?>
                <div class="answers-list">
                    <?php foreach ($recentAnswers as $answer): ?>
                        <div class="answer-item">
                            <span class="answer-date"><?php echo $answer['date']; ?></span>
                            <p class="answer-text"><?php echo htmlspecialchars($answer['answer']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-answers">
                    <p>You haven't answered any questions yet.</p>
                    <a href="../pages/question.php" class="btn btn-primary">Answer Your First Question</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 