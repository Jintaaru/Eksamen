<?php
session_start();

// Include the database connection
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's tickets from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tickets WHERE user_id = $user_id";
$result = $conn->query($sql);

// Check if there are any tickets
if ($result->num_rows > 0) {
    // Tickets found, display them
    while ($row = $result->fetch_assoc()) {
        echo "Ticket ID: " . $row['ticket_id'] . "<br>";
        echo "Subject: " . $row['subject'] . "<br>";
        echo "Message: " . $row['message'] . "<br>";
        echo "Status: " . $row['status'] . "<br>";
        echo "Created At: " . $row['created_at'] . "<br><br>";
    }
} else {
    // No tickets found
    echo "No tickets found.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Tickets</title>
    <style>
        /* Common styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #0D1321;
            color: #FFFFFF;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Horizontally center content */
            align-items: center; /* Vertically center content */
            height: 100vh; /* Make sure the body covers the entire viewport height */
        }

        .container {
            max-width: 800px;
            padding: 20px;
            background-color: #0D1321; /* Background color of the container */
            border-radius: 10px; /* Rounded corners for the container */
           
        }

        h2 {
            color: #FFFFFF;
            margin-bottom: 20px;
        }

        /* Ticket styles */
        .ticket {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #0D1321; /* Background color of each ticket */
            border: 1px solid #FFFFFF;
            border-radius: 5px;
        }

        .ticket p {
            margin: 0;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Tickets</h2>
        <?php
        // Display tickets
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="ticket">';
                echo '<p><strong>Ticket ID:</strong> ' . $row['ticket_id'] . '</p>';
                echo '<p><strong>Subject:</strong> ' . $row['subject'] . '</p>';
                echo '<p><strong>Message:</strong> ' . $row['message'] . '</p>';
                echo '<p><strong>Status:</strong> ' . $row['status'] . '</p>';
                echo '<p><strong>Created At:</strong> ' . $row['created_at'] . '</p>';
                echo '</div>';
            }
        } else {
            // No tickets found
            echo "No tickets found.";
        }
        ?>
        <a href="submit_ticket.php">Submit a New Ticket</a>
    </div>
</body>
</html>
