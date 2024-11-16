<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO recipes (name, description, user_id) VALUES ('$name', '$description', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php?message=Recipe submitted successfully');
        exit();
 } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Recipe</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="form-container">
        <h2>Submit a Recipe</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="name">Recipe Name:</label>
            <input type="text" name="name" required>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <button type="submit">Submit Recipe</button>
        </form>
    </div>
</body>
</html>