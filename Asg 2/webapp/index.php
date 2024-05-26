<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CliNik - Home</title>
    <link rel="icon" href="../images/CliNik_Logo.png" type="image/png" />
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: url(../images/Background.png) no-repeat;
            background-size: cover; /* Cover the entire page */
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .navbar{
            position: fixed;
            height: 80px;
            width: 100%;
            top: 0;
            left: 0;
        }

        .navbar .logo{
            width: 90px;
            height: auto;
            padding: 20px 100px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .welcome-message {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logout-btn {
            background-color: #dcd405;
            color: black;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #b0aa04;
        }
    </style>
</head>
<body>

<nav class="navbar">
	<img class="logo" src="../images/CliNik_Logo.png">
</nav>

<div class="container">
    <div class="welcome-message">Welcome to My Clinic</div>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <br>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>