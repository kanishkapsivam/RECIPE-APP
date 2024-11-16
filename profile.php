<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_sql = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();

// Fetch user recipes
$recipes_sql = "SELECT * FROM recipes WHERE user_id = '$user_id'";
$recipes_result = $conn->query($recipes_sql);

// Fetch user ratings
$ratings_sql = "SELECT r.*, ra.rating FROM ratings ra JOIN recipes r ON ra.recipe_id = r.id WHERE ra .user_id = '$user_id'";
$ratings_result = $conn->query($ratings_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" width="100">
        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

        <h4>Your Recipes</h4>
        <?php if ($recipes_result->num_rows > 0): ?>
            <ul>
                <?php while ($recipe = $recipes_result->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($recipe['name']); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No recipes submitted yet.</p>
        <?php endif; ?>

        <h4>Your Ratings</h4>
        <?php if ($ratings_result->num_rows > 0): ?>
            <ul>
                <?php while ($rating = $ratings_result->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($rating['name']); ?> - Rated: <?php echo htmlspecialchars($rating['rating']); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No ratings submitted yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>