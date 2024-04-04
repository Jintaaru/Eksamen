<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
 
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_ticket'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert ticket into database
    $insert_query = "INSERT INTO tickets (user_id, subject, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iss", $user_id, $subject, $message);
    if ($stmt->execute()) {
        echo "Ticket submitted successfully!";
    } else {
        echo "Error submitting ticket: " . $stmt->error;
    }
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Ticket</title>
</head>
<body>
    <h2>Submit a Ticket</h2>
    <form action="submit_ticket.php" method="post">
        <input type="text" name="subject" placeholder="Subject" required><br>
        <textarea name="message" rows="4" placeholder="Message" required></textarea><br>
        <input type="submit" name="submit_ticket" value="Submit Ticket">
    </form>
    <a href="user_tickets.php">See dine billeter</a>
</body>
</html>
