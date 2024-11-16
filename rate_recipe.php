<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recipe_id'], $_POST['rating'])) {
    $recipe_id = $_POST['recipe_id'];
    $rating = $_POST['rating'];

    // Check if the user has already rated this recipe
    $check_rating_sql = "SELECT * FROM ratings WHERE recipe_id = '$recipe_id' AND user_id = '$user_id'";
    $check_result = $conn->query($check_rating_sql);

    if ($check_result->num_rows > 0) {
        // Update existing rating
        $update_rating_sql = "UPDATE ratings SET rating = '$rating' WHERE recipe_id = '$recipe_id' AND user_id = '$user_id'";
        $conn->query($update_rating_sql);
    } else {
        // Insert new rating
        $insert_rating_sql = "INSERT INTO ratings (recipe_id, user_id, rating) VALUES ('$recipe_id', '$user_id', '$rating')";
        $conn->query($insert_rating_sql);
    }

    header('Location: index.php?message=Rating submitted successfully');
    exit();
} else {
    header('Location: index.php?error=Invalid request');
    exit();
}