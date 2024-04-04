<?php
// Include database connection
include 'db_connection.php';

// Function to fetch all tickets
function fetchTickets($conn) {
    $query = "SELECT * FROM tickets";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>{$row['subject']}</strong> - {$row['message']} - Status: {$row['status']} ";
            echo "<a href='#' onclick='openModal({$row['ticket_id']})'>Answer</a> ";
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

// Handle status change actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $ticketId = $_GET['id'];

    if ($action === 'close') {
        $updateQuery = "UPDATE tickets SET status='Closed' WHERE ticket_id='$ticketId'";
    } elseif ($action === 'open') {
        $updateQuery = "UPDATE tickets SET status='Open' WHERE ticket_id='$ticketId'";
    }

    if ($conn->query($updateQuery) === TRUE) {
        // Redirect to refresh the page after status change
        header("Location: answer_ticket.php");
        exit();
    } else {
        echo "Error updating ticket status: " . $conn->error;
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
        /* Your CSS styles here */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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

    <!-- Modal for Answering Ticket -->
    <div id="answerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Answer Ticket</h2>
            <form id="answerForm" action="answer_ticket.php" method="post">
                <input type="hidden" id="ticketId" name="ticket_id">
                <textarea id="response" name="response" rows="4" placeholder="Enter your answer" required></textarea>
                <input type="submit" name="answer_ticket" value="Submit">
            </form>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("answerModal");

        // Open the modal when clicking on the "Answer" link
        function openModal(ticketId) {
            document.getElementById('ticketId').value = ticketId;
            modal.style.display = "block";
        }

        // Close the modal when clicking on the close button
        function closeModal() {
            modal.style.display = "none";
        }

        // Close the modal when clicking anywhere outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
