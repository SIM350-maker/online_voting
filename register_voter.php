<?php
$message = ""; // Initialize message variable
$eligibility_message = ""; // Initialize eligibility message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = md5($_POST["password"]);

    $conn = new mysqli("localhost", "root", "", "online_voting_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the voter data into the database
    $sql = "INSERT INTO Voters (name, email, phone_number, password) VALUES ('$name', '$email', '$phone', '$password')";
    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>Registration successful!</p>";

        // Eligibility logic
        // For now, all registered users are eligible to vote.
        $eligibility_message = "<p class='success'>You are eligible to vote in the upcoming elections!</p>";

        // Redirect to vote.php after successful registration
        header("Location: vote.php");
        exit(); // Ensure no further code is executed after redirection
    } else {
        $message = "<p class='message'>Error: " . $conn->error . "</p>";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        .container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .container form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .container form button {
            width: 100%;
            padding: 10px;
            background: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .container form button:hover {
            background: #4cae4c;
        }
        .message, .success {
            margin-top: 15px;
            font-size: 14px;
        }
        .message {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register to Vote</h1>
        <?php 
            echo $message; 
            echo $eligibility_message; 
        ?>
        <form method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
