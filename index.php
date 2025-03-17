<?php
$pageTitle = "Home";
$currentPage = "home";
require_once 'includes/header.php';
?>

<div class="hero-section">
    <h1>Welcome to Ask You SCU</h1>
    <p>Your daily dose of thought-provoking questions and community engagement.</p>
</div>

<div class="features-grid">
    <div class="card">
        <h2>Question of the Day</h2>
        <p>Engage with our community by answering thought-provoking questions every day.</p>
        <a href="/pages/question.php" class="btn btn-primary">View Today's Question</a>
    </div>
    
    <div class="card">
        <h2>Your Profile</h2>
        <p>Track your participation and see your contribution history.</p>
        <a href="/pages/profile.php" class="btn btn-secondary">View Profile</a>
    </div>
    
    <div class="card">
        <h2>Community</h2>
        <p>Connect with other SCU students and share your perspectives.</p>
        <a href="/pages/contact.php" class="btn btn-primary">Get Involved</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 