<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . " - Ask You SCU" : "Ask You SCU"; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="/assets/js/main.js" defer></script>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <div class="logo">
                <a href="/">Ask You SCU</a>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="/" class="<?php echo $currentPage === 'home' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="/pages/question.php" class="<?php echo $currentPage === 'question' ? 'active' : ''; ?>">Question of the Day</a></li>
                    <li><a href="/pages/profile.php" class="<?php echo $currentPage === 'profile' ? 'active' : ''; ?>">Profile</a></li>
                    <li><a href="/pages/contact.php" class="<?php echo $currentPage === 'contact' ? 'active' : ''; ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="main-content"> 