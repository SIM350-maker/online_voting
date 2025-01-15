<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General reset */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            padding: 0.8rem;
            margin: 0.5rem 0;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
        }
        button {
            padding: 0.8rem;
            margin-top: 1rem;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            color: red;
            margin-top: 1rem;
        }
        .success {
            color: green;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        $conn = new mysqli("localhost", "root", "", "online_voting_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Voters WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['voter_id'] = $row['voter_id'];
            echo "<p class='success'>Login successful!</p>";
            // Redirect to the voting page
            header("Location: vote.php");
        } else {
            echo "<p class='message'>Invalid login credentials.</p>";
        }
        $conn->close();
    }
    ?>

    <div class="container">
        <h1>Voter Login</h1>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
