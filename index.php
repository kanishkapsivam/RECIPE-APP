<?php
session_start();
include 'db.php';

// Fetch user information if logged in
$user = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_sql = "SELECT username, profile_picture FROM users WHERE id = '$user_id'";
    $user_result = $conn->query($user_sql);
    $user = $user_result->fetch_assoc();
}

// Fetch all coffee recipes
$recipes_sql = "SELECT * FROM coffee_recipes";
$recipes_result = $conn->query($recipes_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Recipe List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="submit_recipe.php">Submit Coffee Recipe</a></li>
            <li>
                <form method="POST" action="search.php" class="search-form">
                    <input type="text" name="search_term" placeholder="Search Coffee Recipes" required>
                    <button type="submit">Search</button>
                </form>
            </li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="user-overview">
        <?php if ($user): ?>
            <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
            <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" width="50">
            <p><a href="profile.php">View Profile</a></p>
        <?php else: ?>
            <p><a href="login.php">Login</a> to see your profile.</p>
        <?php endif; ?>
    </div>

    <h2>Available Coffee Recipes</h2>
    <?php if ($recipes_result->num_rows > 0): ?>
        <ul>
            <?php while ($recipe = $recipes_result->fetch_assoc()): ?>
                <li>
                    <h3><a href="view_recipe.php?id=<?php echo $recipe['id']; ?>"><?php echo htmlspecialchars($recipe['name']); ?></a></h3>
                    <p><?php echo htmlspecialchars($recipe['description']); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No coffee recipes available at the moment.</p>
    <?php endif; ?>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Coffee Recipe Management</p>
    </footer>
</body>
</html>