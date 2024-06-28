<?php
session_start();
if (!isset($_SESSION['username'])) {
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: url(../images/Background.png) no-repeat;
            background-size: cover; 
            background-attachment: fixed;
            margin: 0;
        }

        .logo {
            width: 120px;
            padding: 10px 20px;
        }

        .w3-xxxlarge {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            letter-spacing: 1px;
        }

        .w3-large {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #666;
            margin-top: 20px;
            letter-spacing: 0.5px;
        }

    </style>
</head>
<body>

<div class="w3-container w3-grey" >    
    <a class="w3-bar-item"><img class="logo" src="../images/CliNik_Logo.png"></a>
</div>

<nav class="w3-bar w3-grey">
    <div class="w3-bar-item w3-right">
        <a href="logout.php" class="w3-button">Logout</a>
    </div>
    <div class="w3-bar-item">
        <a href="services.php" class="w3-button">Services</a>
    </div>
</nav>

<div class="w3-container w3-white w3-round w3-card-4 w3-center w3-padding-32" style=" margin: auto; margin-top:140px; margin-bottom:140px; max-width: 800px; ">
    <h1 class="w3-xxxlarge">Welcome to My Clinic</h1>
    <p class="w3-large w3-text-grey">Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
</div>

<div class="w3-footer w3-grey" style="text-align: center; padding: 20px; bottom: 0; width: 100%;">
    <p>&copy; <?php echo date("Y"); ?> CliNik. All rights reserved.</p>
</div>

<script>
function toggleNavbar() {
  var x = document.getElementById("myNavbar");
  if (x.className.indexOf("responsive") === -1) {
    x.className += " responsive";
  } else {
    x.className = x.className.replace(" responsive", "");
  }
}
</script>

</body>
</html>
