<?php
$pageTitle = "Contact Us";
$currentPage = "contact";
require_once '../includes/header.php';
?>

<div class="contact-container">
    <div class="card contact-card">
        <h2>Contact Us</h2>
        <p class="contact-intro">Have questions or suggestions? We'd love to hear from you!</p>
        
        <form class="contact-form">
            <div class="form-group">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" id="name" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" id="email" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" id="subject" class="form-input" required>
            </div>
            
            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" class="form-input" rows="5" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?> 