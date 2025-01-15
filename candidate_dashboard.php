<?php
session_start();

if (!isset($_SESSION['candidate_id'])) {
    header("Location: login.php");
    exit;
}

// Database query for candidate-specific actions (e.g., confirming candidacy, deregistering, etc.)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Dashboard</title>
</head>
<body>
    <h1>Welcome Candidate</h1>
    <p>Select an action:</p>
    <button onclick="window.location.href='confirm_candidacy.php'">Confirm Candidacy</button>
    <button onclick="window.location.href='deregister_candidate.php'">Deregister Candidacy</button>
</body>
</html>
