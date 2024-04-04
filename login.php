<?php
// Kobler til databasen
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Henter brukeren fra databasen basert på brukernavnet
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Sjekker om passordet er korrekt
        if (password_verify($password, $user['password'])) {
            if ($user['role'] == 'Admin') {
                header("Location: answer_ticket.php");
                exit();
            } else {
                header("Location: submit_ticket.php");
                exit();
            }
        } else {
            echo "Feil passord.";
        }
    } else {
        echo "Brukeren eksisterer ikke.";
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
    <title>Logg inn</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <div><form action="login.php" method="post">
            <h2>Logg inn</h2>
            <input type="text" name="username" placeholder="Brukernavn" required>
            <input type="password" name="password" placeholder="Passord" required>
            <input type="submit" name="login" value="Logg inn">
            <p><a href="register.php">Registrer her</a></p>
        </form>
    </div>        
    </div>
</body>

</html>