<?php
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
            header("Location: login.html");
            exit();
        } else {
            echo "Feil under registrering: " . $conn->error;
        }
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
    <title>Registrering</title>
</head>
<body>
    <div class="container">
        <form action="register.php" method="post">
            <h2>Registrering</h2>
            <input type="text" name="username" placeholder="Brukernavn" required>
            <input type="password" name="password" placeholder="Passord" required>
            <input type="email" name="email" placeholder="E-post" required>
            <input type="submit" name="register" value="Registrer">
        </form>
    </div>
</body>
</html>
