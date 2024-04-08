
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Ticket</title>
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

        h2 {
            color: #FFFFFF;
        }

        form {
            background-color: #0D1321; /* Background color of the form */
            padding: 20px;
            border-radius: 10px; /* Rounded corners for the form */
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); /* White box shadow */
            max-width: 400px; /* Adjust as needed */
            width: 100%;
        }

        label {
            color: #FFFFFF;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #0D1321; /* Background color of the input fields */
            border: 1px solid #FFFFFF;
            color: #FFFFFF;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }

        button[type="submit"] {
            background-color: #FFFFFF;
            color: #0D1321;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        a {
            color: #FFFFFF;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Submit a Ticket</h2>
    <form action="submit_ticket.php" method="POST">
        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" required></textarea><br>
        <button type="submit">Submit Ticket</button>
    </form>
    <a href="user_tickets.php">View your tickets</a>

    <?php
session_start(); 

// Include the database connection
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    if (empty($_POST['subject']) || empty($_POST['message'])) {
        echo "Please fill in all fields.";
    } else {
        // Get form data
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $user_id = $_SESSION['user_id']; // Get user ID from session

        // Insert ticket into database
        $sql = "INSERT INTO tickets (user_id, subject, message) VALUES ($user_id, '$subject', '$message')";
        if ($conn->query($sql) === TRUE) {
            echo "Ticket submitted successfully";
            header("Location: user_tickets.php");
            exit();


        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
</body>
</html>
