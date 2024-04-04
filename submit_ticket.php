<?php
// Kobler til databasen
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_ticket'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $user_id = 1; // For eksempel, antar at vi allerede har implementert pålogging og har brukerens ID

    // Legger til billetten i databasen
    $insert_query = "INSERT INTO tickets (user_id, subject, message) VALUES ('$user_id', '$subject', '$message')";
    if ($conn->query($insert_query) === TRUE) {
        echo "Billetten er sendt!";
    } else {
        echo "Feil under innsending av billett: " . $conn->error;
    }
}

// Lukker databasetilkoblingen
$conn->close();
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send inn billett</title>
</head>
<body>
    <div class="container">
        <form action="submit_ticket.php" method="post">
            <h2>Send inn billett</h2>
            <input type="text" name="subject" placeholder="Emne" required>
            <textarea name="message" rows="4" placeholder="Melding" required></textarea>
            <input type="submit" name="submit_ticket" value="Send inn billett">
        </form>
    </div>
</body>
</html>

