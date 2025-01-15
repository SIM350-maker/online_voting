<?php
session_start();

// Check if user is logged in (for voter access control)
if (!isset($_SESSION['voter_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

$conn = new mysqli("localhost", "root", "", "online_voting_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch votes grouped by position and candidate
$sql = "SELECT p.position_name, c.name AS candidate_name, COUNT(v.vote_id) AS total_votes
        FROM positions p
        LEFT JOIN candidates c ON p.position_id = c.position_id
        LEFT JOIN votes v ON c.candidate_id = v.candidate_id
        GROUP BY p.position_id, c.candidate_id
        ORDER BY p.position_id, total_votes DESC";

$result = $conn->query($sql);

$results = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[$row['position_name']][] = [
            'candidate_name' => $row['candidate_name'],
            'total_votes' => $row['total_votes']
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-top: 30px;
        }

        .results-container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .position-group {
            margin-bottom: 30px;
        }

        .position-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .message {
            text-align: center;
            font-size: 18px;
            color: red;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h2>Voting Results</h2>

    <div class="results-container">
        <?php
        if (!empty($results)) {
            foreach ($results as $position => $candidates) {
                echo "<div class='position-group'>";
                echo "<div class='position-title'>Position: " . htmlspecialchars($position) . "</div>";

                echo "<table>
                        <tr>
                            <th>Candidate Name</th>
                            <th>Total Votes</th>
                        </tr>";

                foreach ($candidates as $candidate) {
                    echo "<tr>
                            <td>" . htmlspecialchars($candidate['candidate_name']) . "</td>
                            <td>" . htmlspecialchars($candidate['total_votes']) . "</td>
                          </tr>";
                }

                echo "</table>";
                echo "</div>";
            }
        } else {
            echo "<p class='message'>No votes have been cast yet.</p>";
        }
        ?>
    </div>

</body>
</html>
