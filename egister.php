<?php
// Redirect to login.html
header("Location: login.html");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            text-align: center;
            padding: 50px;
        }
        button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 1.2rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Select Registration Type</h1>
    <button onclick="window.location.href='register_voter.php'">Register as Voter</button>
    <button onclick="window.location.href='register_candidate.php'">Register as Candidate</button>
</body>
</html>
