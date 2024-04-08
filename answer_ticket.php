<?php
session_start();

// Include database connection
include 'db_connection.php';

// Handle status change actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $ticketId = $_GET['id'];

    // Determine the status to update based on the action
    $newStatus = ($action === 'close') ? 'Closed' : 'Open';

    // Update ticket status in the database
    $updateQuery = "UPDATE tickets SET status='$newStatus' WHERE ticket_id='$ticketId'";
    if ($conn->query($updateQuery) === TRUE) {
        // Redirect to refresh the page after status change
        header("Location: answer_ticket.php");
        exit();
    } else {
        echo "Error updating ticket status: " . $conn->error;
    }
}

// Function to fetch all tickets
function fetchTickets($conn)
{
    $query = "SELECT * FROM tickets";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display ticket information with links to close or open the case
            echo "<li><strong>{$row['subject']}</strong> - {$row['message']} - Status: {$row['status']} ";
            if ($row['status'] == 'Open') {
                echo "<a href='answer_ticket.php?action=close&id={$row['ticket_id']}'>Close</a></li>";
            } else {
                echo "<a href='answer_ticket.php?action=open&id={$row['ticket_id']}'>Open</a></li>";
            }
        }
    } else {
        echo "No tickets found.";
    }
}

?>

<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Ticket</title>
    <style>
        /* Reset default browser styles */
        body,
        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #0D1321;
            color: #FFFFFF;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #1A1D29;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        h2,
        h3 {
            color: #FFFFFF;
            text-align: center;
        }

        ul {
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #FFFFFF;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #3A3E4C;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Answer Tickets</h2>

        <!-- View Tickets Section -->
        <h3>Tickets</h3>
        <ul>
            <?php fetchTickets($conn); ?>
        </ul>
    </div>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>

</body>

</html>

