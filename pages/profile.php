<?php
$pageTitle = "Your Profile";
$currentPage = "profile";
require_once '../includes/header.php';
?>

<div class="profile-container">
    <div class="card profile-card">
        <h2>Your Profile</h2>
        <div class="profile-info">
            <div class="profile-avatar">
                <img src="/assets/images/default-avatar.png" alt="Profile Avatar">
            </div>
            <div class="profile-details">
                <h3>Welcome, Student!</h3>
                <p class="profile-stats">
                    <span class="badge badge-primary">Questions Answered: 0</span>
                    <span class="badge badge-primary">Member Since: March 2024</span>
                </p>
            </div>
        </div>
        
        <div class="profile-answers">
            <h3>Your Recent Answers</h3>
            <div class="no-answers">
                <p>You haven't answered any questions yet.</p>
                <a href="/pages/question.php" class="btn btn-primary">Answer Your First Question</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 