<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion - <?php echo ucfirst($page); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php?page=about">About Us</a></li>
                <li><a href="index.php?page=recipes">Recipe Collection</a></li>
                <li><a href="index.php?page=community">Community Cookbook</a></li>
                <li><a href="index.php?page=contact">Contact Us</a></li>
                <li><a href="index.php?page=resources">Culinary Resources</a></li>
                <li><a href="index.php?page=education">Educational Resources</a></li>
            </ul>
        </nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="#" id="login-button">Login</a>
        <?php endif; ?>
    </header>
    <main>