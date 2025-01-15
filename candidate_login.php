<?php
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "online_voting_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Candidate's name and candidate_id (used as unique identifier)
    $name = $_POST["name"];
    $candidate_id = $_POST["candidate_id"];
    
    // Check if the candidate's name and candidate_id match the database
    $sql = "SELECT * FROM Candidates WHERE candidate_id = '$candidate_id' AND name = '$name'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // If valid, candidate is logged in
        $_SESSION['logged_in'] = true;
        $_SESSION['candidate_id'] = $candidate_id;
        $_SESSION['name'] = $name;
        header("Location: view_candidates.php");  // Redirect to candidates view page
        exit();
    } else {
        // If invalid credentials
        echo "<p>Invalid login details. Please try again.</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Login Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }
        input, select, button {
            width: 100%;
            padding: 0.8rem;
            margin: 0.5rem 0;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input:focus, select:focus, button:focus {
            outline: none;
            border-color: #007bff;
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Login Verification</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Enter your name" required><br>
            <input type="text" name="candidate_id" placeholder="Enter your candidate ID" required><br>
            <button type="submit">Verify Login</button>
        </form>
    </div>

</body>
</html>
