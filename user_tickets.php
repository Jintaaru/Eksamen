<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in

}

// Include database connection
include 'db_connection.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Retrieve user's tickets from the database
$select_query = "SELECT * FROM tickets WHERE user_id = ?";
$stmt = $conn->prepare($select_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tickets</title>
</head>
<body>
    <h2>Your Tickets</h2>
    <?php
    // Display user's tickets
    while ($row = $result->fetch_assoc()) {
        echo "<strong>Subject:</strong> " . $row['subject'] . "<br>";
        echo "<strong>Message:</strong> " . $row['message'] . "<br><br>";
    }
    ?>
</body>
</html>
