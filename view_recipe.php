<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$recipe_id = $_GET['id'];

// Fetch recipe details
$recipe_sql = "SELECT * FROM coffee_recipes WHERE id = '$recipe_id'";
$recipe_result = $conn->query($recipe_sql);
$recipe = $recipe_result->fetch_assoc();

if (!$recipe) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['name']); ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="submit_recipe.php">Submit Coffee Recipe</a></li>
            <li>
                <form method="POST