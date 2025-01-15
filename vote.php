<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['voter_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

$conn = new mysqli("localhost", "root", "", "online_voting_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch candidates grouped by positions
$sql = "SELECT c.candidate_id, c.name AS candidate_name, p.position_id, p.position_name 
        FROM candidates c
        INNER JOIN positions p ON c.position_id = p.position_id
        ORDER BY p.position_id, c.name";

$result = $conn->query($sql);

// Group candidates by position
$candidates_by_position = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidates_by_position[$row['position_name']][] = [
            'candidate_id' => $row['candidate_id'],
            'candidate_name' => $row['candidate_name']
        ];
    }
}

// Handle form submission when votes are cast
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voter_id = $_SESSION['voter_id']; // The logged-in voter
    $election_id = 1; // Example election ID
    $vote_time = date('Y-m-d H:i:s');

    // Prepare SQL statement to insert votes
    $vote_sql = $conn->prepare("INSERT INTO votes (voter_id, candidate_id, election_id, vote_time) VALUES (?, ?, ?, ?)");

    foreach ($_POST['votes'] as $position_id => $candidate_id) {
        if (!empty($candidate_id)) {
            $vote_sql->bind_param("iiis", $voter_id, $candidate_id, $election_id, $vote_time);
            $vote_sql->execute();
        }
    }

    $vote_sql->close();

    $message = "<p class='success'>Your votes have been cast successfully!</p>";

    // Redirect to view_results.php after successful voting
    header("Location: view_results.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Page</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: linear-gradient(to bottom right, #4CAF50, #2E7D32);
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .position-card {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f9f9f9;
        }

        .position-card h3 {
            margin: 0 0 10px 0;
            color: #2E7D32;
            font-size: 18px;
        }

        .position-card select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background: #ffffff;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #388E3C;
        }

        .message {
            text-align: center;
            font-size: 16px;
            margin-top: 15px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            .position-card h3 {
                font-size: 16px;
            }

            button {
                font-size: 14px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cast Your Vote</h2>

        <!-- Display success or error messages -->
        <?php if (isset($message)) echo "<div class='message'>$message</div>"; ?>

        <form method="post">
            <?php
            if (!empty($candidates_by_position)) {
                foreach ($candidates_by_position as $position => $candidates) {
                    echo "<div class='position-card'>";
                    echo "<h3>Position: {$position}</h3>";
                    echo "<select name='votes[{$position}]' required>";
                    echo "<option value=''>Select Candidate</option>";
                    foreach ($candidates as $candidate) {
                        echo "<option value='" . $candidate['candidate_id'] . "'>" . $candidate['candidate_name'] . "</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                }
            } else {
                echo "<p class='error'>No candidates available for voting.</p>";
            }
            ?>
            <button type="submit">Submit Votes</button>
        </form>
    </div>
</body>
</html>
