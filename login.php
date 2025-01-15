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
        button {
            padding: 0.8rem;
            margin: 0.5rem 0;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Choose Login Role</h1>
        <form method="post">
            <!-- Buttons to redirect the user to their respective login pages -->
            <button type="button" onclick="window.location.href='voter_login.php'">Login as Voter</button>
            <button type="button" onclick="window.location.href='candidate_login.php'">Login as Candidate</button>
        </form>
    </div>
</body>
</html>
