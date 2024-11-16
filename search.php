<?php
session_start();
include 'db.php';

$search_results = [];
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $search_sql = "SELECT * FROM recipes WHERE name LIKE '%$search_term%'";
    $search_results = $conn->query($search_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Recipes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="form-container">
        <h2>Search Recipes</h2>
        <form method="POST" action="">
            <input type="text" name="search_term" placeholder="Enter recipe name" required>
            <button type="submit" name="search">Search</button>
        </form>

        <?php if (!empty($search_results)): ?>
            <h3>Search Results:</h3>
            <ul>
                <?php while ($recipe = $search_results->fetch_assoc()): ?>
                    <li>
                        <h4><?php echo htmlspecialchars($recipe['name']); ?></h4>
                        <p><?php echo htmlspecialchars($recipe['description']); ?></p>
                        <form method="POST" action="rate_recipe.php">
                            <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                            <label for="rating">Rate this recipe:</label>
                            <select name="rating" required>
                                <option value="">Select a rating</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <button type="submit">Submit Rating</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No recipes found matching your search.</p>
        <?php endif; ?>
    </div>
</body>
</html>