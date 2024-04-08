

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrering</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <form action="register.php" method="post">
            <h2>Registrering</h2>
            <input type="text" name="username" placeholder="Brukernavn" required>
            <input type="password" name="password" placeholder="Passord" required>
            <input type="email" name="email" placeholder="E-post" required>
            <input type="submit" name="register" value="Registrer">
            <p><a href="login.php">Login inn her</a></p>
        </form>
    </div>

    <?php
session_start();

// Kobler til databasen
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Sjekker om brukernavnet allerede er i bruk
    $check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "Brukernavnet er allerede i bruk.";
    } else {
        // Legger til brukeren i databasen
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$hashed_password', '$email', 'User')";
        
        if ($conn->query($insert_query) === TRUE) {
            header("Location: submit_ticket.php");
            exit();
        } else {
            echo "Feil under registrering: " . $conn->error;
        }
    }
}

// Lukker databasetilkoblingen
$conn->close();
?>
</body>
</html>
