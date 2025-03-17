<?php
session_start();
require_once 'db_setup.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

$pageTitle = "Profile";
$currentPage = "profile";
require_once 'includes/header.php';

// Get user's answers
try {
    $db = new SQLite3('webdev.sqlite');
    $stmt = $db->prepare('
        SELECT a.*, q.question 
        FROM answers a 
        JOIN questions q ON a.question_id = q.id 
        WHERE a.user_id = :user_id 
        ORDER BY a.created_at DESC
    ');
    $stmt->bindValue(':user_id', $_SESSION['user_id'], SQLITE3_INTEGER);
    $result = $stmt->execute();
} catch (Exception $e) {
    $error = 'Failed to load answers.';
}
?>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="/images/default-avatar.png" alt="Profile Avatar">
        </div>
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
            <p class="profile-email"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
        </div>
    </div>

    <div class="profile-content">
        <h2>Your Answers</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <?php if ($result && $result->numColumns() > 0): ?>
                <div class="answers-list">
                    <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
                        <div class="answer-card">
                            <div class="answer-question">
                                <h3><?php echo htmlspecialchars($row['question']); ?></h3>
                                <span class="answer-date">
                                    <?php echo date('F j, Y', strtotime($row['created_at'])); ?>
                                </span>
                            </div>
                            <div class="answer-content">
                                <?php echo nl2br(htmlspecialchars($row['answer'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="no-answers">You haven't submitted any answers yet.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 