
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $position_id = $_POST["position_id"];
    $election_id = $_POST["election_id"];

    $conn = new mysqli("localhost", "root", "", "online_voting_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO Candidates (name, position_id, election_id) 
            VALUES ('$name', '$position_id', '$election_id')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to view_candidates.php
        header("Location: view_candidates.php");
        exit();  // Stop further code execution
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Candidate</title>
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
        .message {
            text-align: center;
            color: red;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Register as a Candidate</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Candidate Name" required><br>
            
            <select name="position_id" required>
                <option value="">Select Position</option>
                <?php
                // Fetch positions from the database
                $conn = new mysqli("localhost", "root", "", "online_voting_db");
                $result = $conn->query("SELECT * FROM Positions");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['position_id'] . "'>" . $row['position_name'] . "</option>";
                }
                $conn->close();
                ?>
            </select><br>
            
            <select name="election_id" required>
                <option value="">Select Election</option>
                <?php
                // Fetch elections from the database
                $conn = new mysqli("localhost", "root", "", "online_voting_db");
                $result = $conn->query("SELECT * FROM Elections");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['election_id'] . "'>" . $row['election_name'] . "</option>";
                }
                $conn->close();
                ?>
            </select><br>
            
            <button type="submit">Register Candidate</button>
        </form>
    </div>

</body>
</html>
