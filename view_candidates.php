<?php
$conn = new mysqli("localhost", "root", "", "online_voting_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all positions and their hierarchy order
$positions_result = $conn->query("SELECT position_id, position_name 
                                  FROM Positions 
                                  ORDER BY FIELD(position_name, 
                                      'President', 
                                      'Deputy President', 
                                      'Governor', 
                                      'Senator', 
                                      'Senator Assistance', 
                                      'County Commissioner', 
                                      'Women Representative', 
                                      'Member of Parliament')");

// Fetch candidates with their positions, elections, and aggregate votes
$sql = "SELECT c.name AS candidate_name, p.position_name, e.election_name, 
               COUNT(v.vote_id) AS vote_count 
        FROM Candidates c
        JOIN Positions p ON c.position_id = p.position_id
        JOIN Elections e ON c.election_id = e.election_id
        LEFT JOIN Votes v ON c.candidate_id = v.candidate_id
        GROUP BY c.candidate_id, p.position_name, e.election_name
        ORDER BY FIELD(p.position_name, 
                      'President', 
                      'Deputy President', 
                      'Governor', 
                      'Senator', 
                      'Senator Assistance', 
                      'County Commissioner', 
                      'Women Representative', 
                      'Member of Parliament'), 
                 vote_count DESC"; // Sort by position name and vote count descending
$candidates_result = $conn->query($sql);

$candidates_by_position = [];

if ($candidates_result->num_rows > 0) {
    // Grouping candidates by positions
    while ($row = $candidates_result->fetch_assoc()) {
        $candidates_by_position[$row['position_name']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Candidates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            overflow-y: auto;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1000px;
            text-align: center;
            overflow-x: auto;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .position-group {
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }
        .position-name {
            font-size: 22px;
            color: #4CAF50;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: left;
            padding-left: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            background-color: #fafafa;
        }
        .no-candidates {
            font-size: 18px;
            color: #f44336;
            padding: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            .position-name {
                font-size: 20px;
            }
            table, th, td {
                font-size: 14px;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .position-name {
                font-size: 18px;
            }
            table, th, td {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registered Candidates</h2>

        <?php
        if ($positions_result->num_rows > 0) {
            // Loop through positions and display each one
            while ($position = $positions_result->fetch_assoc()) {
                $position_name = $position['position_name'];
                
                // Display position name
                echo "<div class='position-group'>";
                echo "<div class='position-name'>" . htmlspecialchars($position_name) . "</div>";

                // Check if there are candidates for this position
                if (isset($candidates_by_position[$position_name]) && count($candidates_by_position[$position_name]) > 0) {
                    // Display table of candidates for this position
                    echo "<table>
                            <tr>
                                <th>Candidate Name</th>
                                <th>Election</th>
                                <th>Votes</th>
                            </tr>";
                    foreach ($candidates_by_position[$position_name] as $candidate) {
                        echo "<tr>
                                <td>" . htmlspecialchars($candidate['candidate_name']) . "</td>
                                <td>" . htmlspecialchars($candidate['election_name']) . "</td>
                                <td>" . htmlspecialchars($candidate['vote_count']) . "</td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    // No candidates registered for this position
                    echo "<p class='no-candidates'>No candidates registered yet for this position.</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p class='no-candidates'>No positions available.</p>";
        }
        ?>
    </div>
</body>
</html>
